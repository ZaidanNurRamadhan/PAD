<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
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
<<<<<<< HEAD
    public function login(Request $request)
{
    $credentials = $request->validate([
        'name' => 'required|string',
        'password' => 'required|string',
    ]);

    if (Auth::attempt(['name' => $credentials['name'], 'password' => $credentials['password']])) {
        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect berdasarkan peran pengguna
        if ($user->role === 'owner') {
            return redirect()->route('dashboard');
        } elseif ($user->role === 'karyawan') {
            return redirect()->route('transaksi-karyawan');
=======
    public function store(Request $request)
    {
        // Validate the login credentials
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        // Attempt to authenticate and login the user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect based on user role
            $user = Auth::user();
            if ($user->role === 'owner') {
                return redirect()->route('dashboard');
            } elseif ($user->role === 'karyawan') {
                return redirect()->route('gudang-karyawan');
            }
>>>>>>> 6ce463685d1ac55b573310d3257e08c1b7aa3930
        }
    }

<<<<<<< HEAD
    return back()->withErrors([
        'name' => 'The provided credentials do not match our records.',
    ])->onlyInput('name');
}


=======
>>>>>>> 6ce463685d1ac55b573310d3257e08c1b7aa3930
    /**
     * Logout the user and redirect to the login page.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
