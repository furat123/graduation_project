<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{



    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = sha1(time());
        $verifyUser = VerifyUser::create([
            'id' => $user->id,
            'token' => $token
        ]);

        $to_name = $request['name'];
        $to_email = 'mohanadimad9@gmail.com'; // my email just for testing
        $data = array(
            'name'=> $to_name,
            'body' => 'A test mail',
            'token' => $token
        );
        Mail::send('mails.exmpl', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Email Verification');
            $message->from('hay55project@gmail.com','Hay5 Team');
        });
        // send token for testing
        return response()->json([
            'message'=>'verification Email Sent. Check your inbox',
            'token' => $token
        ] , 201);



    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

     //  $token = $user->createToken('hi5Token', ['canLogout'])->plainTextToken;
        $token = $user->createToken('hi5Token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
//        if(auth()->user()->tokencan('canLogout')) {
            auth()->user()->tokens()->delete();
  //      }else {
//            return response()->json([
//                'msg' => 'unautharized'
//            ] , 204);
    //    }
        //$request->user()->currentAccessToken()->delete();
        return response([
            'msg' => 'logout success'
        ] , 201);
    }

    public function who(Request $request){
        $user = auth()->user();
        return $user['id'];
    }


    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();

        if(isset($verifyUser) ){
            $user = User::where('id', $verifyUser['id'])->first();
            print(time());
            if(is_null($user->email_verified_at)) {
                $user->email_verified_at =  date('Y-m-d', time());
                $user->save();
                $status = "Your e-mail is verified. You can now login.";
            } else {
                $status = "Your e-mail is already verified. You can now login.";
            }
        } else {
            // return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
            return response()->json(['msg'=>'ther is no user have this token '] , 404);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);

        // return redirect('https://codebriefly.com/custom-user-email-verification-activation-laravel/')->with('status', $status);
        //  return response()->json(['msg' => $status] ,200);
        //   return redirect()->away('https://www.google.com');
    }
}
//kjlasdfk
