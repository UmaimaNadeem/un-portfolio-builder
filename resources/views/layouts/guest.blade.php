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
            --ink: #e8f0f2;
            --muted: #8aa0a8;
            --accent: #e85d04;
            --accent-2: #ff7a3d;
            --panel: rgba(12, 28, 36, 0.72);
            --line: rgba(126, 232, 250, 0.16);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            color: var(--ink);
            font-family: 'Manrope', sans-serif;
            background:
                radial-gradient(900px 480px at 12% -10%, rgba(62, 207, 207, 0.22), transparent 55%),
                radial-gradient(700px 420px at 95% 5%, rgba(255, 122, 61, 0.16), transparent 50%),
                linear-gradient(165deg, #061418 0%, #0a1f28 45%, #07131a 100%);
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
            border-right: 1px solid var(--line);
            overflow: hidden;
        }
        .auth-visual::before {
            content: '';
            position: absolute;
            inset: 12% 18% auto auto;
            width: 280px; height: 280px;
            border-radius: 32px;
            background: linear-gradient(145deg, rgba(62,207,207,0.35), rgba(255,122,61,0.2));
            transform: rotate(18deg) perspective(800px) rotateY(-18deg);
            box-shadow: 0 40px 80px rgba(0,0,0,0.35);
            animation: floatBlock 7s ease-in-out infinite;
        }
        .auth-visual::after {
            content: '';
            position: absolute;
            left: 12%; bottom: 18%;
            width: 160px; height: 160px;
            border-radius: 24px;
            border: 1px solid var(--line);
            background: rgba(12, 28, 36, 0.5);
            backdrop-filter: blur(8px);
            transform: rotate(-10deg);
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
            color: #fff; flex-shrink: 0;
            box-shadow: 0 10px 24px rgba(232, 93, 4, 0.35);
        }
        .visual-copy { position: relative; z-index: 1; max-width: 26rem; }
        .visual-copy h1 {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.05;
            letter-spacing: -0.04em;
            margin: 0 0 1rem;
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
            border-radius: 24px;
            padding: 2rem;
            backdrop-filter: blur(16px);
            box-shadow: 0 30px 70px rgba(0,0,0,0.35);
        }
        .auth-card h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.75rem;
            letter-spacing: -0.03em;
            margin: 0 0 0.35rem;
        }
        .auth-card .sub { color: var(--muted); margin-bottom: 1.5rem; font-size: 0.95rem; }
        .form-label { color: var(--muted); font-size: 0.82rem; font-weight: 600; margin-bottom: 0.35rem; }
        .form-control {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(126,232,250,0.18);
            color: var(--ink);
            border-radius: 12px;
            padding: 0.75rem 0.9rem;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.06);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(62,207,207,0.18);
            color: var(--ink);
        }
        .form-control::placeholder { color: rgba(138,160,168,0.7); }
        .input-group .form-control { border-right: 0; }
        .input-group-text {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(126,232,250,0.18);
            border-left: 0;
            color: var(--muted);
            cursor: pointer;
            border-radius: 0 12px 12px 0;
        }
        .btn-auth {
            width: 100%;
            border: 0;
            border-radius: 12px;
            padding: 0.85rem 1rem;
            font-weight: 700;
            color: #042028;
            background: linear-gradient(135deg, var(--accent), #ff9f1c);
            box-shadow: 0 14px 34px rgba(62,207,207,0.28);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-auth:hover { color: #042028; transform: translateY(-2px); box-shadow: 0 18px 40px rgba(62,207,207,0.35); }
        .auth-foot { margin-top: 1.25rem; text-align: center; color: var(--muted); font-size: 0.92rem; }
        .auth-foot a { color: var(--accent); font-weight: 600; text-decoration: none; }
        .auth-foot a:hover { color: #7ee8fa; }
        .alert { border-radius: 12px; border: 0; }
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
