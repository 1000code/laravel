<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'ກະລຸນາປ້ອນອີເມວ',
                'email.email' => 'ກະລຸນາປ້ອນອີເມວທີ່ຖືກຕ້ອງ',
                'password.required' => 'ກະລຸນາປ້ອນລະຫັດຜ່ານ',
            ]
        );

        if (
            auth()->attempt([
                'email' => $request['email'],
                'password' => $request['password'],
            ])
        ) {
            if (auth()->user()->isAdmin >= 1) {
                if (auth()->user()->isAdmin === 'admin') {
                    return redirect()->route('admin');
                } else {
                    // return redirect()->route('staff');
                }
            } else {
                return redirect()
                    ->route('login')
                    ->with('error', 'ບັນຊີຂອງທ່ານຖືກລະງັບການໃຊ້ງານ');
            }
        } else {
            return redirect()
                ->route('login')
                ->with('error', 'ຊື່ຜູ້ໃຊ້ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ');
        }
    }
}
