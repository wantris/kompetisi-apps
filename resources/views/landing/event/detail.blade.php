        
@extends('template')

@section('title', $slug)

@push('cs-css')
<style>
    /* Tabs*/

.section-title {
    text-align: center;
    color: #007b5e;
    margin-bottom: 50px;
    text-transform: uppercase;
}
#tabs{
	margin-top: 100px;
}
#tabs h6.section-title{
    color: #000000;
}

#tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #007AFF !important;
    background-color: transparent;
    border-color: #007AFF;
    border-bottom: 4px solid #007AFF!important;
    font-size: 20px;
    font-weight: bold;
}
#tabs .nav-tabs .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    color: #000000;
    font-size: 20px;
}

.poster-modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 99999; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.poster-modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.poster-modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .poster-modal-content {
    width: 100%;
  }
}

.buttonDownload,
.buttonDownload:link,
.buttonDownload:visited {
  border: none;
  outline: none;
  color: #fefefe;
  background-color: #fb8c00;
  border-radius: 3px;
  padding: 5px 10px;
}
.buttonDownload:hover, .buttonDownload:focus,
.buttonDownload:link:hover,
.buttonDownload:link:focus,
.buttonDownload:visited:hover,
.buttonDownload:visited:focus {
  transition-timing-function: cubic-bezier(0.6, 4, 0.3, 0.8);
  -webkit-animation: gelatine 0.5s 1;
          animation: gelatine 0.5s 1;
}

@-webkit-keyframes gelatine {
  from, to {
    -webkit-transform: scale(1, 1);
  }
  25% {
    -webkit-transform: scale(0.9, 1.1);
  }
  50% {
    -webkit-transform: scale(1.1, 0.9);
  }
  75% {
    -webkit-transform: scale(0.95, 1.05);
  }
  from, to {
    -webkit-transform: scale(1, 1);
  }
  25% {
    -webkit-transform: scale(0.9, 1.1);
  }
  50% {
    -webkit-transform: scale(1.1, 0.9);
  }
  75% {
    -webkit-transform: scale(0.95, 1.05);
  }
}
@keyframes gelatine {
  from, to {
    transform: scale(1, 1);
  }
  25% {
    transform: scale(0.9, 1.1);
  }
  50% {
    transform: scale(1.1, 0.9);
  }
  75% {
    transform: scale(0.95, 1.05);
  }
  from, to {
    transform: scale(1, 1);
  }
  25% {
    transform: scale(0.9, 1.1);
  }
  50% {
    transform: scale(1.1, 0.9);
  }
  75% {
    transform: scale(0.95, 1.05);
  }
}


</style>
    
@endpush


@section('content')
    <!-- Hero Area Start-->
    <div class="slider-area ">
        <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{url('assets/img/banner-komp/'.$event->banner_image)}}">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>Ikuti Kompetisi yang Kamu Inginkan</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End -->
    

    <div class="main-detail__sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-detil__komp">
                                <div class="card-body px-5">
                                    <div class="row">
                                        <div class="col-lg-3 px-3 py-3 border-bottom text-center">
                                            <img src="{{url('assets/img/ormawa-logo/'.$event->ormawaRef->photo)}}" class="img-fluid detail-komp__image" alt="Responsive image">
                                        </div>
                                        <div class="col-lg-9 border-bottom">
                                            <h1 class="detail-komp__title mt-4">{{$event->nama_event}}</h1>
                                            <h2 class="detail-komp__category">{{$event->kategoriRef->nama_kategori}}</h2>
                                            <div class="mt-4">
                                                <p class="detail-komp__const float-left">10/{{$event->maks_participant}} Peserta</p>
                                                <p class="detail-komp__verified float-right">
                                                    @if ($event->status_validasi == "1")
                                                        Terverifikasi
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-4">
                                            <div class="detail-komp__ormawa text-left">
                                                <h1>Diselenggarakan Oleh</h1>
                                            </div>
                                            <div class="detail-komp__ormawa-desc mt-4 text-left">
                                                <h2><a href="{{route('ormawa.detail.index','HIMATIF')}}" style="text-decoration: none !important">{{$event->ormawaRef->nama_ormawa}}</a></h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="detail-komp__ormawa text-left">
                                                <h1>Tanggal & Batas Peserta</h1>
                                            </div>
                                            <div class="detail-komp__ormawa-date text-secondary mt-4 text-left">
                                                <p>10 May 2021 - 12 May 2021</p>
                                            </div>
                                            <div class="detail-komp__ormawa-const text-left">
                                                <p>{{$event->maks_participant}} Peserta</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="detail-komp__ormawa text-left">
                                                <h1>Jenis Kompetisi</h1>
                                            </div>
                                            <div class="detail-komp__ormawa-type text-left mt-4">
                                                <p>{{$event->role}}</p>
                                            </div>
                                            <div class="detail-komp__ormawa-peserta text-left mt-4">
                                                <p>{{$event->tipePesertaRef->nama_tipe}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabs Kompetisi -->
                    <div class="row">
                        <div class="col-12">
                            <section id="tabs">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-12 col-lg-12">
                                            @php
                                                 $slug = \Str::slug($event->nama_event);
                                            @endphp
                                            <nav>
                                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-deskripsi" role="tab" aria-controls="nav-home" aria-selected="true">Deskripsi</a>
                                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-ketentuan" role="tab" aria-controls="nav-profile" aria-selected="false">Dokumen</a>
                                                    <a class="nav-item nav-link" id="nav-notification-tab" data-toggle="tab" href="#nav-notification" role="tab" aria-controls="nav-notification" aria-selected="false">Pengumuman</a>
                                                    <a class="nav-item nav-link"  href="{{route('event.timeline',$slug)}}" role="tab" aria-selected="false">Timeline</a>
                                                </div>
                                            </nav>
                                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="nav-deskripsi" role="tabpanel" aria-labelledby="nav-home-tab">
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <p class="font-weight-bold"><i class="icofont-plus-circle mr-2" style="color:#0079ff"></i>Deskripsi</p>
                                                        </div>
                                                        <div class="col-12 mt-1 pl-4">
                                                            {!!$event->deskripsi!!}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <p class="font-weight-bold"><i class="icofont-plus-circle mr-2" style="color:#0079ff"></i>Ketentuan</p>
                                                        </div>
                                                        <div class="col-12 mt-1 pl-4">
                                                            {!!$event->Ketentuan!!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="nav-ketentuan" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                    @foreach ($feis as $fei)
                                                        <div class="row mt-4">
                                                            <div class="col-lg-1">
                                                                <a href="#" class="float-right buttonDownload" >-</a>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <input type="text" value="{{$fei->nama_file}}" disabled  class="pb-2 inp-dokumen"
                                                                    style="width:100%" id="">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <a href="#" class="float-right buttonDownload" 
                                                                    title="Tambah dokumen"><i class="icofont-download"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="tab-pane fade" id="nav-notification" role="tabpanel" aria-labelledby="nav-notification-tab">
                                                    <div class="container">
                                                        <div class="row">
                                                            @foreach ($pns as $pn)
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 mt-3">
                                                                <div class="card shadow-sm">
                                                                    @if ($pn->photo)
                                                                        <img class="card-img" src="{{asset('assets/img/notif-event/'.$pn->photo)}}" style="max-width: 355px; max-height:268px" alt="Bologna">
                                                                    @else
                                                                        <img class="card-img" src="{{asset('assets/img/kompetisi-thumb/'. $pn->eventInternalRef->poster_image)}}" style="max-width: 355px; max-height:268px" alt="Bologna">
                                                                    @endif
                                                                    {{-- <div class="card-img-overlay">
                                                                        <a href="#" class="btn btn-light btn-sm" style="padding: 20px 20px">Pemenang</a>
                                                                    </div> --}}
                                                                    <div class="card-body">
                                                                        <h4 class="card-title">{{$pn->title}}</h4>
                                                                        <small class="text-muted cat">
                                                                            <i class="far fa-clock text-info"></i> {{$pn->created_at->diffForHumans()}}
                                                                        </small>
                                                                        <p class="card-text" style="font-size: 13px !important">{!!$pn->deskripsi_excerpt!!}</p>
                                                                    </div>
                                                                    <div class="card-footer text-muted d-flex justify-content-between bg-transparent border-top-0">
                                                                        <div class="views">{{$pn->created_at->isoFormat('MMM, D Y')}}
                                                                        </div>
                                                                        <div class="stats">
                                                                            <i class="fas fa-eye"></i> 1347
                                                                            <i class="fas fa-comment"></i> 12
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 ">
                    <div class="card shadow" id="poster-card" style="border-radius: 20px;">
                        <div class="card-body">
                            <img src="{{url('assets/img/kompetisi-thumb/'.$event->poster_image)}}" id="poster-image" alt="{{$event->nama_event}}" class="img-fluid" alt="Responsive image">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 ">
                <div class="col-12">
                    <div class="detail-komp__footer ">
                        <div class="row">
                            <div class="col-lg-1 col-md-2 text-right col-6 pt-2 d-none d-md-block d-lg-block">
                                <img src="{{url('assets/img/adapt_icon/medal.svg')}}" class="medal-icon" alt="">
                            </div>
                            <div class="col-lg-7 col-md-6 col-6 d-none d-md-block d-lg-block">
                                <h1 class="detail-komp__footer-title">{{$event->nama_event}}</h1>
                                <h2 class="detail-komp__footer-status">
                                    @if (Session::get('id_pengguna') != null)
                                        @if($check_regis != null)
                                            Anda sudah terdaftar
                                        @else
                                            Anda belum mendaftar
                                        @endif
                                    @else
                                        Anda belum mendaftar
                                    @endif
                                </h2>
                            </div>
                            <div class="col-6 d-lg-none d-xl-none d-md-none text-left">
                                <p class="text-white font-weight-bold">{{$event->nama_event}}</p>
                            </div>
                            <div class="col-6 d-lg-none d-xl-none d-md-none text-right">
                                <p class="text-white font-weight-bold">{{$event->nama_akronim}}</p>
                            </div>
                            {{-- Jika sudah login --}}
                            @if (Session::get('id_pengguna') != null)
                                @if($check_regis != null)
                                    <div class="col-lg-4 col-md-12 col-12 d-none d-md-none d-lg-block text-center" style="margin-top: 40px">
                                        <a href="#" class="detail-komp__footer-btn">
                                            Sudah Terdaftar
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-12 d-lg-none d-xl-none d-md-block text-center" style="margin-top: 20px">
                                        <a href="#" style="display:inline-block;
                                        width: 100%;" class="detail-komp__footer-btn">
                                            Sudah Terdaftar
                                        </a>
                                    </div>
                                @else
                                    @php
                                        $slug = \Str::slug($event->nama_event);
                                    @endphp
                                    
                                    @if ($event->tipe_peserta_id == "2" && Session::get('is_mahasiswa') == "1")
                                        <div class="col-lg-4 col-md-12 col-12 d-none d-md-none d-lg-block text-center" style="margin-top: 40px">
                                            <a href="{{route('event.registration.get', $slug)}}" class="detail-komp__footer-btn">
                                                Daftar
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-12 d-lg-none d-xl-none d-md-block text-center" style="margin-top: 20px">
                                            <a href="{{route('event.registration.get', $slug)}}" style="display:inline-block;
                                            width: 100%;" class="detail-komp__footer-btn">
                                                Daftar
                                            </a>
                                        </div>
                                    @elseif($event->tipe_peserta_id == "3" && Session::get('is_mahasiswa') == "0")
                                        <div class="col-lg-4 col-md-12 col-12 d-none d-md-none d-lg-block text-center" style="margin-top: 40px">
                                            <a href="{{route('event.registration.get', $slug)}}" class="detail-komp__footer-btn">
                                                Daftar
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-12 d-lg-none d-xl-none d-md-block text-center" style="margin-top: 20px">
                                            <a href="{{route('event.registration.get', $slug)}}" style="display:inline-block;
                                            width: 100%;" class="detail-komp__footer-btn">
                                                Daftar
                                            </a>
                                        </div>
                                    @elseif($event->tipe_peserta_id == "1" && Session::get('is_mahasiswa') == "0" || $event->tipe_peserta_id == "1" && Session::get('is_mahasiswa') == "1")
                                        <div class="col-lg-4 col-md-12 col-12 d-none d-md-none d-lg-block text-center" style="margin-top: 40px">
                                            <a href="{{route('event.registration.get', $slug)}}" class="detail-komp__footer-btn">
                                                Daftar
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-12 d-lg-none d-xl-none d-md-block text-center" style="margin-top: 20px">
                                            <a href="{{route('event.registration.get', $slug)}}" style="display:inline-block;
                                            width: 100%;" class="detail-komp__footer-btn">
                                                Daftar
                                            </a>
                                        </div>
                                    @else
                                        @php
                                            $roleMessage = "Maaf event hanya untuk ".$event->tipePesertaRef->nama_tipe;
                                        @endphp
                                        <div class="col-lg-4 col-md-12 col-12 d-none d-md-none d-lg-block text-center" style="margin-top: 40px">
                                            <a href="#" onclick="failureAlert('{{$roleMessage}}')" class="detail-komp__footer-btn">
                                                Daftar
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-12 d-lg-none d-xl-none d-md-block text-center" style="margin-top: 20px">
                                            <a href="#" onclick="failureAlert('{{$roleMessage}}')" style="display:inline-block;
                                            width: 100%;" class="detail-komp__footer-btn">
                                                Daftar
                                            </a>
                                        </div>
                                    @endif
                                @endif
                               
                            {{-- Jika belum login --}}
                            @else
                                @php
                                    $message = "Anda harus login";
                                @endphp
                                <div class="col-lg-4 col-md-12 col-12 d-none d-md-none d-lg-block text-center" style="margin-top: 40px">
                                    <a href="#" onclick="failureAlert('{{$message}}')" class="detail-komp__footer-btn">
                                        Daftar
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-12 col-12 d-lg-none d-xl-none d-md-block text-center" style="margin-top: 20px">
                                    <a href="#" onclick="failureAlert('{{$message}}')" style="display:inline-block;
                                    width: 100%;" class="detail-komp__footer-btn">
                                        Daftar
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="poster-modal">
        <span class="close">&times;</span>
        <img class="poster-modal-content" id="img01">
        <div id="caption"></div>
    </div>
@endsection

@push('cs-script')
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("poster-image");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
        modal.style.display = "none";
        }
    </script>
@endpush
