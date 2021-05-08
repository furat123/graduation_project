<?php

namespace App\Http\Controllers;


use App\Models\password_reset;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use function PHPUnit\Framework\isNull;

class AuthController extends Controller
{



    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed|min:6'
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
        $to_email = $request['email']; // my email just for testing
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
        if(is_null($user['email_verified_at'])){
            return response([
                'message' => 'email not verficated'
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
            print(now());
            if(is_null($user->email_verified_at)) {
                $user->email_verified_at =  now();
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

      return  redirect('https://www.google.com')->with('status', $status);

      //    return response()->json(['msg' => $status] ,200);
        //  return redirect()->away('https://www.google.com');
    }



    public function send_email_password(Request $request){

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|confirmed|min:6'
        ]);

        $token = bcrypt(now());
        password_reset::create([
            'email' => $fields['email'],
            'token' => $token,
            'password' => bcrypt($fields['password']),
            'created_at' => now()
        ]);

        $user = User::where('email', $fields['email'])->first();

        $to_name = $user['name'];
        $to_email = 'mohanadimad9@gmail.com'; // my email just for testing
        $data = array(
            'name'=> $to_name,
            'token' => $token,
        );

        Mail::send('mails.reset', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Reset Password');
            $message->from('hay55project@gmail.com','Hay5 Team');
        });

        return response()->json('email sent check your inbox');
    }




    public  function reset_password($token){

        $raw = password_reset::where('token', $token)->first();

        $user = User::where('email' , $raw['email'])->first();
       if(is_null($user) ){
           return response()->json('invalid user ' , 404);
       }
        $password = $raw['password'];
        $user->password = $password;
        $user->save();

       password_reset::where('email', $raw['email'])->delete();
       return redirect('https://google.com');
    }


}

