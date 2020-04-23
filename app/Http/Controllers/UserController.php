<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function updatetoken()
    {
        $user = User::find(Auth::id());
        $user->api_token = Hash::make(Str::random(120), [
            'memory' => 1024,
            'time' => 2,
            'threads' => 2,
        ]);
        $user->api_token_expired_date = Carbon::now()->addHour();
        $user->update();

        return response()->json(['message' => $user->api_token], 200);
    }
}