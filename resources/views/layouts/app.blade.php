<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>E-PUSBONAT</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: #f3f8fa;
            color: #102a43;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .ep-layout {
            min-height: 100vh;
            display: flex;
        }

        .ep-sidebar {
            width: 260px;
            min-width: 260px;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 50;
            color: white;
            background:
                radial-gradient(circle at 90% 0%, rgba(55, 220, 207, .28), transparent 28%),
                linear-gradient(180deg, #075e5a 0%, #087f78 55%, #05645f 100%);
            overflow: hidden;
        }

        .ep-sidebar::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 47%;
            background:
                linear-gradient(to top, rgba(3, 75, 72, .15), transparent),
                radial-gradient(circle at 50% 100%, rgba(255,255,255,.08), transparent 55%);
            pointer-events: none;
        }

        .ep-brand {
            height: 130px;
            padding: 22px 24px;
            position: relative;
            z-index: 2;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .ep-brand-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ep-logo {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #087f78;
            box-shadow: 0 8px 20px rgba(0,0,0,.15);
        }

        .ep-brand-title {
            font-size: 21px;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.5px;
        }

        .ep-brand-sub {
            font-size: 11px;
            opacity: .78;
            margin-top: 4px;
        }

        .ep-motto {
            margin-top: 13px;
            font-size: 10px;
            line-height: 1.4;
            color: rgba(255,255,255,.82);
            max-width: 180px;
        }

        .ep-nav {
            position: relative;
            z-index: 3;
            padding: 22px 14px;
        }

        .ep-nav a {
            height: 48px;
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 0 16px;
            margin-bottom: 6px;
            border-radius: 10px;
            color: rgba(255,255,255,.92);
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: .18s ease;
        }

        .ep-nav a:hover {
            background: rgba(255,255,255,.10);
        }

        .ep-nav a.active {
            background: linear-gradient(135deg, #25cdbd, #10ae9f);
            box-shadow: 0 8px 22px rgba(0,0,0,.14);
        }

        .ep-nav svg {
            width: 23px;
            height: 23px;
            flex-shrink: 0;
        }

        .ep-main {
            width: calc(100% - 260px);
            margin-left: 260px;
            min-width: 0;
        }

        .ep-topbar {
            height: 66px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 26px;
            gap: 22px;
            background:
                linear-gradient(120deg, #087f78 0%, #18b5aa 55%, #41cfc3 100%);
            box-shadow: 0 4px 20px rgba(7, 94, 90, .15);
        }

        .ep-search {
            width: 325px;
            height: 40px;
            background: rgba(255,255,255,.95);
            border-radius: 9px;
            display: flex;
            align-items: center;
            padding: 0 15px;
            color: #78909c;
            font-size: 13px;
        }

        .ep-user {
            display: flex;
            align-items: center;
            gap: 11px;
            color: white;
        }

        .ep-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #e9f2f5;
            color: #476275;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            border: 3px solid rgba(255,255,255,.4);
        }

        .ep-content {
            padding: 22px 25px 0;
        }

        .ep-footer {
            padding: 18px 25px 24px;
            display: flex;
            justify-content: space-between;
            color: #718096;
            font-size: 12px;
        }

        @media(max-width: 900px) {
            .ep-sidebar {
                width: 220px;
                min-width: 220px;
            }

            .ep-main {
                width: calc(100% - 220px);
                margin-left: 220px;
            }

            .ep-search {
                width: 230px;
            }
        }

        @media(max-width: 700px) {
            .ep-sidebar {
                position: relative;
                width: 100%;
                min-width: 0;
                height: auto;
            }

            .ep-layout {
                display: block;
            }

            .ep-main {
                width: 100%;
                margin-left: 0;
            }

            .ep-topbar {
                padding: 0 15px;
            }

            .ep-search {
                display: none;
            }
        }
    </style>

<style id="epusbonat-final-style">

/* =========================================================
   E-PUSBONAT WELCOME TICKER
   ========================================================= */

.epusbonat-ticker {
    width: 100%;
    background:
        linear-gradient(
            90deg,
            #0f766e 0%,
            #14b8a6 38%,
            #0f766e 65%,
            #172554 100%
        );
    padding: 7px 8px;
    overflow: hidden;
}

.epusbonat-ticker-frame {
    position: relative;
    width: 100%;
    height: 38px;
    overflow: hidden;

    border: 1px solid rgba(255,255,255,.45);
    border-radius: 12px;

    background:
        linear-gradient(
            90deg,
            rgba(20,184,166,.92),
            rgba(15,118,110,.92),
            rgba(23,37,84,.96)
        );

    box-shadow:
        0 0 0 1px rgba(255,255,255,.12) inset,
        0 3px 14px rgba(15,23,42,.18);
}

.epusbonat-ticker-frame::before {
    content: "";
    position: absolute;
    inset: 1px;
    border-radius: 11px;
    border: 1px solid rgba(255,255,255,.15);
    pointer-events: none;
}

.epusbonat-ticker-track {
    height: 100%;
    width: max-content;

    display: flex;
    align-items: center;
    gap: 18px;

    white-space: nowrap;

    animation: epusbonatTickerMove 22s linear infinite;
}

.epusbonat-message {
    color: #ffffff;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: .35px;

    text-shadow:
        0 1px 2px rgba(0,0,0,.35);
}

.epusbonat-arrow {
    color: #ffffff;
    font-size: 25px;
    font-weight: 900;
    line-height: 1;

    text-shadow:
        0 0 8px rgba(255,255,255,.35);
}

@keyframes epusbonatTickerMove {
    0% {
        transform: translateX(0);
    }

    100% {
        transform: translateX(-50%);
    }
}

@media (prefers-reduced-motion: reduce) {
    .epusbonat-ticker-track {
        animation: none;
        transform: translateX(0);
    }
}

/* =========================================================
   SEARCH E-PUSBONAT
   ========================================================= */

#globalSearch {
    outline: none;
    transition:
        box-shadow .2s ease,
        border-color .2s ease,
        background .2s ease;
}

#globalSearch:focus {
    border-color: rgba(20,184,166,.75);
    box-shadow:
        0 0 0 3px rgba(20,184,166,.15),
        0 8px 22px rgba(15,23,42,.08);
}

.epusbonat-search-result {
    position: fixed;
    z-index: 99999;

    min-width: 280px;
    max-width: 420px;

    background: #ffffff;
    border: 1px solid #dbeafe;
    border-radius: 14px;

    padding: 10px;

    box-shadow:
        0 18px 45px rgba(15,23,42,.18);

    font-size: 13px;
}

.epusbonat-search-result-title {
    font-weight: 800;
    color: #0f172a;
    padding: 7px 9px;
}

.epusbonat-search-result-item {
    display: block;
    width: 100%;

    border: 0;
    background: transparent;

    padding: 10px 9px;
    border-radius: 9px;

    text-align: left;
    cursor: pointer;

    color: #334155;
}

.epusbonat-search-result-item:hover {
    background: #ecfeff;
    color: #0f766e;
}

.epusbonat-search-empty {
    padding: 10px 9px;
    color: #64748b;
}

</style>


<style>
/* E-PUSBONAT RESPONSIVE MOBILE v2 */

.ep-mobile-toggle,
.ep-mobile-overlay {
    display: none;
}

@media (max-width: 768px) {

    html,
    body {
        overflow-x: hidden;
        width: 100%;
    }

    .ep-layout {
        display: block !important;
        width: 100% !important;
        min-height: 100vh;
    }

    /* SIDEBAR HP */
    .ep-sidebar {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        bottom: 0 !important;
        width: min(84vw, 300px) !important;
        min-width: 0 !important;
        height: 100vh !important;
        z-index: 100 !important;

        transform: translateX(-105%);
        transition: transform .25s ease;

        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch;

        box-shadow: 12px 0 35px rgba(0,0,0,.28);
    }

    .ep-layout.mobile-nav-open .ep-sidebar {
        transform: translateX(0);
    }

    /* OVERLAY */
    .ep-mobile-overlay {
        position: fixed;
        inset: 0;
        z-index: 90;
        background: rgba(2,15,24,.58);
        backdrop-filter: blur(2px);
    }

    .ep-layout.mobile-nav-open .ep-mobile-overlay {
        display: block;
    }

    /* MAIN */
    main {
        width: 100% !important;
        min-width: 0 !important;
        margin-left: 0 !important;
    }

    /* TOPBAR */
    header {
        min-height: 64px !important;
        height: auto !important;
        padding: 11px 14px !important;

        position: sticky !important;
        top: 0 !important;
        z-index: 80 !important;

        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        gap: 10px !important;
    }

    .ep-mobile-toggle {
        display: flex !important;

        width: 42px;
        min-width: 42px;
        height: 42px;

        align-items: center;
        justify-content: center;

        border: 1px solid rgba(20,184,166,.35);
        border-radius: 12px;

        background: rgba(15,118,110,.16);
        color: #5eead4;

        font-size: 21px;
        cursor: pointer;
    }

    header > div:first-child {
        min-width: 0 !important;
        flex: 1 1 auto !important;
        order: 1;
    }

    header > div:last-child {
        order: 2;
        margin-left: auto;
        flex-shrink: 0;
    }

    header h1 {
        font-size: 19px !important;
        line-height: 1.2 !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    header p {
        font-size: 10px !important;
        line-height: 1.3 !important;
    }

    /* KONTEN */
    main > section,
    .ep-content {
        padding: 18px !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    /* CARD / GRID */
    .grid {
        grid-template-columns: 1fr !important;
    }

    /* TABEL */
    .overflow-x-auto {
        width: 100%;
        max-width: 100%;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
    }

    table {
        min-width: 680px;
    }

    /* GAMBAR & GRAFIK */
    img,
    svg,
    canvas {
        max-width: 100%;
    }

    /* FORM HP */
    input,
    select,
    textarea {
        max-width: 100% !important;
    }

    button {
        max-width: 100%;
    }

    /* AREA SENTUH */
    .ep-sidebar nav a,
    .ep-sidebar nav button {
        min-height: 46px;
    }

    button,
    a {
        -webkit-tap-highlight-color: transparent;
    }
}

/* HP KECIL */
@media (max-width: 480px) {

    main > section,
    .ep-content {
        padding: 14px !important;
    }

    header h1 {
        font-size: 18px !important;
    }

    .ep-sidebar {
        width: 88vw !important;
    }
}
</style>

</head>

<body>

<!-- E-PUSBONAT WELCOME TICKER START -->
<div class="epusbonat-ticker">

    <div class="epusbonat-ticker-frame">

        <div class="epusbonat-ticker-track">

            <span class="epusbonat-arrow">»»</span>

            <span class="epusbonat-message">
                SELAMAT DATANG DI E-PUSBONAT. KAMI SIAP MELAYANI ANDA DENGAN RAPI.
            </span>

            <span class="epusbonat-arrow">««</span>

            <span class="epusbonat-message">
                SELAMAT DATANG DI E-PUSBONAT. KAMI SIAP MELAYANI ANDA DENGAN RAPI.
            </span>

        </div>

    </div>

</div>
<!-- E-PUSBONAT WELCOME TICKER END -->


<div class="ep-layout">

    {{-- SIDEBAR --}}
    <aside class="ep-sidebar">

        <div class="ep-brand">

            <div class="ep-brand-row">

                <div class="ep-logo">
                    <svg width="29" height="29" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L20 6V11.5C20 16.5 16.7 20 12 22C7.3 20 4 16.5 4 11.5V6L12 2Z"
                              stroke="currentColor" stroke-width="2"/>
                        <path d="M12 7V17M7 12H17"
                              stroke="currentColor" stroke-width="2.5"/>
                    </svg>
                </div>

                <div>
                    <div class="ep-brand-title">E-PUSBONAT</div>
                    <div class="ep-brand-sub">Puskesmas Naibonat</div>
                </div>

            </div>

            <div class="ep-motto">
                KAMI SIAP MELAYANI ANDA DENGAN RAPI.
            </div>

        </div>

        <nav class="ep-nav">

            {{-- DASHBOARD --}}
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          d="M3 10.5L12 3l9 7.5M5 9v11h14V9M9 20v-6h6v6"/>
                </svg>

                <span>Dashboard</span>
            </a>

            {{-- SPM --}}
            <a href="{{ route('spm.index') }}"
               class="{{ request()->routeIs('spm.*') ? 'active' : '' }}">

                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" d="M4 19V10"/>
                    <path stroke-width="2" stroke-linecap="round" d="M10 19V6"/>
                    <path stroke-width="2" stroke-linecap="round" d="M16 19V3"/>
                    <path stroke-width="2" stroke-linecap="round" d="M22 19V12"/>
                </svg>

                <span>SPM</span>
            </a>

            {{-- KESEHATAN JIWA --}}
            <a href="{{ route('kesehatan-jiwa.index') }}"
               class="{{ request()->routeIs('kesehatan-jiwa.*') ? 'active' : '' }}">

                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round"
                          d="M12 4a4 4 0 014 4v1a3 3 0 013 3v1a3 3 0 01-3 3"/>
                    <path stroke-width="2" stroke-linecap="round"
                          d="M12 4a4 4 0 00-4 4v1a3 3 0 00-3 3v1a3 3 0 003 3"/>
                    <path stroke-width="2" stroke-linecap="round" d="M12 4v16"/>
                    <path stroke-width="2" stroke-linecap="round" d="M8 12h8"/>
                </svg>

                <span>Kesehatan Jiwa</span>
            </a>

        </nav>

    </aside>

    {{-- MAIN --}}
    <div class="ep-main">

        <header class="ep-topbar">

            <div class="ep-search">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right:10px">
                    <circle cx="11" cy="11" r="7"/>
                    <path d="M20 20l-4-4"/>
                </svg>

                Cari indikator, bulan, atau tahun...
            </div>

            <div style="color:white;font-size:23px;">
                ♧
            </div>

            <div class="ep-user">

                <div>
                    <div style="font-size:14px;font-weight:700;">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </div>

                    <div style="font-size:12px;opacity:.75;">
                        Puskesmas Naibonat
                    </div>
                </div>

                <div class="ep-avatar">
                    A
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button style="background:none;border:0;color:white;font-size:12px;cursor:pointer;">
                        Keluar
                    </button>
                </form>

            </div>

        </header>

        <div class="ep-content">
            @yield('content')
        </div>

    </div>

</div>





<script id="epusbonat-search-script">
(function () {

    const search = document.getElementById('globalSearch');

    if (!search) {
        console.warn('E-PUSBONAT: search input tidak ditemukan.');
        return;
    }

    if (search.dataset.ready === 'true') {
        return;
    }

    search.dataset.ready = 'true';

    let box = null;

    /*
    |--------------------------------------------------------------------------
    | MENU UTAMA
    |--------------------------------------------------------------------------
    */

    const menus = [
        {
            name: 'Dashboard',
            keywords: [
                'dashboard',
                'beranda',
                'monitoring',
                'home'
            ],
            url: '/dashboard'
        },

        {
            name: 'SPM',
            keywords: [
                'spm',
                'standar pelayanan minimal',
                'indikator spm',
                'indikator'
            ],
            url: '/spm'
        },

        {
            name: 'Kesehatan Jiwa',
            keywords: [
                'kesehatan jiwa',
                'keswa',
                'odgj',
                'odgj berat',
                'f20',
                'f23',
                'obat',
                'pelacakan',
                'p3lp',
                'skrining'
            ],
            url: '/kesehatan-jiwa'
        }
    ];

    /*
    |--------------------------------------------------------------------------
    | HAPUS HASIL
    |--------------------------------------------------------------------------
    */

    function closeSearch() {

        if (box) {
            box.remove();
            box = null;
        }

    }

    /*
    |--------------------------------------------------------------------------
    | POSISI HASIL
    |--------------------------------------------------------------------------
    */

    function positionBox() {

        if (!box) {
            return;
        }

        const rect = search.getBoundingClientRect();

        box.style.position = 'fixed';
        box.style.left = rect.left + 'px';
        box.style.top = (rect.bottom + 8) + 'px';
        box.style.width = Math.min(
            Math.max(rect.width, 320),
            460
        ) + 'px';

    }

    /*
    |--------------------------------------------------------------------------
    | CARI ISI HALAMAN
    |--------------------------------------------------------------------------
    */

    function searchPage(query) {

        const q = query.toLowerCase().trim();

        if (!q) {
            return [];
        }

        const results = [];

        const elements = document.querySelectorAll(
            'main h1, main h2, main h3, main h4, main h5, ' +
            'main p, main span, main td, main th, main label, ' +
            'main button, main a'
        );

        elements.forEach(function (element) {

            if (results.length >= 8) {
                return;
            }

            const text =
                (element.textContent || '')
                .replace(/\s+/g, ' ')
                .trim();

            if (!text) {
                return;
            }

            if (text.toLowerCase().includes(q)) {

                results.push({
                    title:
                        text.length > 90
                            ? text.substring(0, 90) + '...'
                            : text,

                    element: element
                });

            }

        });

        return results;

    }

    /*
    |--------------------------------------------------------------------------
    | CARI MENU
    |--------------------------------------------------------------------------
    */

    function searchMenus(query) {

        const q = query.toLowerCase().trim();

        if (!q) {
            return menus;
        }

        return menus.filter(function (menu) {

            return (
                menu.name.toLowerCase().includes(q)
                ||
                menu.keywords.some(function (keyword) {
                    return keyword.includes(q)
                        || q.includes(keyword);
                })
            );

        });

    }

    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN HASIL
    |--------------------------------------------------------------------------
    */

    function showResults(query) {

        closeSearch();

        box = document.createElement('div');

        box.className =
            'epusbonat-search-result';

        box.style.zIndex = '999999';

        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        const heading = document.createElement('div');

        heading.className =
            'epusbonat-search-result-title';

        heading.textContent =
            query.trim()
                ? 'Hasil Pencarian'
                : 'Menu E-PUSBONAT';

        box.appendChild(heading);

        /*
        |--------------------------------------------------------------------------
        | MENU
        |--------------------------------------------------------------------------
        */

        const menuResults =
            searchMenus(query);

        menuResults.forEach(function (menu) {

            const button =
                document.createElement('button');

            button.type = 'button';

            button.className =
                'epusbonat-search-result-item';

            button.innerHTML =
                '<strong>' +
                menu.name +
                '</strong>' +
                '<br>' +
                '<small style="color:#64748b;">' +
                menu.url +
                '</small>';

            button.addEventListener(
                'click',
                function () {

                    window.location.href =
                        menu.url;

                }
            );

            box.appendChild(button);

        });

        /*
        |--------------------------------------------------------------------------
        | ISI HALAMAN
        |--------------------------------------------------------------------------
        */

        if (query.trim()) {

            const pageResults =
                searchPage(query);

            pageResults.forEach(function (item) {

                const button =
                    document.createElement('button');

                button.type = 'button';

                button.className =
                    'epusbonat-search-result-item';

                button.textContent =
                    item.title;

                button.addEventListener(
                    'click',
                    function () {

                        item.element.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        item.element.style.transition =
                            'background .3s ease';

                        item.element.style.background =
                            '#ccfbf1';

                        setTimeout(function () {

                            item.element.style.background =
                                '';

                        }, 1800);

                        closeSearch();

                    }
                );

                box.appendChild(button);

            });

        }

        /*
        |--------------------------------------------------------------------------
        | TIDAK ADA HASIL
        |--------------------------------------------------------------------------
        */

        if (
            box.children.length === 1
        ) {

            const empty =
                document.createElement('div');

            empty.className =
                'epusbonat-search-empty';

            empty.textContent =
                'Tidak ditemukan. Coba kata kunci lain.';

            box.appendChild(empty);

        }

        document.body.appendChild(box);

        positionBox();

    }

    /*
    |--------------------------------------------------------------------------
    | KETIKA USER MENGETIK
    |--------------------------------------------------------------------------
    */

    search.addEventListener(
        'input',
        function () {

            showResults(
                search.value
            );

        }
    );

    /*
    |--------------------------------------------------------------------------
    | KETIKA SEARCH DIKLIK
    |--------------------------------------------------------------------------
    */

    search.addEventListener(
        'focus',
        function () {

            showResults(
                search.value
            );

        }
    );

    /*
    |--------------------------------------------------------------------------
    | ENTER
    |--------------------------------------------------------------------------
    */

    search.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Enter') {
                return;
            }

            event.preventDefault();

            const query =
                search.value.trim();

            if (!query) {
                return;
            }

            const menusFound =
                searchMenus(query);

            /*
            | Kalau cocok dengan satu menu,
            | langsung buka.
            */

            if (menusFound.length === 1) {

                window.location.href =
                    menusFound[0].url;

                return;

            }

            /*
            | Kalau tidak cocok menu,
            | cari di halaman.
            */

            const pageResults =
                searchPage(query);

            if (
                pageResults.length > 0
            ) {

                pageResults[0].element.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                pageResults[0].element.style.background =
                    '#ccfbf1';

                setTimeout(function () {

                    pageResults[0].element.style.background =
                        '';

                }, 1800);

                closeSearch();

            }

        }
    );

    /*
    |--------------------------------------------------------------------------
    | KLIK DI LUAR SEARCH
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            if (
                box &&
                event.target !== search &&
                !box.contains(event.target)
            ) {

                closeSearch();

            }

        }
    );

    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE POSITION
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'resize',
        positionBox
    );

    window.addEventListener(
        'scroll',
        positionBox,
        true
    );

    console.log(
        '✅ E-PUSBONAT SEARCH AKTIF'
    );

})();
</script>


<script>
/* E-PUSBONAT MOBILE NAV v2 */

document.addEventListener("DOMContentLoaded", function () {

    const layout = document.querySelector(".ep-layout");
    const sidebar = document.querySelector(".ep-sidebar");
    const header = document.querySelector("header");

    if (!layout || !sidebar || !header) return;

    if (document.querySelector(".ep-mobile-toggle")) return;

    const button = document.createElement("button");

    button.type = "button";
    button.className = "ep-mobile-toggle";
    button.setAttribute("aria-label", "Buka menu");
    button.setAttribute("aria-expanded", "false");
    button.innerHTML = "☰";

    header.insertBefore(button, header.firstChild);

    const overlay = document.createElement("div");

    overlay.className = "ep-mobile-overlay";
    overlay.setAttribute("aria-hidden", "true");

    layout.appendChild(overlay);

    function closeMenu() {

        layout.classList.remove("mobile-nav-open");

        button.setAttribute("aria-expanded", "false");
        button.innerHTML = "☰";

        document.body.style.overflow = "";
    }

    button.addEventListener("click", function () {

        const open =
            layout.classList.toggle("mobile-nav-open");

        button.setAttribute(
            "aria-expanded",
            open ? "true" : "false"
        );

        button.innerHTML = open ? "✕" : "☰";

        document.body.style.overflow =
            open ? "hidden" : "";
    });

    overlay.addEventListener("click", closeMenu);

    sidebar.querySelectorAll("a").forEach(function (link) {
        link.addEventListener("click", closeMenu);
    });

});
</script>

</body>
</html>





<script>
document.addEventListener('DOMContentLoaded', function () {

    const search = document.getElementById('globalSearch');

    if (!search) return;

    search.placeholder = 'Cari menu atau data...';

    search.addEventListener('keydown', function (event) {

        if (event.key !== 'Enter') return;

        const keyword = search.value.trim().toLowerCase();

        if (!keyword) return;

        const routes = [
            {
                keywords: ['dashboard', 'beranda'],
                url: '/dashboard'
            },
            {
                keywords: ['spm', 'standar pelayanan minimal'],
                url: '/spm'
            },
            {
                keywords: ['kesehatan jiwa', 'keswa', 'odgj', 'odgj berat'],
                url: '/kesehatan-jiwa'
            }
        ];

        for (const item of routes) {

            if (
                item.keywords.some(function (word) {
                    return word.includes(keyword) || keyword.includes(word);
                })
            ) {
                window.location.href = item.url;
                return;
            }
        }

        // Pencarian pada halaman aktif
        const elements = document.querySelectorAll(
            'h1, h2, h3, h4, td, th, p, span, a, button, label'
        );

        for (const element of elements) {

            const text = (element.innerText || '').toLowerCase();

            if (text.includes(keyword)) {

                element.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                element.style.outline = '3px solid #14b8a6';
                element.style.outlineOffset = '4px';

                setTimeout(function () {
                    element.style.outline = '';
                    element.style.outlineOffset = '';
                }, 2500);

                return;
            }
        }

        alert('Data atau menu "' + search.value + '" tidak ditemukan.');
    });
});
</script>
