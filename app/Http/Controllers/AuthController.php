<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;



class AuthController extends Controller {

  public function login()
  {
    try {

      if (!$token = JWTAuth::attempt(request()->only('email', 'password'))) {
        return response()->json(['message' => 'Username or password is invalid']);
      }
      return response()->json(['message' => 'Login successful', 'token' => $token ]);

    }
    catch (JWTException $e) {
      return response()->json(['message' => 'Evil error occured', 'error' => $e ]);
    }
  }
}
