<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class CheckProject
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        $data = User::with('projects')->where('id',auth()->user()->id)->first();

        if(count($data->projects) == 0){
            session(['user_project' => $data->project_id]);

        }else{
            if(!session()->has('user_project')){
                return redirect()->route('projectList');
            }
        }

        return $next($request);
    }
}
