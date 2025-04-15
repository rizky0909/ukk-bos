<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function dashboard()
    {
        $sales = Transactions::selectRaw('MONTHNAME(created_at) as month, SUM(total_price) as total')
            ->groupByRaw('MONTH(created_at), MONTHNAME(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get();

        $months = $sales->pluck('month');
        $salesPerMonth = $sales->pluck('total');

        return view('dashboard', compact('months', 'salesPerMonth'));
    }

    public function login(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credential)) {
            $user = Auth::user();

            if ($user->role == 'admin' || $user->role == 'staff') {
                return redirect()->route('dashboard')->with('success', 'Berhasil Login');
            }
            return redirect()->route('login')->with('error', 'Role Tidak Dikenali');
        } else {
            return redirect()->route('login')->with('error', 'Email atau Password Salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Berhasil Logout');
    }
}
