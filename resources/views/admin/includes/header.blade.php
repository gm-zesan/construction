<header>
    <div id="top-navbar" class="container-fluid">
        <div>
            <i class="ri-menu-2-line" id="btn" style="font-size: 22px; cursor: pointer;"></i>
        </div>
        <ul class="mb-0">
            <!-- User Profile Dropdown -->
            <li class="dropdown position-relative">
                <a href="javascript:void(0)" class="dropdown-toggle text-decoration-none" id="profileDropdownBtn" role="button" aria-expanded="false" style="cursor: pointer; padding: 4px 10px; border-radius: 8px; transition: all 0.2s ease; display: inline-flex; align-items: center; background-color: #f8fafc; border: 1px solid #e2e8f0;">
                    <div class="d-flex align-items-center"> 
                        <div class="me-2">
                            @if(Auth::check() && !empty(Auth::user()->image) && file_exists(public_path(Auth::user()->image)))
                                <img id="profileImageDB" src="{{ asset(Auth::user()->image) }}" alt="img" width="32" height="32" class="rounded-circle object-fit-cover" style="border: 2px solid #f95716;"> 
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; background-color: #f95716; font-weight: 700; font-size: 13px; box-shadow: 0 2px 6px rgba(249, 87, 22, 0.3);">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                            @endif
                        </div> 
                        <div class="d-none d-sm-block text-start me-1"> 
                            <p class="fw-semibold mb-0 lh-1" style="font-size: 13px; color: #111a3a;">{{ Auth::user()->name ?? 'Admin User' }}</p>
                            <span class="op-7 fw-normal d-block" style="font-size: 11px; color: #718096; margin-top: 2px;">{{ Auth::user()->designation ?? 'Site Administrator' }}</span>
                        </div>
                        <i class="ri-arrow-down-s-line text-muted ms-1" style="font-size: 14px;"></i>
                    </div>
                </a>

                <div class="main-header-dropdown dropdown-menu dropdown-menu-end border-0" style="min-width: 275px; border-radius: 10px; overflow: hidden; padding: 0; box-shadow: 0 10px 25px -3px rgba(15, 23, 42, 0.12), 0 4px 6px -2px rgba(15, 23, 42, 0.05), 0 0 0 1px #e2e8f0; margin-top: 4px !important;">
                    {{-- User Profile Header Strip --}}
                    <div class="px-3 py-3 border-bottom" style="background-color: #f8fafc;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            @if(Auth::check() && !empty(Auth::user()->image) && file_exists(public_path(Auth::user()->image)))
                                <img src="{{ asset(Auth::user()->image) }}" alt="img" width="38" height="38" class="rounded-circle object-fit-cover" style="border: 2px solid #f95716;"> 
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 38px; height: 38px; background-color: #f95716; font-weight: 700; font-size: 15px; flex-shrink: 0;">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                            @endif
                            <div class="text-truncate" style="line-height: 1.25;">
                                <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 13.5px;">{{ Auth::user()->name ?? 'Administrator' }}</h6>
                                <span class="text-muted d-block text-truncate" style="font-size: 11.5px;">{{ Auth::user()->email ?? '' }}</span>
                            </div>
                        </div>
                        @php
                            $roleName = Auth::user()?->roles->first()?->name ?? 'Administrator';
                            $roleBadgeStyle = match($roleName) {
                                'superadmin' => 'background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;',
                                'admin' => 'background-color: #fff3ee; color: #f95716; border: 1px solid rgba(249, 87, 22, 0.3);',
                                'project-manager' => 'background-color: #e0f2fe; color: #075985; border: 1px solid #7dd3fc;',
                                default => 'background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;',
                            };
                        @endphp
                        <div class="d-flex align-items-center justify-content-between pt-1">
                            <span class="badge" style="{{ $roleBadgeStyle }} font-size: 10.5px; padding: 3px 8px; border-radius: 4px; font-weight: 600;">
                                {{ ucwords(str_replace('-', ' ', $roleName)) }}
                            </span>
                            <span class="text-muted" style="font-size: 11px;">
                                <i class="ri-checkbox-circle-fill text-success me-1"></i>Online
                            </span>
                        </div>
                    </div>

                    {{-- Navigation Links --}}
                    <div class="p-2">
                        <a class="dropdown-item d-flex align-items-center justify-content-between py-2 px-2 rounded" href="{{ route('profile.edit') }}" style="font-size: 13px; font-weight: 500; color: #334155;">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded me-2" style="width: 28px; height: 28px; background-color: #fff3ee; color: #f95716;">
                                    <i class="ri-user-settings-line" style="font-size: 15px;"></i>
                                </div>
                                <span>Profile &amp; Settings</span>
                            </div>
                            <i class="ri-arrow-right-s-line text-muted" style="font-size: 14px;"></i>
                        </a>

                        <a class="dropdown-item d-flex align-items-center justify-content-between py-2 px-2 rounded" href="{{ route('home') }}" target="_blank" style="font-size: 13px; font-weight: 500; color: #334155;">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded me-2" style="width: 28px; height: 28px; background-color: #eff6ff; color: #2563eb;">
                                    <i class="ri-global-line" style="font-size: 15px;"></i>
                                </div>
                                <span>View Live Website</span>
                            </div>
                            <i class="ri-external-link-line text-muted" style="font-size: 13px;"></i>
                        </a>

                        <a class="dropdown-item d-flex align-items-center justify-content-between py-2 px-2 rounded" href="{{ route('admin.clear-cache') }}" onclick="clearAdminCache(event, this)" style="font-size: 13px; font-weight: 500; color: #334155;">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded me-2" style="width: 28px; height: 28px; background-color: #f1f5f9; color: #475569;">
                                    <i class="ri-brush-line" id="dropdownClearCacheIcon" style="font-size: 15px;"></i>
                                </div>
                                <span>Clear System Cache</span>
                            </div>
                            <i class="ri-refresh-line text-muted" style="font-size: 13px;"></i>
                        </a>
                    </div>

                    {{-- Logout Footer --}}
                    <div class="p-2 border-top" style="background-color: #fafbfc;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center py-2 px-2 rounded text-danger w-100 border-0 bg-transparent" style="font-size: 13px; font-weight: 600; cursor: pointer;">
                                <div class="d-flex align-items-center justify-content-center rounded me-2" style="width: 28px; height: 28px; background-color: #fee2e2; color: #ef4444;">
                                    <i class="ri-logout-box-r-line" style="font-size: 15px;"></i>
                                </div>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>

<script>
function clearAdminCache(event, el) {
    event.preventDefault();
    var $icon = $('#dropdownClearCacheIcon');
    $icon.addClass('ri-spin');
    
    $.ajax({
        url: "{{ route('admin.clear-cache') }}",
        type: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function(res) {
            $icon.removeClass('ri-spin');
            if (typeof toastr !== 'undefined') {
                toastr.success(res.message || 'System cache cleared successfully!', 'Cache Cleared');
            } else {
                alert('System cache cleared successfully!');
            }
        },
        error: function(xhr) {
            $icon.removeClass('ri-spin');
            if (typeof toastr !== 'undefined') {
                toastr.error('Failed to clear cache. Please try again.', 'Error');
            } else {
                alert('Failed to clear cache.');
            }
        }
    });
}
</script>
