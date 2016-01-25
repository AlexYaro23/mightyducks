<div class="breadcrumbs">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('admin.main') }}">
                        {{ trans('backend.home') }}
                    </a>
                </li>
                @if(isset($route) && isset($parent_title))
                    <li>
                        <a href="{{ route($route) }}">{{ $parent_title }}</a>
                    </li>
                @endif
                <li class="active">
                    {{ $title }}
                </li>
            </ol>
        </div>
    </div>
</div>