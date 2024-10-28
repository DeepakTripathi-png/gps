<aside class="sidebar-wrapper">
    <div class="sidebar-header">
      <div class="logo-icon">
        <a class="sidebar__main-logo" href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/images/logo-icon.svg')}}" class="logo-img w-50" alt=""></a>
      </div>
      <div class="sidebar-close ">
        <span class="material-symbols-outlined">close</span>
      </div>
    </div>
    <div class="sidebar-nav" data-simplebar="true">
      <ul class="metismenu" id="menu">

        @can(['admin.dashboard'])
        <li>
          <a href="{{ route("admin.dashboard") }}">
            <div class="parent-icon"><span class="material-symbols-outlined">home</span></div>
            <div class="menu-title">Dashboard</div>
          </a>
        </li> 
        @endcan

        <li>
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon "><span class="material-symbols-outlined">apps</span>
            </div>
            <div class="menu-title">Master</div>
          </a>
        </li>
        @can(['admin.roles.*'])
        <li>
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><span class="material-symbols-outlined">person</span>
            </div>
            <div class="menu-title">Role Management</div>
          </a>
          <ul>
            @can('admin.roles.index')
            {{-- <li> <a href="{{ route("admin.roles.add-role") }}"><span class="material-symbols-outlined">arrow_right</span>Add Role</a>
            </li> --}}
          
            <li> <a href="{{ route("admin.roles.index") }}"><span class="material-symbols-outlined">arrow_right</span>Add Role</a>
            </li>
            {{-- <li> <a href="{{ url("add-permission") }}"><span class="material-symbols-outlined">arrow_right</span>Add Permissions</a>
            </li> --}}
            @endcan
          </ul>
        </li>
        @endcan
        @can(['admin.device.*'])
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon"><span class="material-symbols-outlined">perm_device_information</span>
              </div>
              <div class="menu-title">Device Management</div>
            </a>
            <ul class="mm-collapse">
              @can('admin.device.import')
                <li> <a href="{{ route("admin.device.import") }}"><span class="material-symbols-outlined">arrow_right</span>Import Device List</a>
                </li>
              @endcan
              @can('admin.device.map-device-to-customer')
                <li> <a href="{{ route("admin.device.map-device-to-customer") }}"><span class="material-symbols-outlined">arrow_right</span>Map Device To Customers</a>
                </li>
              @endcan

              
              @can('admin.device.my-device')
                <li> <a href="{{ route("admin.device.my-device") }}"><span class="material-symbols-outlined">arrow_right</span>My Devices</a>
                </li>
              @endcan
            </ul>
          </li>
        @endcan
        @can(['admin.customers.*','admin.locations.add-location',])
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon"><span class="material-symbols-outlined">supervisor_account</span>
              </div>
              <div class="menu-title">Customer Management</div>
            </a>
            <ul class="mm-collapse">
              @can('admin.customers.add-customer')
                <li> <a href="{{ route("admin.customers.add-customer") }}"><span class="material-symbols-outlined">arrow_right</span>Add Customer</a>
                </li>
              @endcan
              @can('admin.customers.add-customer-user')
                <li> <a href="{{ route("admin.customers.add-customer-user") }}"><span class="material-symbols-outlined">arrow_right</span>Add Port User</a>
                </li>
              @endcan
              @can('admin.locations.add-location')
                <li> <a href="{{ route("admin.locations.add-location") }}"><span class="material-symbols-outlined">arrow_right</span>Add Location</a>
                </li>
              @endcan
            </ul>
          </li>
        @endcan
        @can(['admin.trips.*'])
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon"><span class="material-symbols-outlined">local_shipping</span>
              </div>
              <div class="menu-title">Trip Management</div>
            </a>
            <ul class="mm-collapse">
              @can('admin.trips.assign-trip')
              <li> <a href="{{ route("admin.trips.assign-trip") }}"><span class="material-symbols-outlined">arrow_right</span>Assign Trip/Add Trip</a>
              </li>
              @endcan
              @can('admin.trips.ongoing-trips')
              <li> <a href="{{ route("admin.trips.ongoing-trips") }}"><span class="material-symbols-outlined">arrow_right</span>Ongoing Trips</a>
              </li>
              @endcan
              @can('admin.trips.completed-trip')
              <li> <a href="{{ route("admin.trips.completed-trip") }}"><span class="material-symbols-outlined">arrow_right</span>Completed Trip</a>
              </li>
              @endcan

            </ul>
          </li>
        @endcan
        @can(['admin.reports.*'])
        <li>
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><span class="material-symbols-outlined">problem</span>
            </div>
            <div class="menu-title">Reports</div>
          </a>
          <ul class="mm-collapse">

            @can('admin.reports.trip-reports')
            <li> <a href="{{  route("admin.reports.trip-reports") }}"><span class="material-symbols-outlined">arrow_right</span>Trip Reports</a>
            </li>
            @endcan

            @can('admin.reports.route-reports')
            <li> <a href="{{  route("admin.reports.route-reports") }}"><span class="material-symbols-outlined">arrow_right</span>Route Reports</a>
            </li>
            @endcan

            @can('admin.reports.lock-and-unlock-reports')
            <li> <a href="{{ route("admin.reports.lock-and-unlock-reports") }}"><span class="material-symbols-outlined">arrow_right</span>Lock & Unlock Reports</a>
            </li>
            @endcan
            @can('admin.reports.stop-reports')
            <li> <a href="{{ route("admin.reports.stop-reports") }}"><span class="material-symbols-outlined">arrow_right</span>Stop Reports</a>
            </li>
            @endcan
            @can('admin.reports.device-summary-reports')
            <li> <a href="{{ route("admin.reports.device-summary-reports") }}"><span class="material-symbols-outlined">arrow_right</span>Device Summary Reports</a>
            </li>
            @endcan
            @can('admin.reports.replay')
            <li> <a href="{{ route("admin.reports.replay") }}"><span class="material-symbols-outlined">arrow_right</span>Replay</a>
            </li>
            @endcan
            @can('admin.reports.events-reports')
            <li> <a href="{{ route("admin.reports.events-reports") }}"><span class="material-symbols-outlined">arrow_right</span>Events Reports</a>
            </li>
            @endcan
            @can('admin.reports.alarm-reports')
            <li> <a href="{{route("admin.reports.alarm-reports") }}"><span class="material-symbols-outlined">arrow_right</span>Alarm Reports</a>
            </li>
            @endcan

          </ul>
        </li>
        @endcan
    </div>
    <div class="sidebar-bottom dropdown dropup-center dropup">
        <div class="dropdown-toggle d-flex align-items-center px-3 gap-3 w-100 h-100" data-bs-toggle="dropdown">
          <div class="user-img">
            <img alt="image" src="{{ getImage('assets/admin/images/profile/' .auth()->guard('admin')->user()->image) }}">         
          </div>
          <div class="user-info">
            <h5 class="mb-0 user-name">{{ auth()->guard('admin')->user()->username }}</h5>
          </div>
        </div>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><span class="material-symbols-outlined me-2">
            account_circle
            </span><span>Profile</span></a>
          </li>
          <li><a class="dropdown-item" href="{{ route('admin.password') }}"><span class="material-symbols-outlined me-2">
            tune
            </span><span>Password</span></a>
          </li>
          <li><a class="dropdown-item" href="{{ route("admin.dashboard") }}"><span class="material-symbols-outlined me-2">
            dashboard
            </span><span>Dashboard</span></a>
          </li>
          <li>
            <div class="dropdown-divider mb-0"></div>
          </li>
          <li><a class="dropdown-item" href="{{ route('admin.logout') }}"><span class="material-symbols-outlined me-2">
            logout
            </span><span>Logout</span></a>
          </li>
        </ul>
    </div>
    </aside>
<!--end sidebar-->