<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AccessNotApproved
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
        if($request->route('book')->is_approved){
            return $next($request);
        }

        if(Gate::allows('is-book-owner', $request->route('book')->id)){
            return $next($request);
        }

        return redirect('/');
    }
}
