<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::withCount('portfolios')->orderBy('name')->get();

        return view('pages.admin.themes.index', compact('themes'));
    }
}
