<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function abort;
use function compact;
use function cookie;
use function response;

class AuthController extends Controller{


    public function register(Request $request){
        $user = User::create(
            $request->only('first_name', 'last_name', 'email', 'is_admin')
            + [
                'password' => \Hash::make($request->input('password')),
            ]
        );

        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request){
        if (!\Auth::attempt($request->only('email', 'password'))) {
            return response([
                'error' => 'invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = \Auth::user();
        $adminLogin = $request->input('scope');

        if ( $adminLogin === 'admin' && !$user->is_admin) {
            return response([
                'error' => 'Access Denied!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('token', [$request->input('scope')])->plainTextToken;

        return compact('token');
    }

    public function user(Request $request){
        $user = $request->user();
        return $user;
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return response([
            'message' => 'success'
        ]);
    }

    public function updateInfo(Request $request){
        $user = $request->user();

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(Request $request){
        $user = $request->user();

        $user->update([
            'password' => \Hash::make($request->input('password'))
        ]);

        return response($user, Response::HTTP_ACCEPTED); #####
    }

    public function scopeCan(Request $request, $scope){
        if (!$request->user()->tokenCan($scope)) {
            abort(401, 'unauthorized');
        }

        return 'ok';
    }

}
