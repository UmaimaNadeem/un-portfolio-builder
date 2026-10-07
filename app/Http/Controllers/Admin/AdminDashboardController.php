<?php

namespace App\Http\Controllers\Admin;

use App\Models\Portfolio;
use App\Models\Theme;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = [
            'users' => User::count(),
            'members' => User::where('role', 'member')->count(),
            'portfolios' => Portfolio::count(),
            'public_portfolios' => Portfolio::where('status', 'public')->count(),
            'themes' => Theme::count(),
        ];
        $recentPortfolios = Portfolio::with(['user', 'theme'])->latest()->take(8)->get();

        return view('pages.admin.dashboard', compact('user', 'stats', 'recentPortfolios'));
    }

    public function memberDashboard()
    {
        $user = Auth::user();
        $portfolios = Portfolio::with('theme')->where('user_id', $user->id)->latest()->get();
        $activePortfolioId = session('active_portfolio_id');
        $stats = [
            'total' => $portfolios->count(),
            'public' => $portfolios->where('status', 'public')->count(),
            'draft' => $portfolios->where('status', 'draft')->count(),
            'types' => $portfolios->pluck('type')->unique()->count(),
        ];

        return view('pages.member.dashboard', compact('user', 'portfolios', 'activePortfolioId', 'stats'));
    }
}
