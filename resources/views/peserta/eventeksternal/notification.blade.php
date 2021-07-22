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
    <div class="row">
        @foreach ($pengumumans as $pn)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                <div class="card card-box">
                    @if ($pn->photo)
                        <img class="card-img-top" src="{{url('assets/img/notif-event/'.$pn->photo)}}" alt="Card image cap">
                    @else
                        <img class="card-img-top" src="{{url('assets/img/kompetisi-thumb/'.$event->poster_image)}}" alt="Card image cap">
                    @endif
                    <div class="card-body">
                        @php
                             $slug = \Str::slug($pn->title);
                        @endphp
                        <h5 class="card-title weight-500">{{$pn->title}}</a></h5>
                        @php
                            $deskripsi = Illuminate\Support\Str::limit($pn->deskripsi, 100, $end='.......');
                        @endphp
                         <div class="text-secondary">
                            {!!$deskripsi!!}
                        </div>
                        <a href="{{route('peserta.eventinternal.notification.detail', $slug)}}" class="btn bg-orange text-white">Lihat</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection