<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Library\LibLogEmail;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $user = User::where('email', '=', $request->email)->first();

        if(isset($user->id)){
            $data = [];
            $token = Str::random(40);

            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => date("Y-m-d H:i:s")
            ]);

            $data['name'] = ucwords(strtolower(strtoupper($user->name)));
            $data['url'] = route('password.forgetPassword',$token);
            $data['email'] = $user->email;


            Mail::to($data['email'])->send(new \App\Mail\ForgotEmail($data));

            // dd($response);
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            /* $response = $this->broker()->sendResetLink(
                 $this->credentials($request)
             );*/
        }

        $response = '';
        return isset($user->id)
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        $data = [
            'status' => 'success',
            'url' => route('login'),
            'message' => 'Password reset successfully'
        ];
        return response()->json($data);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        $data = [
            'status' => 'error',
            'message' => "Something went to wrong"
        ];
        return response()->json($data);
    }

}
