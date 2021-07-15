@extends('ormawa.app')

@section('title','Timeline Event')

@push('css')
<style>
    .nav-link:hover {
        color: #f5a461 !important;
    }
    .dataTables_paginate {margin-top: 20px !important;}
    .dataTables_length, #timeline-table_filter{margin-bottom: 20px !important;}
</style>
@endpush

@section('content')


<div class="blog-wrap">
    <div class="container pd-0">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="blog-detail card-box overflow-hidden mb-30">
                    <div class="blog-img">
                        @if ($pn->photo)
                            <img src="{{asset('assets/img/notif-event/'. $pn->photo)}}" alt="">
                        @else
                            <img src="{{asset('assets/img/banner-komp/'. $pn->eventInternalRef->banner_image)}}" alt="">
                        @endif
                    </div>
                    <div class="blog-caption">
                        <h4 class="mb-10">{{$pn->title}}</h4>
                        {!!$pn->deskripsi!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')


@endpush