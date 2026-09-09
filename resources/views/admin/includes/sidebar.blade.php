<div class="sidebar sidebar-navigation active">
    <div class="logo_content">
        <a href="{{ route('dashboard') }}" class="logo">
            <div class="logo-icon d-flex align-items-center justify-content-center"
                style="width: 38px; height: 38px; background-color: #f95716; border-radius: 8px; color: #fff; flex-shrink: 0;">
                <i class="ri-building-2-fill" style="font-size: 20px;"></i>
            </div>
            <div class="logo_name">
                <div class="d-flex align-items-center">
                    <div class="d-flex flex-column text-start" style="line-height: 1.15; margin-left: 10px;">
                        <span
                            style="font-size: 15px; font-weight: 800; color: #111A3A; letter-spacing: -0.01em; white-space: nowrap;">BUILDING
                            &amp; CO.</span>
                        <span
                            style="font-size: 9.5px; font-weight: 700; color: #f95716; text-transform: uppercase; letter-spacing: 0.1em; white-space: nowrap;">Construction
                            Admin</span>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <ul class="nav_list ps-0 scrollbar">
        <!-- 1. Overview -->
        <li class="category-li">
            <span class="link_names">Overview</span>
        </li>
        <li>
            <a href="{{ route('dashboard') }}" class="{{ Route::is('dashboard') ? ' active-focus' : '' }}">
                <i class="ri-dashboard-3-line"></i>
                <span class="link_names">Dashboard</span>
            </a>
        </li>

        <!-- 2. Operations & Portfolio -->
        @canany(['project-list', 'project-create', 'project-edit', 'project-delete', 'service-list', 'service-create', 'service-edit', 'service-delete', 'milestone-list', 'milestone-create', 'milestone-edit', 'milestone-delete'])
            <li class="category-li">
                <span class="link_names">Operations</span>
            </li>
        @endcanany
        @canany(['project-list', 'project-create', 'project-edit', 'project-delete'])
            <li>
                <a href="{{ route('projects.index') }}"
                    class="{{ request()->routeIs('projects.*') ? 'active-focus' : '' }}">
                    <i class="ri-community-line"></i>
                    <span class="link_names">Project Portfolio</span>
                </a>
            </li>
        @endcanany
        @canany(['service-list', 'service-create', 'service-edit', 'service-delete'])
            <li>
                <a href="{{ route('services.index') }}"
                    class="{{ request()->routeIs('services.*') ? 'active-focus' : '' }}">
                    <i class="ri-hammer-line"></i>
                    <span class="link_names">Core Services</span>
                </a>
            </li>
        @endcanany
        @canany(['milestone-list', 'milestone-create', 'milestone-edit', 'milestone-delete'])
            <li>
                <a href="{{ route('milestones.index') }}"
                    class="{{ request()->routeIs('milestones.*') ? 'active-focus' : '' }}">
                    <i class="ri-flag-2-line"></i>
                    <span class="link_names">Project Milestones</span>
                </a>
            </li>
        @endcanany

        <!-- 3. Editorial & Communications -->
        @canany(['contact-list', 'article-list', 'article-create', 'article-edit', 'article-delete', 'article-category-list', 'article-category-create', 'article-category-edit', 'article-category-delete', 'media-list', 'media-create', 'media-edit', 'media-delete', 'client-review-list', 'client-review-create', 'client-review-edit', 'client-review-delete'])
            <li class="category-li">
                <span class="link_names">Editorial & Inquiries</span>
            </li>
        @endcanany
        @can('contact-list')
            <li>
                <a href="{{ route('enquiries.index') }}"
                    class="{{ request()->routeIs('enquiries.*') ? 'active-focus' : '' }}">
                    <i class="ri-mail-open-line"></i>
                    <span class="link_names">Client Inquiries</span>
                </a>
            </li>
        @endcan
        @canany(['article-list', 'article-create', 'article-edit', 'article-delete', 'blog-list', 'blog-create', 'blog-edit', 'blog-delete'])
            <li>
                <a href="{{ route('articles.index') }}"
                    class="{{ request()->routeIs('articles.*') ? 'active-focus' : '' }}">
                    <i class="ri-article-line"></i>
                    <span class="link_names">News & Articles</span>
                </a>
            </li>
        @endcanany
        @canany(['article-category-list', 'article-category-create', 'article-category-edit', 'article-category-delete'])
            <li>
                <a href="{{ route('article-categories.index') }}"
                    class="{{ request()->routeIs('article-categories.*') ? 'active-focus' : '' }}">
                    <i class="ri-price-tag-3-line"></i>
                    <span class="link_names">Article Categories</span>
                </a>
            </li>
        @endcanany
        @canany(['media-list', 'media-create', 'media-edit', 'media-delete'])
            <li>
                <a href="{{ route('media.index') }}" class="{{ request()->routeIs('media.*') ? 'active-focus' : '' }}">
                    <i class="ri-folder-image-line"></i>
                    <span class="link_names">Media Library</span>
                </a>
            </li>
        @endcanany
        @canany(['client-review-list', 'client-review-create', 'client-review-edit', 'client-review-delete'])
            <li>
                <a href="{{ route('client-reviews.index') }}"
                    class="{{ request()->routeIs('client-reviews.*') ? 'active-focus' : '' }}">
                    <i class="ri-feedback-line"></i>
                    <span class="link_names">Client Reviews</span>
                </a>
            </li>
        @endcanany

        <!-- 4. Access Control & Users -->
        @canany(['user-list', 'user-create', 'user-edit', 'user-delete', 'role-list', 'role-create', 'role-edit', 'role-delete', 'assignrole-list', 'assignrole-create'])
            <li class="category-li">
                <span class="link_names">Access Control</span>
            </li>
        @endcanany

        @canany(['user-list', 'user-create', 'user-edit', 'user-delete'])
            <li>
                <a href="{{ route('users') }}"
                    class="{{ in_array(Route::currentRouteName(), ['users', 'user.create', 'user.edit']) ? 'active-focus' : '' }}">
                    <i class="ri-user-3-line"></i>
                    <span class="link_names">User Accounts</span>
                </a>
            </li>
        @endcanany

        @canany(['role-list', 'role-create', 'role-edit', 'role-delete'])
            <li>
                <a href="{{ route('role.index') }}"
                    class="{{ in_array(Route::currentRouteName(), ['role.index', 'role.create', 'role.edit']) ? 'active-focus' : '' }}">
                    <i class="ri-shield-user-line"></i>
                    <span class="link_names">Roles &amp; Access</span>
                </a>
            </li>
            <li>
                <a href="{{ route('permissions.index') }}"
                    class="{{ request()->routeIs('permissions.*') ? 'active-focus' : '' }}">
                    <i class="ri-key-2-line"></i>
                    <span class="link_names">Permissions</span>
                </a>
            </li>
        @endcanany

        @canany(['activity-list', 'user-list', 'role-list'])
            <li>
                <a href="{{ route('activity-logs.index') }}"
                    class="{{ request()->routeIs('activity-logs.*') ? 'active-focus' : '' }}">
                    <i class="ri-history-line"></i>
                    <span class="link_names">Activity Logs</span>
                </a>
            </li>
        @endcanany

        <!-- 5. Website Settings -->
        @canany(['website-setting-list', 'website-setting-edit'])
            <li class="category-li">
                <span class="link_names">Website Settings</span>
            </li>
            @php
                $settingGroupMeta = \App\Models\WebsiteSetting::getGroupMeta();
                $currentSettingGroup = request('group', 'general');
            @endphp
            @foreach($settingGroupMeta as $sGroupKey => $sMeta)
                <li>
                    <a href="{{ route('settings.index', ['group' => $sGroupKey]) }}"
                        class="{{ request()->routeIs('settings.*') && $currentSettingGroup === $sGroupKey && !request()->has('create_group') ? 'active-focus' : '' }}">
                        <i class="{{ $sMeta['nav_icon'] ?? 'ri-settings-4-line' }}"></i>
                        <span class="link_names">{{ $sMeta['title'] }}</span>
                    </a>
                </li>
            @endforeach

            @if(Auth::check() && (Auth::user()->hasRole('superadmin') || Auth::user()->can('website-setting-create')))
                <li>
                    <a href="{{ route('settings.index', ['create_group' => '1']) }}"
                        class="{{ request()->routeIs('settings.*') && request()->has('create_group') ? 'active-focus' : '' }}"
                        style="color: #f95716; font-weight: 600;" title="Create New Settings Group">
                        <i class="ri-add-circle-line" style="color: #f95716;"></i>
                        <span class="link_names">+ New Group</span>
                    </a>
                </li>
            @endif
        @endcanany


        <!-- 6. Dedicated Content Management -->
        @canany(['website-content-list', 'website-content-create', 'website-content-edit', 'website-content-delete'])
            <li class="category-li">
                <span class="link_names">Content Management</span>
            </li>
            @php
                $cmsPages = \App\Models\WebsiteContent::getAvailablePagesWithMeta();
                $currentCmsPage = request('page', array_key_first($cmsPages) ?? 'home');
            @endphp
            @foreach($cmsPages as $pKey => $pMeta)
                <li>
                    <a href="{{ route('content-management.index', ['page' => $pKey]) }}"
                        class="{{ request()->routeIs('content-management.*') && $currentCmsPage === $pKey ? 'active-focus' : '' }}">
                        <i class="{{ $pMeta['icon'] }}"></i>
                        <span class="link_names">{{ $pMeta['title'] }}</span>
                    </a>
                </li>
            @endforeach
        @endcanany
    </ul>

    <div class="profile_content">
        <div class="profile">
            <div class="profile_details">
                @if(Auth::check() && !empty(Auth::user()->image))
                    <img id="sidebarImageDB" src="{{ asset(Auth::user()->image) }}" alt="img" width="34" height="34"
                        class="rounded-circle object-fit-cover">
                @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                        style="width: 34px; height: 34px; background-color: #f95716; font-weight: 700; font-size: 13px; flex-shrink: 0;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                @endif

                <div class="name_job ms-2">
                    <div class="name" style="font-size: 13px; font-weight: 600; color: #111a3a;">
                        {{ Auth::user()->name ?? 'Admin User' }}</div>
                    <div class="job" style="font-size: 11px; color: #718096;">
                        {{ Auth::user()->designation ?? 'Site Administrator' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="d-flex"
                    onclick="event.preventDefault(); this.closest('form').submit();" title="Log Out">
                    <i class="ri-logout-box-r-line" id="log_out"></i>
                </a>
            </form>
        </div>
    </div>
</div>