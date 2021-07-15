@extends('peserta.app')

@section('title','Timeline')

@section('content')
<div class="container my-5 pd-0">
    <div class="row my-5">
        <div class="col-12 mb-5">
            <h3 class="page-title-submission text-secondary"><span class="page-title-icon-submission mr-2"><i class="icon-copy dw dw-speaker-1 text-white"></i></span>
                Timeline Kompetisi
            </h3>
        </div>
    </div>
    <div class="timeline mb-30">
        <ul>
            @foreach ($tls as $tl)
            <li>
                <div class="timeline-date">
                    @php
                        $tgljadwal = Carbon\Carbon::parse($tl->tgl_jadwal)->toDatetime()->format('d M Y');
                    @endphp
                    {{$tgljadwal}}
                </div>
                <div class="timeline-desc card-box">
                    <div class="pd-20">
                        <h4 class="mb-10 h4">{{$tl->title}}</h4>
                        {!!$tl->deskripsi!!}
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
</div>
@endsection