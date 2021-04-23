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
    //k
    public function handle(Request $request, Closure $next)
    {
       $rc = new ModelTblController();
       $user = $request->user();
       $idModel = $request->input('id');
        if($user['id'] != $rc->show($idModel)->getData()->owner_id)
            return response()->json(['msg' => 'not valid id',
            ]);

        return $next($request);
    }
}
