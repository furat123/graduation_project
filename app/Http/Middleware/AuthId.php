<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Relation\RelationsController;
class AuthId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       $rc = new RelationsController();
       $user = $request->user();
       $idModel = $request->input('id');
        //print($idModel);
       print_r($rc->HasOneRelationReverse($idModel)->getData('id'));
        if($user['id'] != $rc->HasOneRelationReverse($idModel)->getData('id') )
            return response()->json(['msg' => 'not valid id',
            ]);

        return $next($request);
    }
}
