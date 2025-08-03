<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>UN Portfolio Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: linear-gradient(145deg, #1f1c2c, #928dab);
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --primary-color: #6c5ce7;
            --text-color: #f1f1f1;
        }

        body {
            margin: 0;
            background: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }

        .wrapper {
            display: flex;
            flex-wrap: nowrap;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: var(--text-color);
            transition: width 0.3s ease;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding-top: 70px;
            z-index: 1000;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar .logo {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            font-weight: bold;
            color: #fff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar.collapsed .logo span {
            display: none;
        }

        .sidebar ul.nav {
            padding-left: 0;
            margin-top: 10px;
        }

        .sidebar ul.nav li a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--text-color);
            text-decoration: none;
            transition: background 0.3s;
            white-space: nowrap;
        }

        .sidebar ul.nav li a i {
            font-size: 1.2rem;
            margin-right: 12px;
        }

        .sidebar ul.nav li a span {
            display: inline-block;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .sidebar.collapsed ul.nav li a span {
            opacity: 0;
            transform: translateX(-10px);
            pointer-events: none;
        }

        .sidebar ul.nav li a.active,
        .sidebar ul.nav li a:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        .main {
            margin-left: var(--sidebar-width);
            width: 100%;
            transition: margin-left 0.3s ease;
        }

        .sidebar.collapsed~.main {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Top Navbar */
        .top-navbar {
            height: 70px;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            width: 100%;
            z-index: 1020;
        }

        .top-navbar .toggle-btn {
            cursor: pointer;
            font-size: 1.5rem;
            color: #333;
        }

        .top-navbar .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-navbar .profile i {
            font-size: 1.3rem;
        }

        .content {
            margin-top: 90px;
            padding: 30px;
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.7);
            border-radius: 15px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            padding: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: fixed;
                top: 70px;
                left: 0;
            }

            .sidebar.collapsed {
                display: none;
            }

            .main {
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body>
    <!-- Top Navbar -->
    <div class="top-navbar">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-list toggle-btn" onclick="toggleSidebar()"></i>
            <span class="fs-5 fw-semibold text-dark">Dashboard</span>
        </div>
        <div class="profile">
            <a href="{{ route('profile.show') }}" class="text-dark"><i class="bi bi-person-circle"></i></a>
            <form action="{{ route('logout') }}" method="Post">
                @csrf
                <button class="btn btn-sm btn-outline-dark">Logout</button>
            </form>
        </div>
    </div>

    <!-- Sidebar + Main Content -->
    <div class="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="logo"><span>UN Portfolio</span></div>
            <ul class="nav flex-column">
                <li><a href="{{ route('member.dashboard') }}"
                        class="{{ request()->is('member/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span></a></li>

                <li><a href="{{ route('personal_info.index') }}"
                        class="{{ request()->is('member/personal_info*') ? 'active' : '' }}">
                        <i class="bi bi-person"></i> <span>Personal Info</span></a></li>

                <li><a href="{{ route('user-profile-links.index') }}"
                        class="{{ request()->is('member/user-profile-links*') ? 'active' : '' }}">
                        <i class="bi bi-link-45deg"></i> <span>Profile Links</span></a></li>

                <li><a href="{{ route('education.index') }}"
                        class="{{ request()->is('member/education*') ? 'active' : '' }}">
                        <i class="bi bi-mortarboard"></i> <span>Education</span></a></li>

                <li><a href="{{ route('services.index') }}"
                        class="{{ request()->is('member/services*') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i> <span>Services</span></a></li>

                <li><a href="{{ route('skills.index') }}"
                        class="{{ request()->is('member/skills*') ? 'active' : '' }}">
                        <i class="bi bi-lightning-charge"></i> <span>Skills</span></a></li>

                <li><a href="{{ route('work_experiences.index') }}"
                        class="{{ request()->is('member/work_experiences*') ? 'active' : '' }}">
                        <i class="bi bi-briefcase"></i> <span>Work Experience</span></a></li>

                <li><a href="{{ route('projects.index') }}"
                        class="{{ request()->is('member/projects*') ? 'active' : '' }}">
                        <i class="bi bi-kanban"></i> <span>Projects</span></a></li>
            </ul>

            @php
                $userId = auth()->id();
            @endphp

            <div class="card-glass text-center p-4 m-3">
                <h5 class="mb-3">Preview Your Portfolio</h5>
                <p class="text-muted">See how your portfolio looks to visitors.</p>
@php
    use Illuminate\Support\Str;
    use App\Models\PersonalInfo;

    $personalInfo = PersonalInfo::where('user_id', $user->id)->first();
    $portfolioName = $personalInfo ? Str::slug($personalInfo->name) : $user->id;
@endphp

<a href="{{ route('member.portfolio.showByName', $portfolioName) }}" target="_blank" class="btn btn-primary">
    <i class="bi bi-eye me-1"></i> View Portfolio
</a>



            </div>
        </nav>

        <!-- Main Content -->
        <main class="main">
            <div class="content">
                <div class="card-glass">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <!-- Toggle Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("collapsed");
        }
    </script>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
