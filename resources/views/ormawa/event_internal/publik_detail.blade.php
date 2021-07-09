        
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
</style>
    
@endpush


@section('content')
    <!-- Hero Area Start-->
    <div class="slider-area ">
        <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{url('assets/img/banner-komp/'.$ei->banner_image)}}">
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
                                            <img src="{{url('assets/img/ormawa-logo/'.$ei->ormawaRef->photo)}}" class="img-fluid detail-komp__image" alt="Responsive image">
                                        </div>
                                        <div class="col-lg-9 border-bottom">
                                            <h1 class="detail-komp__title mt-4">{{$ei->nama_event}}</h1>
                                            <h2 class="detail-komp__category">{{$ei->kategoriRef->nama_kategori}}</h2>
                                            <div class="mt-4">
                                                <p class="detail-komp__const float-left">0/{{$ei->maks_participant}} Peserta</p>
                                                <p class="detail-komp__verified float-right">Belum Terverifikasi</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-4">
                                            <div class="detail-komp__ormawa text-left">
                                                <h1>Diselenggarakan Oleh</h1>
                                            </div>
                                            <div class="detail-komp__ormawa-desc mt-4 text-left">
                                                <h2><a href="{{route('ormawa.detail.index','HIMATIF')}}" style="text-decoration: none !important">{{$ei->ormawaRef->nama_akronim}}</a></h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="detail-komp__ormawa text-left">
                                                <h1>Tanggal & Batas Peserta</h1>
                                            </div>
                                            <div class="detail-komp__ormawa-date text-secondary mt-4 text-left">
                                                @php
                                                    $tglbuka = Carbon\Carbon::parse($ei->tgl_buka)->toDatetime()->format('d M
                                                    Y');
                                                    $tgltutup = Carbon\Carbon::parse($ei->tgl_tutup)->toDatetime()->format('d M
                                                        Y');
                                                @endphp
                                                
                                                <p>{{$tglbuka}} - {{$tgltutup}}</p>
                                            </div>
                                            <div class="detail-komp__ormawa-const text-left">
                                                <p>{{$ei->maks_participant}} Peserta</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="detail-komp__ormawa text-left">
                                                <h1>Jenis Kompetisi</h1>
                                            </div>
                                            <div class="detail-komp__ormawa-type text-left mt-4">
                                                <p>{{$ei->role}}</p>
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
                                        <div class="col-lg-12 ">
                                            <nav>
                                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Deskripsi & Ketentuan</a>
                                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Dokumen</a>
                                                    <a class="nav-item nav-link" id="nav-notification-tab" data-toggle="tab" href="#nav-notification" role="tab" aria-controls="nav-notification" aria-selected="false">Pengumuman</a>
                                                    <a class="nav-item nav-link"  href="{{route('event.timeline','Poster-Design-Competition')}}" role="tab" aria-selected="false">Timeline</a>
                                                </div>
                                            </nav>
                                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                    <div class="row">
                                                        <div class="col-1">
                                                             <h5 class="text-primary"><i class="icofont-circled-right mr-2"></i></h5>
                                                        </div>
                                                        <div class="col-11">
                                                             <h5 class="text-primary font-weight-bold">Deskripsi</h5>
                                                             {!! $ei->deskripsi !!}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-1">
                                                             <h5 class="text-primary"><i class="icofont-circled-right mr-2"></i></h5>
                                                        </div>
                                                        <div class="col-11">
                                                             <h5 class="text-primary font-weight-bold">Ketentuan</h5>
                                                             {!! $ei->ketentuan !!}
                                                        </div>
                                                    </div>
                                                   
                                                    
                                                </div>
                                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                    @foreach ($feis as $fei)
                                                        <div class="row mt-4">
                                                            <div class="col-lg-1">
                                                                <a href="#" class="float-right btn" style="background-color: #fb8c00;padding: 10px 10px" title="Tambah dokumen">-</a>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" value="{{$fei->nama_file}}" class="inp-dokumen" style="width:100%" id="">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" value="{{$fei->filename}}"  class="inp-dokumen" disabled style="width:100%" id="nama_file_1">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <a href="#" class="float-right btn" style="background-color: #fb8c00;padding: 10px 20px" title="Tambah dokumen"><i class="icofont-download"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="tab-pane fade" id="nav-notification" role="tabpanel" aria-labelledby="nav-notification-tab">
                                                    <div class="container">
                                                        <div class="row">
                                                          <div class="col-12 col-sm-12 col-md-12 col-lg-6 mt-3">
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
                                                                <div class="views">Oct 20, 12:45PM
                                                                </div>
                                                                <div class="stats">
                                                                     <i class="fas fa-eye"></i> 1347
                                                                    <i class="fas fa-comment"></i> 12
                                                                </div>
                                                                 
                                                              </div>
                                                            </div>
                                                          </div>
                                                          <div class="col-12 col-sm-12 col-md-12 col-lg-6 mt-3">
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
                                                                <div class="views">Oct 20, 12:45PM
                                                                </div>
                                                                <div class="stats">
                                                                     <i class="fas fa-eye"></i> 1347
                                                                    <i class="fas fa-comment"></i> 12
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
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="{{url('assets/img/kompetisi-thumb/'.$ei->poster_image)}}" class="img-fluid" alt="Responsive image">
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
                                <h1 class="detail-komp__footer-title">{{$ei->nama_event}}</h1>
                                <h2 class="detail-komp__footer-status">Kamu belum mendaftar </h2>
                            </div>
                            <div class="col-6 d-lg-none d-xl-none d-md-none text-left">
                                <p class="text-white font-weight-bold">{{$ei->nama_event}}</p>
                            </div>
                            <div class="col-6 d-lg-none d-xl-none d-md-none text-right">
                                <p class="text-white font-weight-bold">{{$ei->ormawaRef->nama_akronim}}</p>
                            </div>
                            <div class="col-lg-4 col-md-12 col-12 text-center mt-2">
                                <a href="#" class="detail-komp__footer-btn">
                                    Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
