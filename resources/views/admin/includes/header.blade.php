<header>
    <div id="top-navbar" class="container-fluid">
        <div>
            <i class="ri-menu-2-line" id="btn" style="font-size: 22px; cursor: pointer;"></i>
        </div>
        <ul>
            <!-- Global / Live Website Link -->
            <li>
                <a href="{{ route('home') }}" target="_blank" class="icon" title="View Live Website" style="font-size: 18px;" data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <i class="ri-global-line"></i>
                </a>
            </li>

            <!-- Clear Cache Link -->
            <li>
                <a href="{{ route('admin.clear-cache') }}" id="headerClearCacheBtn" class="icon" title="Clear System Cache" style="font-size: 18px;" onclick="clearAdminCache(event, this)">
                    <i class="ri-brush-line" id="headerClearCacheIcon"></i>
                </a>
            </li>

            <!-- User Profile Dropdown -->
            <li class="dropdown position-relative">
                <a href="javascript:void(0)" class="dropdown-toggle text-decoration-none" id="profileDropdownBtn" role="button" aria-expanded="false">
                    <div class="d-flex align-items-center"> 
                        <div class="me-sm-2 me-0">
                            @if(Auth::check() && !empty(Auth::user()->image))
                                <img id="profileImageDB" src="{{ asset(Auth::user()->image) }}" alt="img" width="32" height="32" class="rounded-circle object-fit-cover"> 
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; background-color: #f95716; font-weight: 700; font-size: 13px;">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                            @endif
                        </div> 
                        <div class="d-none d-sm-block text-start"> 
                            <p class="fw-semibold mb-0 lh-1" style="font-size: 13px; color: #111a3a;">{{ Auth::user()->name ?? 'Admin User' }}</p>
                            <span class="op-7 fw-normal d-block" style="font-size: 11px; color: #718096;">{{ Auth::user()->designation ?? 'Site Administrator' }}</span>
                        </div>
                    </div>
                </a>

                <ul class="main-header-dropdown dropdown-menu dropdown-menu-end shadow-sm border-0" style="min-width: 200px; border-radius: 8px;">
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('profile.edit') }}">
                            <i class="ri-user-3-line fs-18 me-2" style="color: #f95716;"></i>Profile Settings
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item d-flex align-items-center py-2 text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="ri-logout-box-r-line fs-18 me-2"></i>Log Out
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</header>

<script>
function clearAdminCache(event, el) {
    event.preventDefault();
    var $icon = $('#headerClearCacheIcon');
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
