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
                    <a href="{{ $subItem['route'] }}"
                        class=" {{ $subItem['childHasArrow'] ? 'has-arrow' : '' }} sidebar-link {{ $subItem['isActive'] ? 'active' : '' }}">
                        <span class="hide-menu">{{ $subItem['name'] }}</span>
                    </a>
                    @if ($subItem['childHasArrow'])
                        <ul aria-expanded="false" class="collapse second-level base-level-line">
                            @foreach ($subItem['childSubItems'] as $childSubItem)
                                <li class="sidebar-item">
                                    <a href="{{ $childSubItem['route'] }}"
                                        class="sidebar-link {{ $childSubItem['isActive'] ? 'active' : '' }}">
                                        <span class="hide-menu">{{ $childSubItem['name'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</li>
