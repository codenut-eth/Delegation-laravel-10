<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="{{route('admin')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        MAIN CONTENT
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('file-manager')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Media Manager</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-image"></i>
        <span>Banners</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Banner Options:</h6>
          <a class="collapse-item" href="{{route('banner.index')}}">Banners</a>
          <a class="collapse-item" href="{{route('banner.create')}}">Add Banners</a>
        </div>
      </div>
    </li>

    <!-- Ratifications -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ratificationCollapse" aria-expanded="true" aria-controls="ratificationCollapse">
          <i class="fas fa-book"></i>
          <span>Ratification</span>
        </a>
        <div id="ratificationCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Ratification Options:</h6>
            <a class="collapse-item" href="{{route('ratification.index')}}">Ratification</a>
            <a class="collapse-item" href="{{route('ratification.create')}}">Add Ratification</a>
          </div>
        </div>
    </li>
    {{-- Delegations --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#delegationCollapse" aria-expanded="true" aria-controls="delegationCollapse">
          <i class="fas fa-sitemap"></i>
          <span>Delegations</span>
        </a>
        <div id="delegationCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Delegation Options:</h6>
            <a class="collapse-item" href="{{route('delegation.index')}}">Delegations</a>
            <a class="collapse-item" href="{{route('delegation.create')}}">Add Delegation</a>
          </div>
        </div>
    </li>

    {{-- Delegation Types --}}
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#typeCollapse" aria-expanded="true" aria-controls="typeCollapse">
          <i class="fas fa-table"></i>
          <span>Delegation Types</span>
        </a>
        <div id="typeCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Delegation Type Options:</h6>
            <a class="collapse-item" href="{{route('type.index')}}">Delegation Types</a>
            <a class="collapse-item" href="{{route('type.create')}}">Add Delegation</a>
          </div>
        </div>
    </li> -->

    <!-- Members -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#memberCollapse" aria-expanded="true" aria-controls="memberCollapse">
        <i class="fas fa-fw fa-folder"></i>
        <span>Members</span>
      </a>
      <div id="memberCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Member Options:</h6>
          <a class="collapse-item" href="{{route('member.index')}}">Members</a>
          <a class="collapse-item" href="{{route('member.create')}}">Add Member</a>
        </div>
      </div>
    </li>

     <!-- History -->
     <li class="nav-item">
        <a class="nav-link" href="{{route('history')}}">
            <i class="fas fa-history"></i>
            <span>History</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
     <!-- Heading -->
    <div class="sidebar-heading">
        General Settings
    </div>
    
     <!-- Users -->
     <li class="nav-item">
        <a class="nav-link" href="{{route('users.index')}}">
            <i class="fas fa-users"></i>
            <span>Users</span></a>
    </li>
     <!-- General settings -->
     <li class="nav-item">
        <a class="nav-link" href="{{route('settings')}}">
            <i class="fas fa-cog"></i>
            <span>Settings</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>