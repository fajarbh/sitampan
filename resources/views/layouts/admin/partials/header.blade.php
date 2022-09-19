<style>
  @media screen and (max-width: 575px) {
    .page-wrapper .page-main-header .main-header-right .main-header-left .toggle-sidebar {
        margin-left: 0;
    }
  }

  @media screen and (max-width: 991px) {
    .page-wrapper .page-main-header .left-menu-header {
      padding-top: 5px;
      padding-bottom: 5px;
      flex-basis: 40%;
    }
  }
</style>
<div class="page-main-header">
  <div class="main-header-right row m-0">
    <div class="main-header-left">
      <div class="d-md-block d-none logo-wrapper" style="margin-right:20px"><a href="#"><img class="img-fluid" src="{{asset('assets/images/logo/logo-22.png')}}" alt=""></a></div>
      <div class="dark-logo-wrapper" ><a href="#"><img class="img-fluid" src="{{asset('assets/images/logo/dark-logo.png')}}" alt=""></a></div>
      <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle">    </i></div>
    </div>
    <div class="left-menu-header col">
      <div class="d-md-none d-block logo-wrapper" style="margin-right:20px"><a href="#"><img class="img-fluid" src="{{asset('assets/images/logo/dark-logo.png')}}" alt=""></a></div>
    </div>
    <div class="nav-right col pull-right right-menu p-0">
      <ul class="nav-menus">
        <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
  
        <li class="onhover-dropdown p-0">
          <button class="btn btn-primary-light" type="button" onclick="logout()"><i data-feather="log-out"></i>Log out</button>
        </li>
      </ul>
    </div>
    <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
  </div>
</div>
