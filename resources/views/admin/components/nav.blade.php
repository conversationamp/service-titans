<ul class="metismenu left-sidenav-menu slimscroll">

    <li class="leftbar-menu-item">
        <a href="{{ url('/') }}" class="menu-link">
            <i data-feather="pie-chart" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @if (auth()->user()->role == 0)
        @include('admin.components.navs.admin')
    @endif
    @include('admin.components.navs.company')
</ul>
