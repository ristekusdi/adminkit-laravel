<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="/">
            <span class="align-middle">{{ config('app.name', 'Laravel') }}</span>
        </a>

        <div class="sidebar-header">
            <form class="mt-1">
                <label for="roles" class="form-label">Peran</label>
                <select id="roles" onchange="changeRoleActive(this);" class="form-select" placeholder="Masukkan peran">
                    @foreach (auth('imissu-web')->user()->roles() as $role)
                        <option value="{{ $role['name'] }}"
                        {{ (auth('imissu-web')->user()->role_active['name'] === $role['name']) ? 'selected' : '' }}>{{ $role['name'] }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="url_change_role_active" value="{{ url('/web-session/change-role-active') }}">
            </form>
        </div>

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

            {!! load_app_menu(auth('imissu-web')->user()->role_active['name']) !!}
        </ul>
    </div>
</nav>