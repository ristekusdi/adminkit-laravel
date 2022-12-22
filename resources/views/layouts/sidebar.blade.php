<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="/">
            <span class="align-middle">{{ config('app.name', 'Laravel') }}</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            @if (is_active_path('/'))
                <li class="sidebar-item active">
            @else
                <li class="sidebar-item">
            @endif
                <a class="sidebar-link" href="/">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Home</span>
                </a>
            </li>

            {!! load_app_menu() !!}
        </ul>
    </div>
</nav>