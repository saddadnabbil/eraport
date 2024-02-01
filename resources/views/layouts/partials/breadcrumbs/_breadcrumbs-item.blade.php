<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $titleBreadCrumb }}</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="customize-input float-end">
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            @if(isset($breadcrumbs))
                                @foreach($breadcrumbs as $breadcrumb)
                                    @if(isset($breadcrumb['title']) && isset($breadcrumb['url']))
                                        <li class="breadcrumb-item {{ $breadcrumb['active'] == true ? 'active' : 'text-muted' }}">
                                            @if ($breadcrumb['active'] == true)
                                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                            @else
                                                {{ $breadcrumb['title'] }}
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
