<?php

namespace App\Http\Controllers;

use App\Congress;
use App\Event;
use App\EventSettings;
use App\Http\Requests\UserUpdateValidationRequest;
use App\Mail\NotifyUserOfEventsMail;
use App\Program;
use App\RegistrationEvents;
use App\Role;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('read', Event::class);

        $s = Event::query()
            ->with('settings')
            ->with('program')
            ->with('program.programItems')
            ->with('congress')
            ->with('congress.block')
            ->with('congress.block.items')
            ->get();

        return response()->json($s, 200);
    }

    /**
     * @param Event $event
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function event(Event $event)
    {
        $this->authorize('read', Event::class);
        $this->authorize('read', EventSettings::class);
        $this->authorize('read', Program::class);
        $this->authorize('read', Congress::class);

        $s = Event::query()
            ->where('id', $event->id)
            ->with('settings')
            ->with('program')
            ->with('program.programItems')
            ->with('congress')
            ->with('congress.block')
            ->with('congress.block.items')
            ->first();

        return response()->json($s, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @throws AuthorizationException
     */
    public function excel(Request $request){

        $this->authorize('write', User::class);

        $data = [ 'data' => $request->all() ];

        $validator = Validator::make($data, [
            'data.*.name' => ['required', 'string'],
            'data.*.email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'data.*.role' => ['required', 'string'],
            'data.*.password' => ['required', 'string', 'min:8']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        foreach ($data["data"] as $obj){

            $role = Role::query()->where('role_name', $obj["role"])->first();

            if($role == null) {
                return response()->json('Role not found', 200);
            }

            $user = new User;
            $user->name = $obj->name;
            $user->email = $obj->email;
            $user->password = $obj->password;
            $user->role_id = $role->id;
        }

        return response()->json(['message' => 'Successfully uploaded the excel'], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function search(Request $request)
    {
        $this->authorize('read', User::class);
        $this->authorize('read', Role::class);

        $validator = Validator::make($request->all(), [
            'search' => ['string']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::query()
            ->where('name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('email', 'LIKE', '%' . $request->search . '%')
            ->with('role')
            ->get();

        return response()->json(['message' => $user], 200);
    }

    /**
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function deleteUser(User $user){
        $this->authorize('write', User::class);

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    /**
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function user(User $user){
        $this->authorize('write', User::class);

        $user->makeVisible(['role_id']);

        return response()->json($user, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function program($id){

        $this->authorize('read', Program::class);

        $s = Program::query()
            ->where('id', $id)
            ->with('programItems')
            ->first();

        return response()->json($s, 200);

    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function congress($id){

        $this->authorize('read', Congress::class);

        $s = Congress::query()
            ->where('id', $id)
            ->with('block')
            ->with('block.items')
            ->first();

        return response()->json($s, 200);

    }

    /**
     * this code is duplicated but Artisan::call doesnt reconize the command and can not find and execute so this works for now
     * @return JsonResponse
     * @throws Exception
     */
    public function forceNotify(){

        $this->authorize('notify', User::class);

        $events = Event::query()
            ->with('settings')
            ->has('settings')
            ->get();

        foreach ($events as $event) {
            $week = Carbon::now()->addWeek();
            $sixDays = $week->copy()->subDay();
            if (Carbon::create($event->settings->date_start)->between($week, $sixDays)) {
                $subscriptions = RegistrationEvents::query()
                    ->where('event_id', $event->id)
                    ->get();
                foreach ($subscriptions as $subscription) {
                    $user = User::findOrFail($subscription->user_id);
                    Mail::to($user->email)->queue(new NotifyUserOfEventsMail($event));
                }
            }

            $now = Carbon::now();
            $oneDay = $now->copy()->addDay();
            if (Carbon::create($event->settings->date_start)->between($now, $oneDay)) {
                $subscriptions = RegistrationEvents::query()
                    ->where('event_id', $event->id)
                    ->get();
                foreach ($subscriptions as $subscription) {
                    $user = User::findOrFail($subscription->user_id);
                    Mail::to($user->email)->queue(new NotifyUserOfEventsMail($event));
                }
            }
        }

        return response()->json(['message' => 'Successfully notified users'], 200);
    }

    /**
     * @param UserUpdateValidationRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function updateUser(UserUpdateValidationRequest $request, User $user){

        $this->authorize('AdminUser', User::class);

        $user = User::findOrFail($user->id);
        $user->update($request->all());

        return response()->json(['message' => 'User updated successfully'], 200);

    }
}
