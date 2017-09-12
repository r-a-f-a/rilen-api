<?php

namespace Api\Controllers;

use App\Api\Models\User;
use App\Api\Models\UserModel;
use Dingo\Api\Facade\API;
use Illuminate\Http\Request;
use Api\Requests\UserRequest;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends ApiBtgController
{
    public function userView(Request $request)
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function validateToken()
    {
        return API::response()->array(['status' => 'success'])->statusCode(200);
    }

    public function register(UserRequest $request)
    {
        $newUser = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ];
        $user = User::create($newUser);
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'));
    }

    public function auto(Request $request)
    {
        $user = UserModel::find(1);
        return $token = JWTAuth::fromUser($user);
    }

    //AuthController
    public function token()
    {
        $token = JWTAuth::getToken();
        if (!$token) {
            throw new BadRequestHtttpException('Token not provided');
        }
        try {
            $token = JWTAuth::refresh($token);
        } catch (TokenInvalidException $e) {
            throw new AccessDeniedHttpException('The token is invalid');
        }
        return $this->response->withArray(['token' => $token]);
    }

    public function cross(Request $request)
    {
        $params = $request->only('token');
        $hash = explode(':',base64_decode($params['token']));
        $token = base64_decode($hash[0]);
        $expire = base64_decode($hash[1]);

        if($expire >=  time()){
            $user = UserModel::where('token', '=', $token)->first();
            $return['token'] = JWTAuth::fromUser($user);
            return response()->json($return);
        }
        return response()->json(['error' => 'token_expired'], 400);


    }

    public function crossLink(Request $request)
    {
        $params = $request->only('token');
        $expire = time() + 3600;
        $return['hash'] = base64_encode(base64_encode($params['token']).':'.base64_encode($expire));
        return response()->json($return);
    }


}
