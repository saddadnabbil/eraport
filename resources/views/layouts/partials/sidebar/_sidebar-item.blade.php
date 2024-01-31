<!-- resources/views/partials/sidebar/_sidebar-items.blade.php -->

<li class="sidebar-item {{ $isActive ? 'selected' : '' }}">
    <a class="sidebar-link {{ $hasArrow ? 'has-arrow' : '' }}" href="{{ $route }}" aria-expanded="false">
        <i data-feather="{{ $icon }}" class="feather-icon"></i>
        <span class="hide-menu">{{ $itemName }}</span>
    </a>
    @if ($hasArrow)
        <ul aria-expanded="false" class="collapse first-level base-level-line {{ $isActive ? 'in' : '' }}">
            @foreach ($subItems as $subItem)
                <li class="sidebar-item {{ $subItem['isActive'] ? 'active' : '' }}">
                    <a href="{{ $subItem['route'] }}" class="sidebar-link {{ $subItem['isActive'] ? 'active' : '' }}">
                        <span class="hide-menu">{{ $subItem['name'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</li>