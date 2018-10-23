<?php

namespace App\Http\Controllers\Api;

use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    use IssueTokenTrait;

    private $client;

    public function __construct()
    {
        $this->client = \Laravel\Passport\Client::find(2);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return $this->issueToken($request, 'password');
    }

    public function login(Request $request)
    {
        // Validate Inputs
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        return $this->issueToken($request, 'password');
    }

    public function refresh(Request $request)
    {
        // Validate Inputs
        $this->validate($request, [
            'refresh_token' => 'required'
        ]);

        return $this->issueToken($request, 'refresh_token');
    }

    public function logout()
    {
        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);

        $accessToken->revoke();

        return response()->json([], 204);
    }
}
