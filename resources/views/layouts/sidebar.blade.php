<style>
    .menu-vertical .app-brand {
        padding-right: 2rem;
        padding-left: 1rem;
    }

    .text-warn {
        color: #fc7300;
    }

    .item-info {
        color: #36b0b0;
        margin-left: 15px;
    }

    .app-brand span {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 1.5rem;
        font-style: italic;
        white-space: nowrap;
        font-weight: bold;
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        {{-- <a href="/dashboard-app" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('admin/assets/img/icons/statistics.png') }}" style="width: 38px; height:40px" />
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2 ">Level Stock Report</span>
        </a> --}}
        <a style="text-decoration:none" href="/dashboard-app">
            <span class="item-info">SI</span><span class="text-warn">MAS</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <!-- Layouts -->
        <li class="menu-item {{ Request::is('/')  ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div data-i18n="Basic">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('archive*') ? 'active' : '' }}">
            <a href="/archive" class="menu-link">
                <i class="menu-icon tf-icons bx bx-envelope"></i>
                <div data-i18n="Basic">Arsip</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('kategori') ? 'active' : '' }}">
            <a href="{{ route('kategori.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-category"></i>
                <div data-i18n="Basic">Kategori Surat</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('about') ? 'active' : '' }}">
            <a href="/about" class="menu-link">
                <i class="menu-icon tf-icons bx bx-info-circle"></i>
                <div data-i18n="Basic">About</div>
            </a>
        </li>
    </ul>

</aside>