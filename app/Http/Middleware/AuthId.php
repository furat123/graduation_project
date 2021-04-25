<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\ModelTblController;
use App\Models\model_tbls;

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
       $rc = new ModelTblController();
       $user = $request->user();
       $idModel = $request->route('id');
       print($idModel);
       $responsefromuser =  $rc->show($idModel)->status();
       print($responsefromuser);
       if($responsefromuser== 404)
           return response()->json(['msg' => 'model not found',
           ] ,404);

        if($user['id'] != $rc->show($idModel)->getData()->owner_id)
            return response()->json(['msg' => 'not authorized to use this model',
            ] , 403);

        return $next($request);
    }
}
