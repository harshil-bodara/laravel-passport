<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    
    public function register(Request $request) {
        $validator = Validator::make($request->all(),[
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $user->sendEmailVerificationNotification();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $response = ['request' => $request->except('password','password_confirmation'), 
            'token' => $token,"message"=>"Registration successful."];
        return response($response, 200);
    }


    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);        
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('u_email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token,"message"=>"Login successful."];
                return response($response, 200);
            } else {
                $response = ["message" => "The passwords do not match."];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'This user does not exist'];
            return response($response, 422);
        }
    }


    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'Logout successfull.'];
        return response($response, 200);
    }


    protected function sendResetLinkResponse(Request $request) {
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email"
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $response =  Password::sendResetLink($input);
        if($response == Password::RESET_LINK_SENT){
            $message = "Mail send successfully";
        }else{
            $message = "E-Mail could not be sent to this address.";
        }
        $response = ['message' => $message];
        return response($response, 200);
    }


    protected function sendResetResponse(Request $request) {
        $input = $request->only('email', 'password', 'token','password_confirmation');
        $validator = Validator::make($input, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $response = Password::reset($input, function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
            event(new PasswordReset($user));
        });
        if($response == Password::PASSWORD_RESET){
            $message = "Password reset successfully";
        }else{
            $message = "E-Mail could not be sent to this email address";
        }
        $response = ['message' => $message];
        return response()->json($response);
    }


    public function verify(Request $request) {
        $userID = $request['id'];
        $user = User::findOrFail($userID);
        $date = date('Y-m-d g:i:s');
        $user->email_verified_at = $date;
        $user->save();

        return redirect()->away('http://localhost:3000/login');
        return Redirect::to('http://localhost:3000/login');
        return view('EmailVerified');
        return response()->json(['message' => 'Your E-Mail has been verified.']);
    }
}
