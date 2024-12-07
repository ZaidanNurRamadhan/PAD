<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Display the login form.
     */
    public function index()
    {
        return view('login');
    }
   /**
     * Handle the login request and redirect based on role.
     */
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|string',
        'password' => 'required|string',
    ]);

    if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect berdasarkan peran pengguna
        if ($user->role === 'owner') {
            return redirect()->route('dashboard');
        } elseif ($user->role === 'karyawan') {
            return redirect()->route('transaksi-karyawan');
        }
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}

    public function lupa_password(){
        return view('lupa-password');
    }

    public function showForgotPasswordForm()
    {
        return view('lupa-password');
    }

    public function handleForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        $token = Str::random(10);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        Mail::to($user->email)->send(new \App\Mail\PasswordResetMail($token));
        return redirect()->route('password.token.form', ['email' => $user->email, 'token' => $token])->with('status' , 'Kami telah mengirimkan kode verifikasi reset password ke email Anda!');
    }

    public function showTokenForm($email, $token)
    {
        return view('token-lupa-password', compact('email', 'token'));
    }

    public function handleTokenValidation(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ]);

        $record = DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->where('token', $request->token)
                    ->first();

        if (!$record || now()->diffInMinutes($record->created_at) > 10) {
            return redirect()->back()->withErrors(['token' => 'Token tidak valid atau sudah kedaluwarsa']);
        }

        session(['reset_email' => $request->email]);

        return redirect()->route('password.reset');
    }

    public function showResetPasswordForm()
    {
        $email = session('reset_email');
        return view('reset-password',compact('email'));
    }

    public function handleResetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        return redirect()->route('login')->with('status', 'Password berhasil diperbarui!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
