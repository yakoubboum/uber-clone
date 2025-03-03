<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pnlinh\InfobipSms\Facades\InfobipSms;
use App\Notifications\LoginNeedsVerification;

class LoginController extends Controller
{
    public function submit(Request $request)
    {

        $verificationCode = rand(100000, 999999);
        $request->validate([
            'phone' => 'required|numeric|min:10',
            'name' => 'required'
        ]);


        // Find or create a user model
        $user = User::firstOrCreate([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        if (!$user) {
            return response()->json(['message' => 'Could not process a user with that phone number.'], 401);
        }
        $user->login_code = $verificationCode;
        $user->save();
        // send the user a one-time use code
        // InfobipSms::send($request->phone, $verificationCode);
        $user->notify(new LoginNeedsVerification($verificationCode));

        // return back a response
        return response()->json(['message' => 'Text message notification sent.']);
    }

    public function verify(Request $request)
    {

        // validate the incoming request
        $request->validate([
            'phone' => 'required|numeric|min:10',
            'login_code' => 'required|numeric|between:111111,999999'
        ]);

        // find the user
        $user = User::where('phone', $request->phone)
            ->where('login_code', $request->login_code)
            ->first();

        // is the code provided the same one saved?
        // if so, return back an auth token
        if ($user) {
            $user->update([
                'login_code' => null
            ]);

            return $user->createToken($request->login_code)->plainTextToken;
        }

        // if not, return back a message
        return response()->json(['message' => 'Invalid verification code.'], 401);
    }
}
