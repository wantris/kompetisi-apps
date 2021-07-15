@extends('peserta.app')

@section('title',$slug)

@section('content')

    <div class="row my-5">
        <div class="col-12 mb-5">
            <h3 class="page-title-submission text-secondary"><span class="page-title-icon-submission mr-2"><i class="icon-copy dw dw-speaker-1 text-white"></i></span>
                Pengumuman
            </h3>
        </div>
    </div>
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