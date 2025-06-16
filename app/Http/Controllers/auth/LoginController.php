<?php

namespace App\Http\Controllers\Auth;

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
    public function loginWeb(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Buat token Sanctum langsung setelah login
            $token = $user->createToken('web_token')->plainTextToken;

            // Simpan token di session, atau kirim ke Blade untuk disimpan di localStorage
            session(['api_token' => $token]);

            if ($user->role === 'owner') {
                return redirect()->route('dashboard')->with('token', $token);
            } elseif ($user->role === 'karyawan') {
                return redirect()->route('transaksi-karyawan')->with('token', $token);
            }

            return redirect()->route('dashboard')->with('token', $token);
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function index(){
        return view('login');
    }

    /**
     * Handle login request via API
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        // Hapus token lama sebelum membuat yang baru (opsional)
        $user->tokens()->delete();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role // Pastikan role ada dalam model User
            ]
        ], 200);
    }

    /**
     * Show token lupa password form
     */
    public function showTokenLupaPasswordForm(Request $request)
    {
        $email = $request->query('email', '');
        return view('token-lupa-password', ['email' => $email, 'token' => '']);
    }

    /**
     * Logout API
     */
    public function logout(Request $request)
    {
        // Menghapus semua token user saat logout
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $user->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout successful'
        ], 200);
    }

    public function logoutWeb(Request $request)
{
    Auth::logout(); // Menghapus session
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
}


    public function showForgotPasswordForm(){
        return view('lupa-password');
    }

    /**
     * Handle Forgot Password Request via API
     */
    public function handleForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        // Kirim email dengan token reset
        Mail::to($user->email)->send(new \App\Mail\PasswordResetMail($token));

        return response()->json([
            'success' => true,
            'message' => 'Password reset token has been sent to your email'
        ], 200);
    }

    /**
     * Validate Token via API
     */
    public function handleTokenValidation(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record || !Hash::check($request->token, $record->token) || now()->diffInMinutes($record->created_at) > 10) {
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid or expired'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Token is valid'
        ], 200);
    }

    public function showResetPasswordForm(){
        return view('reset-password');
    }

    /**
     * Reset Password via API
     */
    public function handleResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        // Hash password baru sebelum menyimpannya
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token reset password setelah digunakan
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password has been reset successfully'
        ], 200);
    }
}
