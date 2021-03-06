<?php

namespace App\Http\Controllers;

use App\Permissions;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function updatetoken()
    {
        $user = User::find(Auth::id());
        $s = $user->generateToken();

        return response()->json(['message' => $s], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => ['string']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::query()
            ->where('name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('email', 'LIKE', '%' . $request->search . '%')
            ->get(['name', 'email', 'id']);

        return response()->json(['message' => $user], 200);
    }

    /**
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function permissions()
    {
        $this->authorize('write', Role::class);

        $permissions = new Permissions;
        return response()->json(['message' => $permissions->getAllPermissions()], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function UpdateSelectableUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['integer'],
            'user_id' => ['integer']
        ]);

        if ($validator->fails()) {
            abort(403);
        }

        if($request->user_id != Auth::id()){
            abort(403);
        }

        $user = User::findOrFail($request->user_id);

        if (!in_array($request->id, Role::query()->where("selectable", true)->get(["id"])->toArray())) {
            abort(403);
        }

        $user->role_id = $request->id;
        $user->update();

        return response()->json(['message' => "Role Edited"], 200);
    }

    public function isLoggedIn(){

        return response()->json(Auth::check(), 200);

    }
}
