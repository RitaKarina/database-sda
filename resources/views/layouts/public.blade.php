<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b3d32">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-ntb.png') }}">
    <title>@yield('title', 'Database Sumber Daya Air') | PUPR NTB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sda-green: #0b3d32;
            --sda-green-dark: #082d27;
            --sda-green-mid: #1e7c66;
            --sda-green-light: #eaf6f2;
            --sda-green-soft: #d9f3ea;
            --sda-gold: #e8bc55;
            --sda-ink: #19312c;
            --sda-muted: #64756f;
            --sda-panel: #ffffff;
            --sda-surface: #f4f8f7;
        }

        html { scroll-behavior: smooth; }
        body { min-height: 100vh; color: var(--sda-ink); background: var(--sda-surface); }
        .public-header { position: sticky; top: 0; z-index: 20; background: rgba(255,255,255,0.96); backdrop-filter: blur(12px); border-bottom: 1px solid #e4ebe7; }
        .brand-logo { display: block; flex: 0 0 auto; }
        .brand-title { color: var(--sda-green); line-height: 1.15; }
        .public-nav { display: flex; align-items: center; gap: 1rem; }
        .public-nav a { color: var(--sda-ink); text-decoration: none; font-weight: 600; }
        .public-nav a:hover { color: var(--sda-green); }
        .btn-sda { color: #fff; background: var(--sda-green); border-color: var(--sda-green); transition: all .25s ease; white-space: nowrap; }
        .btn-sda:hover { color: #fff; background: var(--sda-green-dark); border-color: var(--sda-green-dark); transform: translateY(-1px); box-shadow: 0 10px 18px rgb(11 61 50 / 20%); }

        .btn-login-header {
            color: var(--sda-green);
            background: #ffffff;
            border: 1.5px solid var(--sda-green);
            font-weight: 600;
            transition: all .2s ease;
            white-space: nowrap;
            box-shadow: 0 2px 6px rgba(11, 61, 50, 0.08);
        }
        .btn-login-header:hover {
            color: var(--sda-green-dark);
            background: var(--sda-green-light);
            border-color: var(--sda-green);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(11, 61, 50, 0.12);
        }
        .btn-login-header:active,
        .btn-login-header:focus-visible,
        .btn-login-header.is-pressed {
            color: #ffffff !important;
            background: var(--sda-green-dark) !important;
            border-color: var(--sda-green-dark) !important;
            transform: translateY(1px) scale(0.98);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.25);
        }
        .btn-login-header:active i,
        .btn-login-header:focus-visible i,
        .btn-login-header.is-pressed i {
            color: #ffffff !important;
        }

        .hero { position: relative; overflow: hidden; color: #fff; background: linear-gradient(120deg, #0b3d32 0%, #0f4c3a 30%, #1c6f59 72%, #2e8a7a 100%); }
        .hero::before { position: absolute; inset: 0; background: radial-gradient(circle at 85% 20%, rgb(255 255 255 / 16%), transparent 22%), radial-gradient(circle at 15% 80%, rgb(255 255 255 / 8%), transparent 28%); content: ''; }
        .hero::after { position: absolute; right: -80px; bottom: -260px; width: 500px; height: 500px; border: 1px solid rgb(255 255 255 / 15%); border-radius: 50%; content: ''; }
        .hero-content { position: relative; z-index: 1; }
        .eyebrow { color: #dffcf5; font-size: .78rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .hero h1 { letter-spacing: -.04em; font-size: clamp(2.5rem, 5vw, 5.1rem); line-height: .95; text-shadow: 0 8px 20px rgb(0 0 0 / 18%); }
        .hero p { max-width: 640px; color: rgb(255 255 255 / 82%); }
        .btn-hero { background: #fff; color: var(--sda-green); border-color: #fff; box-shadow: 0 12px 22px rgb(255 255 255 / 12%); }
        .btn-hero:hover { background: #f5fbf8; color: var(--sda-green); }
        .hero-chip { display: inline-flex; align-items: center; gap: .6rem; border: 1px solid rgb(255 255 255 / 20%); border-radius: 999px; padding: .7rem 1rem; background: rgb(255 255 255 / 7%); }
        .hero-visual { position: relative; width: min(100%, 320px); aspect-ratio: 1; display: grid; place-items: center; }
        .water-orb { position: relative; display: grid; place-items: center; width: 180px; height: 180px; border-radius: 50%; background: linear-gradient(135deg, rgb(255 255 255 / 18%), rgb(255 255 255 / 5%)); box-shadow: inset 0 0 0 1px rgb(255 255 255 / 12%), 0 30px 40px rgb(0 0 0 / 12%); }
        .water-orb i { font-size: 5rem; color: rgb(255 255 255 / 80%); }
        .hero-bubble { position: absolute; border-radius: 50%; background: rgb(255 255 255 / 8%); border: 1px solid rgb(255 255 255 / 10%); }
        .hero-bubble:nth-child(2) { width: 76px; height: 76px; right: 1rem; top: 3rem; }
        .hero-bubble:nth-child(3) { width: 48px; height: 48px; left: 2rem; bottom: 3rem; }
        .hero-bubble:nth-child(4) { width: 62px; height: 62px; right: 3.5rem; bottom: 1rem; }

        .section-kicker { color: #3a826d; font-size: .78rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .section-head { max-width: 680px; margin: 0 auto 2rem; }
        .section-panel { background: linear-gradient(180deg, #ffffff 0%, #f3faf7 100%); border: 1px solid #e4efe9; border-radius: 1.6rem; box-shadow: 0 18px 35px rgb(11 61 50 / 05%); }

        .public-hero {
            position: relative;
            overflow: hidden;
            padding: 3rem 0 2rem;
            background: linear-gradient(180deg, #0b3d32 0%, #0e4d3b 28%, #1a6d59 68%, #2c8b7f 100%);
        }
        .public-hero::before,
        .public-hero::after {
            position: absolute;
            content: "";
            border-radius: 50%;
            border: 1px solid rgb(255 255 255 / 10%);
        }
        .public-hero::before {
            width: 540px;
            height: 540px;
            right: -130px;
            top: -180px;
        }
        .public-hero::after {
            width: 420px;
            height: 420px;
            left: -120px;
            bottom: -180px;
        }
        .bubble-dashboard {
            position: relative;
            display: block;
            width: 100%;
            min-height: 460px;
            padding: 1.5rem 0 1rem;
            background: linear-gradient(180deg, rgba(255,255,255,0.72) 0%, rgba(233,245,240,0.88) 100%);
            border: 1px solid rgba(18, 78, 66, 0.08);
            border-radius: 2rem;
            box-shadow: 0 14px 32px rgba(6, 45, 38, 0.06);
            overflow: hidden;
        }
        .bubble-menu-view,
        .bubble-detail-view {
            width: 100%;
            min-height: 420px;
            transition: opacity .28s ease, transform .28s ease;
        }
        .bubble-menu-view {
            display: block;
        }
        .bubble-detail-view {
            display: none;
            min-height: 0;
            padding: 1.25rem 1.25rem 0;
            max-height: min(72vh, 760px);
            overflow-y: auto;
            overscroll-behavior: contain;
            scrollbar-gutter: stable;
        }
        .bubble-dashboard.is-detail-active .bubble-menu-view {
            display: none;
        }
        .bubble-dashboard.is-detail-active .bubble-detail-view {
            display: block;
            animation: detailFade .28s ease both;
        }
        .bubble-stage {
            display: grid;
            grid-template-columns: repeat(3, minmax(120px, 170px));
            justify-content: center;
            align-items: center;
            gap: 1.25rem 1.5rem;
            width: min(100%, 760px);
            margin: 0 auto;
            min-height: 340px;
        }
        .bubble-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: min(100%, 170px);
            aspect-ratio: 1;
            padding: 1rem;
            border: 1px solid rgba(255,255,255,0.5);
            border-radius: 50%;
            background: linear-gradient(180deg, #ffffff 0%, #edf9f5 100%);
            box-shadow: 0 18px 35px rgba(10, 52, 41, 0.1);
            color: var(--sda-green);
            text-align: center;
            text-decoration: none;
            transition: transform .25s ease, box-shadow .25s ease, opacity .25s ease, filter .25s ease;
            cursor: pointer;
            z-index: 1;
        }
        .bubble-item:hover,
        .bubble-item.is-selected {
            transform: scale(1.04);
            box-shadow: 0 22px 38px rgba(10, 52, 41, 0.14);
        }
        .bubble-item--main {
            width: min(100%, 215px);
            background: linear-gradient(180deg, #fefefe 0%, #ecf9f4 100%);
            box-shadow: 0 18px 36px rgba(0,0,0,0.12);
        }
        .bubble-item--alt {
            background: linear-gradient(180deg, #f8fffd 0%, #ebf8f3 100%);
        }
        .bubble-item--left { grid-column: 1; grid-row: 1; }
        .bubble-item--main { grid-column: 2; grid-row: 1; }
        .bubble-item--right { grid-column: 3; grid-row: 1; }
        .bubble-item--lower-left { grid-column: 1; grid-row: 2; }
        .bubble-item--lower-center { grid-column: 2; grid-row: 2; }
        .bubble-item--lower-right { grid-column: 3; grid-row: 2; }
        .bubble-dashboard.is-detail-active .bubble-item {
            opacity: 0.18;
            filter: blur(1px);
            transform: scale(0.96);
        }
        .bubble-dashboard.is-detail-active .bubble-item.is-selected {
            opacity: 1;
            filter: none;
            transform: scale(1.06);
            grid-column: 2;
            grid-row: 1;
        }
        .bubble-dashboard.is-opening .bubble-item:not(.is-selected) {
            opacity: 0;
            filter: blur(1px);
            transform: scale(.82);
        }
        .bubble-dashboard.is-opening .bubble-item.is-selected {
            position: relative;
            z-index: 2;
            transform: scale(1.12) translateY(-8px);
        }
        .bubble-item__badge {
            display: grid;
            place-items: center;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(160deg, var(--sda-green) 0%, #1d7d6d 100%);
            color: #fff;
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .08em;
        }
        .bubble-item__icon {
            display: grid;
            place-items: center;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(160deg, var(--sda-green) 0%, #1e7f6c 100%);
            color: #fff;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.25);
        }
        .bubble-item--alt .bubble-item__icon { background: linear-gradient(160deg, #0f5a4f 0%, #1d8a7d 100%); }
        .bubble-item__name {
            margin-top: .55rem;
            font-size: .6rem;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            line-height: 1.3;
        }
        .bubble-item__name--main {
            width: 78%;
            margin-top: .6rem;
            font-size: .72rem;
        }
        .bubble-item__value {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--sda-green-dark);
            line-height: 1;
            margin-top: .2rem;
        }
        .bubble-close {
            position: absolute;
            right: 1.25rem;
            top: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border: 1px solid rgba(16, 76, 64, 0.14);
            border-radius: 50%;
            background: rgba(255,255,255,0.62);
            color: var(--sda-green);
            box-shadow: 0 8px 18px rgba(9, 48, 39, 0.08);
            cursor: pointer;
        }
        .bubble-detail-panel {
            display: none;
            min-height: 370px;
            padding: 2.8rem 1rem 0;
            animation: detailFade .28s ease;
        }
        .bubble-detail-panel.is-active {
            display: block;
        }
        @keyframes detailFade { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .detail-header {
            margin-bottom: 1.25rem;
        }
        .detail-table-wrap {
            overflow-x: auto;
            border: 1px solid rgba(15, 75, 62, 0.08);
            border-radius: 1.25rem;
            background: rgba(255,255,255,0.76);
        }
        .detail-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
        }
        .detail-card {
            height: 100%;
            border: 1px solid #e6ece8;
            border-radius: 1.5rem;
            background: rgba(255,255,255,0.88);
            box-shadow: 0 .6rem 1.5rem rgba(20, 51, 41, 0.05);
        }
        .detail-info-card {
            padding: 1.5rem;
            border: 1px solid #e6ece8;
            border-radius: 1.5rem;
            background: rgba(255,255,255,0.88);
            box-shadow: 0 .6rem 1.5rem rgba(20, 51, 41, 0.05);
        }

        [id] { scroll-margin-top: 96px; }

        .info-panel, .stat-card, .data-card { height: 100%; border: 1px solid #e6ece8; border-radius: 1.5rem; background: var(--sda-panel); box-shadow: 0 .6rem 1.5rem rgb(20 51 41 / 5%); }
        .stat-card { padding: 1.25rem 1.4rem; }
        .stat-number { color: var(--sda-green); font-size: 2rem; font-weight: 800; }
        .data-label { color: var(--sda-muted); font-size: .78rem; }
        .data-value { color: var(--sda-ink); font-weight: 700; }
        .table-modern { border-collapse: separate; border-spacing: 0; }
        .table-modern thead th { background: #edf6f3; color: var(--sda-green); border-bottom: 0; font-size: .78rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
        .table-modern tbody td, .table-modern tbody th { border-bottom: 1px solid #e9efed; }
        .table-modern tbody tr:hover { background: #f7fbf9; }
        .empty-state { display: grid; place-items: center; min-height: 220px; text-align: center; background: linear-gradient(180deg, #ffffff 0%, #f6faf9 100%); border: 1px solid #e4efe9; border-radius: 1.5rem; }
        .empty-state i { color: #96a8a2; }
        .public-footer { color: #dce9e4; background: #102e27; }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .bubble-item,
            .bubble-detail-view,
            .bubble-detail-panel,
            .btn-sda,
            .btn-login-header,
            .btn-hero {
                transition: none !important;
                animation: none !important;
            }
        }

        @media (max-width: 991.98px) {
            .bubble-stage {
                grid-template-columns: repeat(2, minmax(120px, 160px));
                width: min(100%, 520px);
                gap: 1rem;
            }
            .bubble-item--left { grid-column: 1; grid-row: 1; }
            .bubble-item--main { grid-column: 2; grid-row: 1; }
            .bubble-item--right { grid-column: 1; grid-row: 2; }
            .bubble-item--lower-left { grid-column: 2; grid-row: 2; }
            .bubble-item--lower-center { grid-column: 1; grid-row: 3; }
            .bubble-item--lower-right { grid-column: 2; grid-row: 3; }
            .bubble-dashboard.is-detail-active .bubble-item.is-selected {
                grid-column: 1 / -1;
                grid-row: 1;
            }
        }

        @media (max-width: 575.98px) {
            .brand-description { display: none; }
            .public-nav { gap: .7rem; }
            .public-nav a { font-size: .82rem; }
            .btn-sda,
            .btn-login-header { padding: .55rem .9rem; }
            .bubble-dashboard {
                min-height: 340px;
                padding-top: 1rem;
            }
            .bubble-stage {
                grid-template-columns: repeat(2, minmax(110px, 1fr));
                gap: .8rem;
                width: min(100%, 420px);
            }
            .bubble-item {
                width: min(100%, 124px);
            }
            .bubble-item--main {
                width: min(100%, 144px);
            }
            .bubble-item__name {
                font-size: .48rem;
            }
            .bubble-item__value {
                font-size: .82rem;
            }
            .bubble-detail-panel {
                padding-top: 3rem;
            }
            .bubble-detail-view {
                max-height: 65vh;
            }
        }
    </style>
    @stack('head')
</head>
<body>
    <header class="public-header">
        <nav class="container py-3 d-flex flex-wrap justify-content-between align-items-center gap-3" aria-label="Navigasi utama">
            <a href="{{ route('public.home') }}" class="d-flex align-items-center gap-3 text-decoration-none">
                <x-logo size="52" class="brand-logo" />
                <span class="brand-title">
                    <span class="d-block fw-bold">Database Sumber Daya Air</span>
                    <span class="brand-description small text-secondary">Dinas PUPR Provinsi Nusa Tenggara Barat</span>
                </span>
            </a>
            <div class="public-nav d-flex align-items-center gap-3 gap-md-4">
                @yield('navigation')
                @unless (request()->routeIs('login'))
                    <a href="{{ route('login') }}" class="btn btn-login-header rounded-pill px-3 px-md-4">
                        <i class="fa-solid fa-lock me-2" aria-hidden="true"></i>Login Pengelola Data
                    </a>
                @endunless
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="public-footer mt-5 py-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between gap-2">
            <span>Database Sumber Daya Air &mdash; PUPR Provinsi Nusa Tenggara Barat</span>
            <span class="text-white-50">Informasi publik infrastruktur sumber daya air</span>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.btn-login-header').forEach(function (button) {
            button.addEventListener('click', function () {
                this.classList.add('is-pressed');
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
