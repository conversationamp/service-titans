
<li class="has-submenu leftbar-menu-item">
    <a href="#" class="menu-link">
        <i data-feather="settings" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
        <span> Settings </span>
    </a>
    <ul class="submenu childnav">
        <li><a href="{{ route('setting.general') }}"> General Settings </a></li>
        @if(auth()->user()->role == 1)
            <li><a href="{{ route('setting.titan') }}"> Service Titans Settings </a></li>
        @endif
        <li><a href="{{ route('setting.index') }}"> Auth Settings </a></li>
        @if(auth()->user()->role == 1)
        <li><a href="{{ route('sync-settings.list') }}"> Sync Settings </a></li>
        @endif
    </ul>
</li>

@if (auth()->user()->role == 1)
    <li class="leftbar-menu-item">
        <a href="{{ route('sync-settings.get-default') }}" class="menu-link">
            <i data-feather="users" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
            <span> Make Default Setting </span>
        </a>
    </li>


    <li class="has-submenu leftbar-menu-item">
        <a href="#" class="menu-link">
            <i data-feather="settings" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
            <span> Logs </span>
        </a>
        <ul class="submenu childnav">
            <li><a href="{{ route('log.contact') }}"> Contacts </a></li>
            <li><a href="{{ route('log.opportunity') }}"> Opportunities </a></li>
        </ul>
    </li>
@endif
