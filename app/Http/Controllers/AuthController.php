<?php

namespace App\Http\Controllers;

use App\Jobs\EmailJob;
use App\Library\Services\Jwt_Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function register(Jwt_Token $token, Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
        try {
            $emailToken = $token->emailToken(time());
            $url = url('emailConfirmation/' . $request->email . '/' . $emailToken);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_token' => $emailToken,
            ]);
            if (isset($user)) {
                EmailJob::dispatch($request->email, $url, $request->name)->delay(now()->addSeconds(10));
                return redirect('register')->with('register', 'Registered Successfully. Kindly Verfiy your Account');
            } else {
                $request->flash();
                return redirect('/register')->withInput();
            }
        } catch (Throwable $e) {
            return response(['message' => $e->getMessage() . " Line No. " . $e->getLine()]);
        }
    }

    public function verify($email, $hash)
    {
        try {
            $userExist = User::where('email', $email)->first();
            if (!isset($userExist)) {
                return redirect('/login')->with('verify', 'Something went wrong');
            } elseif ($userExist->email_verified_at != null) {
                return redirect('/login')->with('verify', 'Link has been Expired');
            } elseif ($userExist->email_token != $hash) {
                return redirect('/login')->with('verify', 'Unauthenticated');
            } else {
                $userExist->email_verified_at = time();
                $userExist->save();
                return redirect('/login')->with('verify', 'Account Verified. Now you can Login');
            }
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage() . " Line No. " . $e->getLine()]);
        }
    }

    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (($request->email != $user->email) or (!Hash::check($request->password, $user->password))) {
                return redirect('login')->with('login', 'Incorrect Credentials');
            } else {
                $request->session()->put([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
                return redirect('home')->with('success', 'You are Logged in Successfully');
            }
        } catch (Throwable $e) {
            return response(['message' => $e->getMessage() . " Line No. " . $e->getLine()]);
        }
    }

    public function index()
    {
        if (session()->has('user_id')) {
            return view('home');
        } else {
            return redirect('login')->with('login', 'Login First');
        }
    }
}
