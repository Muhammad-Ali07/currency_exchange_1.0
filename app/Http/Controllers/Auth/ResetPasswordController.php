<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm($token) {

        $user = DB::selectOne("SELECT * FROM `password_resets` where token = '$token'");
        if(empty($user)){
            abort('404');
        }
        $email = $user->email;
        return view('auth.passwords.reset', ['email' => $email,'token' => $token]);

    }

    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $user = User::where('email', '=', $request->email)->first();

        if(isset($user->id)){

            $user->password = bcrypt($request['password']);
            $user->save();

        }
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        $response = '';
        return isset($user->id)
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    public function sendResetResponse(Request $request)
    {
        $data = [
            'status' => 'success',
            'url' => route('home'),
            'message' => 'Password reset successfully'
        ];
        return response()->json($data);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        $data = [
            'status' => 'error',
            'message' => "Something went to wrong"
        ];
        return response()->json($data);
    }

}
