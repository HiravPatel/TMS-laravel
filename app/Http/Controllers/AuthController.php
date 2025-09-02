<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Send_otp;
use App\Rules\email;
use App\Rules\contact;
use App\Rules\password;
use App\Rules\OnlyAlpha;
use App\Mail\send_password;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;

class AuthController extends Controller
{
    public function showSignupForm()
    {
        $roles = Role::all();
        return view('addemployee',['activePage' => 'addemployee'], compact('roles'));
    }

   public function signup(Request $request)
{
    $request->validate([
        'name'     => ['required',new OnlyAlpha],
        'email'    => ['required','email','unique:users',new email],
        'cno'      => ['required',new contact],
        'role_id'  => 'required|exists:roles,id',
    ]);

    $randomPassword = Str::random(8);

    $role = Role::find($request->role_id);

    $user = User::create([
        'name'        => $request->name,
        'email'       => $request->email,
        'cno'         => $request->cno,
        'role_id'     => $request->role_id, 
        'password'    => bcrypt($randomPassword),
        'first_login' => 1,
    ]);

    Mail::to($user->email)->send(new send_password($user, $randomPassword, $role->role));

    return redirect()->route('addemployee')->with('success', 'Member added successfully and credentials sent via email.');
}

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->first_login == 1) {
            return redirect()->route('changePasswordForm');
        }

        return redirect()->route('dashboard');
    }

    return back()->withErrors(['email' => 'Invalid email or password']);
}


    public function showChangePasswordForm()
    {
        return view('change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email'           => 'required|email|exists:users,email',
            'password'        => ['required','min:6','max:8','confirmed',new password]
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->password = bcrypt($request->password);
            $user->first_login = 0; 
            $user->save();

        Auth::logout();

        return redirect()->route('login')->with('success', 'Password changed successfully. Please log in.');
        }

        return back()->withErrors(['email' => 'User not found']);
    }

    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'You have been logged out.');
}

public function showForgotPasswordForm()
{
    return view('forgot-password'); 
}

public function sendOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $user = User::where('email', $request->email)->first();

    $otp = rand(100000, 999999);

     Send_otp::updateOrCreate(
        ['email' => $user->email],
        [
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(5),
        ]
    );

    Mail::to($user->email)->send(new SendOtpMail($user, $otp));

    return redirect()->route('verifyOtpForm')->with('success', 'OTP sent to your email.');
}
public function showVerifyOtpForm()
{
    return view('verify-otp'); 
}

public function verifyOtp(Request $request)
{
    $request->validate([
        'email'    => 'required|email|exists:users,email',
        'otp'      => 'required|digits:6',
        'password' => ['required','min:6','max:8','confirmed', new password],
    ]);

    $record = Send_otp::where('email', $request->email)
        ->where('otp', $request->otp)
        ->where('expires_at', '>', now())
        ->first();

    if (!$record) {
        return back()->withErrors(['otp' => 'Invalid or expired OTP']);
    }

    $user = User::where('email', $request->email)->first();
    $user->password = bcrypt($request->password);
    $user->save();

    // Send_otp::where('email', $request->email)->delete();

    return redirect()->route('login')->with('success', 'Password reset successfully. Please login.');
}

}
