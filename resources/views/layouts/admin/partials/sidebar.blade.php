<style>
    .page-wrapper.compact-wrapper .page-body-wrapper header.main-nav {
        z-index: 1000;
    }

</style>
<header class="main-nav">
    <nav>
        <div class="main-navbar">
            <div id="mainnav">
                <div class="sidebar-user text-center"><img class="img-90 rounded-circle"
                        src="{{ asset('assets/images/dashboard/1.png') }}" alt="">
                    <h6 class="mt-3 f-14 f-w-600">{{ Auth::user()->no_hp }}</h6></a>
                    <p class="mb-0 font-roboto">{{ \App\Helpers\Helper::roleName(Auth::user()->level) }}</p>
                </div>
                <ul class="nav-menu custom-scrollbar mt-3">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    @foreach (\App\Helpers\Menu::generateUserMenu(Auth::user()->level) as $menu)
                    @if (isset($menu['submenus']))
                    <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i
                                data-feather="{{ $menu['icon'] }}"></i><span>{{ $menu['title'] }}</span></a>
                        <ul class="nav-submenu menu-content">
                            @foreach ($menu['submenus'] as $submenu)
                            <li><a href="{{ url($submenu['slug']) }}">{{ $submenu['title'] }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @else
                    <li>
                        <a class="nav-link" href="{{ url($menu['slug']) }}"><i
                                data-feather="{{ $menu['icon'] }}"></i><span>{{ $menu['title'] }}</span></a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</header>
