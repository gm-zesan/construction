<div class="sidebar sidebar-navigation active">
    <div class="logo_content">
        <a href="{{ route('dashboard') }}" class="logo">
            <div class="logo-icon d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: #f95716; border-radius: 8px; color: #fff; flex-shrink: 0;">
                <i class="ri-building-2-fill" style="font-size: 20px;"></i>
            </div>
            <div class="logo_name">
                <div class="d-flex align-items-center">
                    <div class="d-flex flex-column text-start" style="line-height: 1.15; margin-left: 10px;">
                        <span style="font-size: 15px; font-weight: 800; color: #111A3A; letter-spacing: -0.01em; white-space: nowrap;">BUILDING &amp; CO.</span>
                        <span style="font-size: 9.5px; font-weight: 700; color: #f95716; text-transform: uppercase; letter-spacing: 0.1em; white-space: nowrap;">Construction Admin</span>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <ul class="nav_list ps-0 scrollbar">
        <!-- Main / Dashboard -->
        <li class="category-li">
            <span class="link_names">Main</span>
        </li>
        <li>
            <a href="{{ route('dashboard') }}" class="{{ Route::is('dashboard') ? ' active-focus' : '' }}">
                <i class="ri-dashboard-3-line"></i>
                <span class="link_names">Dashboard</span>
            </a>
        </li>

        <!-- Projects & Field Operations -->
        <li class="category-li">
            <span class="link_names">Projects & Operations</span>
        </li>
        <li>
            <a href="{{ route('dashboard') }}#projects-table" class="{{ request()->is('*project*') ? 'active-focus' : '' }}">
                <i class="ri-community-line"></i>
                <span class="link_names">Project Portfolio</span>
            </a>
        </li>
        <li>
            <a href="{{ route('dashboard') }}#services-summary">
                <i class="ri-hammer-line"></i>
                <span class="link_names">Core Services</span>
            </a>
        </li>
        <li>
            <a href="{{ route('dashboard') }}#milestones">
                <i class="ri-time-line"></i>
                <span class="link_names">Site Milestones</span>
            </a>
        </li>

        <!-- Communications & Content -->
        <li class="category-li">
            <span class="link_names">Inquiries & Editorial</span>
        </li>
        <li>
            <a href="{{ route('dashboard') }}#messages">
                <i class="ri-mail-open-line"></i>
                <span class="link_names">Client Inquiries</span>
            </a>
        </li>
        <li>
            <a href="{{ route('dashboard') }}#news">
                <i class="ri-article-line"></i>
                <span class="link_names">News & Articles</span>
            </a>
        </li>
        <li>
            <a href="{{ route('dashboard') }}#testimonials">
                <i class="ri-feedback-line"></i>
                <span class="link_names">Client Reviews</span>
            </a>
        </li>

        <!-- User & Access Management -->
        @canany(['user-list', 'user-create', 'user-edit', 'user-delete', 'role-list', 'role-create', 'role-edit', 'role-delete', 'assignrole-list', 'assignrole-create'])
            <li class="category-li">
                <span class="link_names">User Management</span>
            </li>
        @endcanany

        @canany(['user-list', 'user-create', 'user-edit', 'user-delete'])
        <li class="drop-item">
            <a href="{{ route('users') }}"
                class="{{ in_array(Route::currentRouteName(), ['users', 'user.create', 'user.edit']) ? 'active-focus' : '' }}">
                <i class="ri-user-3-line"></i>
                <span class="link_names">User List</span>
            </a>
        </li>
        @endcan

        @canany(['role-list', 'role-create', 'role-edit', 'role-delete'])
        <li class="drop-item">
            <a href="{{ route('role.index') }}"
                class="{{ in_array(Route::currentRouteName(), ['role.index', 'role.create', 'role.edit']) ? 'active-focus' : '' }}">
                <i class="ri-shield-user-line"></i>
                <span class="link_names">Roles & Permissions</span>
            </a>
        </li>
        @endcan


        <!-- Site Configuration & Administration -->
        <li class="category-li">
            <span class="link_names">Administration</span>
        </li>
        <li>
            <a href="{{ url('/ckeditor') }}" class="{{ request()->is('ckeditor*') ? 'active-focus' : '' }}">
                <i class="ri-edit-2-line"></i>
                <span class="link_names">Rich Text Studio</span>
            </a>
        </li>
        <li>
            <a href="{{ route('profile.edit') }}" class="{{ Route::is('profile.edit') ? 'active-focus' : '' }}">
                <i class="ri-settings-3-line"></i>
                <span class="link_names">Profile Settings</span>
            </a>
        </li>
        <li>
            <a href="{{ route('home') }}" target="_blank">
                <i class="ri-external-link-line"></i>
                <span class="link_names">View Live Site</span>
            </a>
        </li>
    </ul>

    <div class="profile_content">
        <div class="profile">
            <div class="profile_details">
                @if(Auth::check() && !empty(Auth::user()->image))
                    <img id="sidebarImageDB" src="{{ asset(Auth::user()->image) }}" alt="img" width="34" height="34" class="rounded-circle object-fit-cover">
                @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 34px; height: 34px; background-color: #f95716; font-weight: 700; font-size: 13px; flex-shrink: 0;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                @endif

                <div class="name_job ms-2">
                    <div class="name" style="font-size: 13px; font-weight: 600; color: #111a3a;">{{ Auth::user()->name ?? 'Admin User' }}</div>
                    <div class="job" style="font-size: 11px; color: #718096;">{{ Auth::user()->designation ?? 'Site Administrator' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="d-flex" onclick="event.preventDefault(); this.closest('form').submit();" title="Log Out">
                    <i class="ri-logout-box-r-line" id="log_out"></i>
                </a>
            </form>
        </div>
    </div>
</div>
