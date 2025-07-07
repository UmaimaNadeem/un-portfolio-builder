<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages.admin.dashboard', compact('user'));
    }
    public function memberDashboard()
    {
        $user = Auth::user();
        return view('pages.member.dashboard', compact('user'));
    }

}
?>
