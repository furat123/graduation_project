<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AuthController;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request)
    {

      //  $user =array_filter($request->except(['created_at','updated_at','password', '']));

//        if(!is_null($user['password'])){
//            $user['password'] = bcrypt($user['password']);
//        }
        $user = auth()->user();
        if(is_null($user)){
            return response()->json("not authenticated user" , 404);
        }

        if(!Hash::check($request['password'], $user->password)) {
            return response([
                'message' => 'password incorrect .'
            ], 403);
        }

        $fields = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|string|email',
        ], [
            'email.unique' => 'Sorry, This Email Address Is Already Used By Another User. Please Try With Different One, Thank You.'
        ]);
        $users = User::where('email', '=', $request['email'])->first();
        if(!is_null($users)){
            return response()->json('Sorry, This Email Address Is Already Used By Another User. Please Try With Different One, Thank You.',409);
        }
        if ($request->has(['email'])) {
                $user->email = $request['email'];
            }
        if ($request->has(['name'])) {
            $user->name = $fields['name'];
        }

        $user->save();
        return response()->json("user updated" , 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
