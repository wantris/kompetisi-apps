@extends('peserta.app')

@section('title','Tim')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-2">
            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active  pb-2" data-toggle="tab" href="#internal" role="tab" aria-selected="true">Event Internal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pb-2" data-toggle="tab" href="#eksternal" role="tab" aria-selected="false">Event Eksternal</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="internal" role="tabpanel">
                    <div class="pd-20">
                        <div class="product-wrap">
                            <div class="product-list">
                                <ul class="row">
                                    @foreach ($tims as $tim)
                                        @if ($tim->eventInternalRegisRef)
                                            <li class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="product-box">
                                                    <div class="producct-img"><img src="{{url('assets/img/kompetisi-thumb/'.$tim->eventInternalRegisRef->eventInternalRef->poster_image)}}" alt=""></div>
                                                    <div class="product-caption">
                                                        <h4><a href="#">{{$tim->eventInternalRegisRef->eventInternalRef->nama_event}}</a></h4>
                                                        <small class="text-muted">Oleh: <a href="#" class="text-orange" target="_blank" rel="noopener noreferrer">
                                                            {{$tim->eventInternalRegisRef->eventInternalRef->ormawaRef->nama_ormawa}}
                                                        </a></small>
                                                        <div class="mb-3">
                                                            <small class="text-muted">{{$tim->timDetailRef->count()}} Anggota</small>
                                                        </div>
                                                        <span class="my-3 d-block" style="font-size: 12px">Terdaftar: {{$tim->eventInternalRegisRef->created_at->isoFormat('D MMM Y')}}</span>
                                                        <a href="{{route('peserta.team.detail', $tim->id_tim_event)}}" class="btn bg-orange text-white" style="padding: 5px 20px">Lihat</a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="eksternal" role="tabpanel">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection