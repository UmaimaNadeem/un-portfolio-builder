<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'UN Portfolio'))</title>
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #0f1419;
            --muted: #5a6570;
            --paper: #f3f1ec;
            --panel: rgba(255, 252, 247, 0.88);
            --line: rgba(15, 20, 25, 0.08);
            --accent: #e85d04;
            --accent-2: #1d6a63;
            --shadow: 0 18px 50px rgba(15, 20, 25, 0.08);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            color: var(--ink);
            font-family: 'Manrope', sans-serif;
            background:
                radial-gradient(1100px 500px at 10% -10%, rgba(232, 93, 4, 0.14), transparent 55%),
                radial-gradient(900px 480px at 95% 0%, rgba(29, 106, 99, 0.16), transparent 50%),
                linear-gradient(180deg, #efece6 0%, var(--paper) 40%, #e8ebe8 100%);
            overflow-x: hidden;
        }
        .auth-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
        }
        .auth-visual {
            position: relative;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }
        .auth-visual::before {
            content: '';
            position: absolute;
            inset: 14% 14% auto auto;
            width: 260px; height: 260px;
            border-radius: 28px;
            background: linear-gradient(145deg, #1a2b2f 0%, #234e4a 55%, #e85d04 140%);
            transform: rotate(16deg) perspective(900px) rotateY(-12deg);
            box-shadow: 0 30px 60px rgba(29, 106, 99, 0.28);
            animation: floatBlock 7s ease-in-out infinite;
        }
        .auth-visual::after {
            content: '';
            position: absolute;
            left: 12%; bottom: 16%;
            width: 150px; height: 150px;
            border-radius: 22px;
            border: 1px solid var(--line);
            background: rgba(255, 252, 247, 0.55);
            backdrop-filter: blur(8px);
            transform: rotate(-10deg);
            box-shadow: var(--shadow);
            animation: floatBlock 9s ease-in-out infinite reverse;
        }
        .brand {
            position: relative; z-index: 1;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            letter-spacing: -0.03em;
            display: flex; align-items: center; gap: 0.7rem;
        }
        .brand-mark {
            width: 40px; height: 40px; border-radius: 12px;
            display: grid; place-items: center;
            background: linear-gradient(135deg, var(--accent), #ff9f1c);
            color: #fff;
            box-shadow: 0 12px 28px rgba(232, 93, 4, 0.32);
        }
        .visual-copy { position: relative; z-index: 1; max-width: 26rem; }
        .visual-copy h1 {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.05;
            letter-spacing: -0.04em;
            margin: 0 0 1rem;
            font-weight: 800;
        }
        .visual-copy p { color: var(--muted); margin: 0; line-height: 1.6; }
        .auth-panel {
            display: flex; align-items: center; justify-content: center;
            padding: 2rem 1.25rem;
        }
        .auth-card {
            width: 100%;
            max-width: 440px;
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 22px;
            padding: 2rem;
            backdrop-filter: blur(12px);
            box-shadow: var(--shadow);
        }
        .auth-card h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.75rem;
            letter-spacing: -0.03em;
            margin: 0 0 0.35rem;
            font-weight: 800;
        }
        .auth-card .sub { color: var(--muted); margin-bottom: 1.5rem; font-size: 0.95rem; }
        .form-label { color: var(--muted); font-size: 0.82rem; font-weight: 600; margin-bottom: 0.35rem; }
        .form-control {
            background: rgba(255,255,255,0.7);
            border: 1px solid var(--line);
            color: var(--ink);
            border-radius: 12px;
            padding: 0.75rem 0.9rem;
        }
        .form-control:focus {
            background: #fff;
            border-color: rgba(232, 93, 4, 0.45);
            box-shadow: 0 0 0 3px rgba(232, 93, 4, 0.15);
            color: var(--ink);
        }
        .form-control::placeholder { color: rgba(90, 101, 112, 0.65); }
        .input-group .form-control { border-right: 0; }
        .input-group-text {
            background: rgba(255,255,255,0.7);
            border: 1px solid var(--line);
            border-left: 0;
            color: var(--muted);
            cursor: pointer;
            border-radius: 0 12px 12px 0;
        }
        .btn-auth {
            width: 100%;
            border: 0;
            border-radius: 14px;
            padding: 0.85rem 1rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), #ff9f1c);
            box-shadow: 0 12px 28px rgba(232, 93, 4, 0.28);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-auth:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 16px 34px rgba(232, 93, 4, 0.34);
        }
        .auth-foot { margin-top: 1.25rem; text-align: center; color: var(--muted); font-size: 0.92rem; }
        .auth-foot a { color: var(--accent-2); font-weight: 700; text-decoration: none; }
        .auth-foot a:hover { color: var(--accent); }
        .alert { border-radius: 14px; border: 0; }
        .form-check-input:checked {
            background-color: var(--accent);
            border-color: var(--accent);
        }
        @keyframes floatBlock {
            0%, 100% { translate: 0 0; }
            50% { translate: 0 -14px; }
        }
        @media (max-width: 900px) {
            .auth-shell { grid-template-columns: 1fr; }
            .auth-visual { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>
@yield('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = document.getElementById(btn.getAttribute('data-toggle-password'));
            if (!input) return;
            const isHidden = input.getAttribute('type') === 'password';
            input.setAttribute('type', isHidden ? 'text' : 'password');
            btn.querySelector('i')?.classList.toggle('bi-eye');
            btn.querySelector('i')?.classList.toggle('bi-eye-slash');
        });
    });
});
</script>
@stack('scripts')
</body>
</html>
