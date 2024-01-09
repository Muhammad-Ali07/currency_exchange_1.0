<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class checkBranch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $data = User::with('branch')->where('id',auth()->user()->id)->first();

        if($data->branch != ''){
            session(['user_branch' => $data->branch->id]);
        }else{
            if(!session()->has('user_branch')){
                return redirect()->route('projectList');
            }
        }

        return $next($request);
    }
}
