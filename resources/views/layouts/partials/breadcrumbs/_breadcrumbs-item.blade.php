<div class="page-breadcrumb"
    style="background: linear-gradient(to right,#8971ea,#7f72ea,#7574ea,#6a75e9,#5f76e8); padding-bottom: 90px; padding-top: 40px; margin-bottom: -90px">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title text-truncate font-weight-medium mb-1 text-light">{{ $titleBreadCrumb }}</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="customize-input float-end">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            @if (isset($breadcrumbs))
                                @foreach ($breadcrumbs as $breadcrumb)
                                    @if (isset($breadcrumb['title']) && isset($breadcrumb['url']))
                                        <li
                                            class="breadcrumb-item {{ $breadcrumb['active'] == true ? 'active' : 'text-muted' }}">
                                            @if ($breadcrumb['active'] == true)
                                                <a class="text-light"
                                                    href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                            @else
                                                <span class="text-light">{{ $breadcrumb['title'] }}</span>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
