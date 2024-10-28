
<!--start header-->
<header class="top-header">
  <nav class="navbar navbar-expand justify-content-between">
    <div class="btn-toggle-menu">
      <span class="material-symbols-outlined">menu</span>
    </div>
    <ul class="navbar-nav top-right-menu gap-2">
      <li class="nav-item dropdown dropdown-large">
        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
          <div class="position-relative">
            <span class="material-symbols-outlined">
              notifications_none
              </span>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end mt-lg-2">
          <a href="javascript:;">
            <div class="msg-header">
              <p class="msg-header-title">Notifications</p>
              <p class="msg-header-clear ms-auto">Marks all as read</p>
            </div>
          </a>
          <div class="header-notifications-list">
            <div class="table-responsive white-space-nowrap">
              @csrf
              <table id="event_notify" class="table text-center" >
                  <thead>
                      <tr>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
              </table>
          </div>
          </div>
          <a href="{{ route('admin.notification.view-all-notification') }}">
            <div class="text-center msg-footer">View All</div>
          </a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="offcanvas" href="#ThemeCustomizer"><span class="material-symbols-outlined">
         settings
         </span></a>
      </li>
    </ul> 
  </nav>
</header>
<!--end header-->
