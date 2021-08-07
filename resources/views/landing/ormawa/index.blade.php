@extends('template')

@section('title', 'Contact')

@push('cs-css')

<style>
    .user-profile-picture {
    height: 200px;
    width: 200px;
    background: #fff;
}
.minus-top {
    position: absolute;
    top: -40px;
}
.wrapper-kelas {
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.shadow {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
.rounded {
    border-radius: .25rem!important;
}
@media (max-width: 991.98px){
    .wrapper-kelas-sm {
        height: 180px!important;
        width: 180px!important;
        margin: 0 auto 30px auto;
    }
        .wrapper-kelas-sm.minus-top {
        position: unset;
        margin: -80px auto 0 auto;
    }
}

</style>
    
@endpush


@section('content')
  

  <!-- Hero Area Start-->
  <div class="slider-area ">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" @if($ormawa->banner) data-background="{{url('assets/img/banner-ormawa/'.$ormawa->banner)}}" @else data-background="{{url('assets/img/ormawa-default-banner.png')}}" @endif>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2 class="font-weight-bold">{{$ormawa->nama_ormawa}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero Area End -->

<div class="container" style="margin-bottom: 100px">
    <div class="row">
        <div class="col-lg-2 col-sm-12 col-12 col-md-4 mb-sm-7">
            <div class="px-3 mx-auto py-3 wrapper-kelas rounded shadow minus-top logo-center wrapper-kelas-sm user-profile-picture">
                @if ($ormawa->photo)
                    <img src="{{url('assets/img/ormawa-logo/'.$ormawa->photo)}}" class="img-fluid" alt="{{$ormawa->nama_ormawa}}">
                @else
                    <img src="{{url('assets/img/ormawa-default-logo.png')}}" class="img-fluid rounded-circle" alt="Organisasi Mahasiswa">
                @endif
               
            </div>
        </div>
        <div class="col-lg-9 mx-4 col-sm-7 col-md-8 pt-3 pl-xl-4 pl-lg-5 pl-sm-4">
            <div class="d-flex">
                <h2>{{$ormawa->nama_ormawa}}</h2>
            </div>
            <p>
                <span class="text-icon" title="XP">
                    @php
                        $total_event = $event_internals->count() + $event_eksternals->count();
                    @endphp
                    <i class="fas fa-trophy mr-2"></i>{{$total_event}} Event
                </span>
            </p>
            <p>
                <span class="text-icon">
                    <i class="fas fa-users mr-2"></i>100 peserta keseluruhan
                </span>
            </p>
            <p>
                <span class="text-icon">
                    <i class="far fa-clock mr-2"></i>Bergabung sejak {{$ormawa->created_at->isoFormat('D MMM Y')}}
                </span>
            </p>
        </div>
    </div>
</div>

<div class="container" style="margin-bottom: 200px">
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active text-dark" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="home" aria-selected="true">Tentang Kami</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-dark" id="competition-tab" data-toggle="tab" href="#competition" role="tab" aria-controls="profile" aria-selected="false">Event</a>
                </li>
                {{-- <li class="nav-item">
                  <a class="nav-link text-dark" id="notification-tab" data-toggle="tab" href="#notification" role="tab" aria-controls="contact" aria-selected="false">Pengumuman</a>
                </li> --}}
              </ul>
              <div class="tab-content" id="myTabContent">

                 <!-- Tentang kami -->
                <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="about-tab">
                    <div class="container-fluid mt-4">
                        <div class="col-12" >
                            {!!$ormawa->deskripsi!!}
                        </div>
                    </div>
                </div>

                 <!-- Event -->
                <div class="tab-pane fade" id="competition" role="tabpanel" aria-labelledby="competition-tab">
                    <div class="container-fluid mt-4">
                        <div class="col-12 col-lg-3 text-left" style="padding-left: 0px !important;">
                            <select class="form-control" style="margin-left: 0px!important;box-shadow: 0 2px 4px 0 #dedede;">
                                <option>Semua Event</option>
                              </select>
                        </div>
                    </div>
                    <div class="row mt-5">
                        @foreach ($event_internals as $event)
                        <div class="col-lg-3 col-md-6 col-12 mb-3">
                            <div class="komp-card2 mx-auto">
                                <div class="komp-thumbnail" data-background="{{asset('assets/img/kompetisi-thumb/'.$event->poster_image)}}">
                                </div>
                                <div class="komp-banner">
                                    <div class="komp-banner__date text-left pl-2 pt-1" >  
                                        @php
                                            $tgl_buka = Carbon\Carbon::parse($event->tgl_buka)->toDatetime()->format('M, d Y');
                                        @endphp
                                        {{$tgl_buka}}
                                    </div>
                                    <div class="komp-banner__date text-right pr-2 pt-1" data-toggle="tooltip" data-placement="top" title="{{$event->ormawaRef->nama_ormawa}}">
                                        @php
                                            $count = str_word_count($event->ormawaRef->nama_ormawa);
                                            $nama_ormawa = $event->ormawaRef->nama_ormawa;
                                            if($count > 3){
                                                $nama_ormawa = $event->ormawaRef->nama_akronim;
                                            }
                                        @endphp
                                        {{$nama_ormawa}}
                                    </div>
                                </div>
                                <div class="komp-title pl-3">
                                    <a href="{{route('event.detail', $event->slug)}}"><h1 class="mt-3">
                                        {{$event->nama_event}} 
                                    </h1></a>
                                </div>
                                <div class="komp-description pl-3 pr-3">
                                    {!!$event->deskripsi_excerpt!!}
                                </div>
                                <div class="komp-created pl-3 pr-3">
                                    <i class="far fa-clock text-secondary mr-1 d-inline"></i>
                                    <p class="text-secondary d-inline">
                                        {{$event->created_at->isoFormat('MMM, d Y')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pengumuman -->
                <div class="tab-pane fade" id="notification" role="tabpanel" aria-labelledby="notification-tab">
                    <div class="row mt-4">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3 border mt-3">
                            <div class="card">
                              <img class="card-img" src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/pasta.jpg" alt="Bologna">
                              <div class="card-img-overlay">
                                <a href="#" class="btn btn-light btn-sm" style="padding: 20px 20px">Pemenang</a>
                              </div>
                              <div class="card-body">
                                <h4 class="card-title">Pengumuman Pemenang</h4>
                                <small class="text-muted cat">
                                  <i class="far fa-clock text-info"></i> 1 jam lalu
                                </small>
                                <p class="card-text">Pemenang lomba Design Competition telah diumumkan....</p>
                                <a href="#" class="btn btn-info" style="padding: 20px 20px">Baca lebih lanjut</a>
                              </div>
                              <div class="card-footer text-muted d-flex justify-content-between bg-transparent border-top-0">
                                <div class="views">
                                    <small class="text-muted cat">
                                        Oct 20, 12:45PM
                                    </small>
                                </div>
                                <div class="stats">
                                    <small class="text-muted cat">
                                        <i class="fas fa-eye"></i> 1347
                                    </small>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection