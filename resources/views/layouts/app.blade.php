<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin') — UN Portfolio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@500;600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #0f1419;
            --muted: #5a6570;
            --paper: #f3f1ec;
            --panel: rgba(255, 252, 247, 0.82);
            --line: rgba(15, 20, 25, 0.08);
            --accent: #e85d04;
            --accent-2: #1d6a63;
            --sidebar-w: 268px;
            --sidebar-collapsed: 78px;
            --radius: 22px;
            --shadow: 0 18px 50px rgba(15, 20, 25, 0.08);
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            color: var(--ink);
            font-family: 'Manrope', sans-serif;
            background:
                radial-gradient(1100px 500px at 10% -10%, rgba(232, 93, 4, 0.14), transparent 55%),
                radial-gradient(900px 480px at 95% 0%, rgba(29, 106, 99, 0.16), transparent 50%),
                linear-gradient(180deg, #efece6 0%, var(--paper) 40%, #e8ebe8 100%);
            min-height: 100vh;
        }

        .shell { display: flex; min-height: 100vh; }

        .sidebar {
            width: var(--sidebar-w);
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1000;
            padding: 1.25rem 0.9rem;
            color: #f7f4ef;
            background:
                linear-gradient(165deg, rgba(18, 24, 30, 0.96), rgba(28, 42, 48, 0.94)),
                radial-gradient(circle at 20% 10%, rgba(232, 93, 4, 0.25), transparent 45%);
            border-right: 1px solid rgba(255,255,255,0.06);
            transition: width 0.28s ease;
            overflow: hidden;
        }
        .sidebar.collapsed { width: var(--sidebar-collapsed); }
        .sidebar .brand {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.65rem 0.85rem 1.35rem;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: -0.02em;
        }
        .brand-mark {
            width: 36px; height: 36px; border-radius: 12px;
            display: grid; place-items: center;
            background: linear-gradient(135deg, var(--accent), #ff9f1c);
            color: #fff; flex-shrink: 0;
            box-shadow: 0 10px 24px rgba(232, 93, 4, 0.35);
        }
        .admin-badge {
            margin-left: 0.35rem;
            font-size: 0.62rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.15rem 0.45rem;
            border-radius: 999px;
            background: rgba(232, 93, 4, 0.25);
            color: #ffc58a;
            vertical-align: middle;
        }
        .sidebar.collapsed .brand-text { opacity: 0; width: 0; }

        .sidebar .nav { list-style: none; padding: 0; margin: 0; display: grid; gap: 0.25rem; }
        .sidebar .nav a {
            display: flex; align-items: center; gap: 0.85rem;
            padding: 0.72rem 0.9rem;
            color: rgba(247, 244, 239, 0.78);
            text-decoration: none;
            border-radius: 14px;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
            white-space: nowrap;
        }
        .sidebar .nav a i { font-size: 1.15rem; width: 1.25rem; text-align: center; }
        .sidebar .nav a:hover,
        .sidebar .nav a.active {
            background: rgba(255,255,255,0.08);
            color: #fff;
            transform: translateX(2px);
        }
        .sidebar .nav a.active {
            background: linear-gradient(90deg, rgba(232, 93, 4, 0.28), rgba(255,255,255,0.04));
            box-shadow: inset 3px 0 0 var(--accent);
        }
        .sidebar.collapsed .nav a span { opacity: 0; width: 0; overflow: hidden; }
        .nav-label {
            margin: 1rem 0.9rem 0.4rem;
            font-size: 0.68rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(247,244,239,0.4);
        }
        .sidebar.collapsed .nav-label { opacity: 0; height: 0; margin: 0; }

        .main {
            margin-left: var(--sidebar-w);
            width: calc(100% - var(--sidebar-w));
            transition: margin-left 0.28s ease, width 0.28s ease;
            min-height: 100vh;
        }
        .sidebar.collapsed ~ .main {
            margin-left: var(--sidebar-collapsed);
            width: calc(100% - var(--sidebar-collapsed));
        }

        .topbar {
            position: sticky; top: 0; z-index: 50;
            display: flex; align-items: center; justify-content: space-between;
            gap: 1rem; padding: 1rem 1.5rem;
            backdrop-filter: blur(14px);
            background: rgba(243, 241, 236, 0.72);
            border-bottom: 1px solid var(--line);
        }
        .topbar-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: -0.02em;
        }
        .icon-btn {
            width: 42px; height: 42px; border-radius: 14px;
            border: 1px solid var(--line);
            background: rgba(255,255,255,0.65);
            display: grid; place-items: center;
            cursor: pointer; color: var(--ink);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-decoration: none;
        }
        .icon-btn:hover { transform: translateY(-1px); box-shadow: var(--shadow); color: var(--ink); }

        .content-wrap { padding: 1.5rem 1.5rem 2.5rem; }
        .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
        }

        .btn-accent {
            background: linear-gradient(135deg, var(--accent), #ff9f1c);
            border: 0; color: #fff; font-weight: 600;
            border-radius: 14px; padding: 0.65rem 1.15rem;
            box-shadow: 0 12px 28px rgba(232, 93, 4, 0.28);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-accent:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 16px 34px rgba(232, 93, 4, 0.34); }
        .btn-ghost {
            border: 1px solid var(--line); background: rgba(255,255,255,0.55);
            color: var(--ink); border-radius: 14px; font-weight: 600;
        }
        .btn-ghost:hover { background: #fff; color: var(--ink); }

        .display-font { font-family: 'Syne', sans-serif; letter-spacing: -0.03em; }
        .muted { color: var(--muted); }

        .table { --bs-table-bg: transparent; }
        .table > :not(caption) > * > * { background: transparent; }

        @media (max-width: 900px) {
            .sidebar {
                width: min(86vw, 280px);
                transform: translateX(-105%);
            }
            .sidebar.open { transform: translateX(0); }
            .sidebar.collapsed { width: min(86vw, 280px); }
            .main, .sidebar.collapsed ~ .main { margin-left: 0; width: 100%; }
        }
    </style>
    @stack('styles')
</head>
<body>
@php $user = $user ?? auth()->user(); @endphp
<div class="shell">
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-mark"><i class="bi bi-layers-half"></i></div>
            <span class="brand-text">UN Portfolio <span class="admin-badge">Admin</span></span>
        </div>

        <div class="nav-label">Platform</div>
        <ul class="nav">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i><span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('portfolios.index') }}" class="{{ request()->routeIs('portfolios.index') || request()->routeIs('portfolios.manage') || request()->routeIs('portfolios.edit') ? 'active' : '' }}">
                    <i class="bi bi-collection"></i><span>Portfolios</span>
                </a>
            </li>
            <li>
                <a href="{{ route('portfolios.create') }}" class="{{ request()->routeIs('portfolios.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-lg"></i><span>New Portfolio</span>
                </a>
            </li>
        </ul>

        <div class="nav-label">Manage</div>
        <ul class="nav">
            <li>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i><span>Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.themes.index') }}" class="{{ request()->routeIs('admin.themes.*') ? 'active' : '' }}">
                    <i class="bi bi-palette"></i><span>Themes</span>
                </a>
            </li>
        </ul>

        <div class="nav-label">Discover</div>
        <ul class="nav">
            <li>
                <a href="{{ route('portfolios.public') }}" target="_blank" rel="noopener">
                    <i class="bi bi-globe2"></i><span>Explore Public</span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person"></i><span>My Profile</span>
                </a>
            </li>
        </ul>
    </aside>

    <div class="main">
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="icon-btn" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <div class="topbar-title">@yield('page_title', 'Admin')</div>
                    <div class="small muted d-none d-md-block">@yield('page_subtitle', 'Platform overview and controls')</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="small muted d-none d-md-inline">{{ $user->name ?? '' }}</span>
                <a href="{{ route('profile.show') }}" class="icon-btn" title="Profile"><i class="bi bi-person"></i></a>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-sm btn-ghost">Logout</button>
                </form>
            </div>
        </header>

        <div class="content-wrap">
            <div class="panel">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        if (window.innerWidth <= 900) {
            sidebar.classList.toggle('open');
        } else {
            sidebar.classList.toggle('collapsed');
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
