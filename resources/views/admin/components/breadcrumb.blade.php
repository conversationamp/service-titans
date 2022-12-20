@php
$child = true;
if (empty($title)) {
    $child = false;
    $title = $parent;
}
if(!isset($subchild))
{
    $subchild='';
}
@endphp
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item @if (!$child) active @endif">
                        @if ($child)
                            <a href="{{ route($route . '.list') }}">{{ $parent }}</a>
                            
                        @else
                            {{ $parent }}
                        @endif
                    </li>
                    @if(!empty($subchild))
                              <li class="breadcrumb-item "> <a href="{{ route($route . '.view',$id) }}">{{ $subchild }}</a></li>
                            @endif
                    @if ($child)
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    @endif
                </ol>
            </div>
            <h4 class="page-title">{{ $title }}</h4>
        </div>
        <!--end page-title-box-->
    </div>
    <!--end col-->
</div>
