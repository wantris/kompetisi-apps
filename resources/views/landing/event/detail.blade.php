        
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
        <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{url('assets/img/banner-komp/example.jpeg')}}">
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
                                            <img src="{{url('assets/img/ormawa-logo/himatif.png')}}" class="img-fluid detail-komp__image" alt="Responsive image">
                                        </div>
                                        <div class="col-lg-9 border-bottom">
                                            <h1 class="detail-komp__title mt-4">Design Competition</h1>
                                            <h2 class="detail-komp__category">Digital, seni</h2>
                                            <div class="mt-4">
                                                <p class="detail-komp__const float-left">10/100 Peserta</p>
                                                <p class="detail-komp__verified float-right">Terverifikasi</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-4">
                                            <div class="detail-komp__ormawa text-left">
                                                <h1>Diselenggarakan Oleh</h1>
                                            </div>
                                            <div class="detail-komp__ormawa-desc mt-4 text-left">
                                                <h2><a href="{{route('ormawa.detail.index','HIMATIF')}}" style="text-decoration: none !important">HIMATIF</a></h2>
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
                                                <p>100 Peserta</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="detail-komp__ormawa text-left">
                                                <h1>Jenis Kompetisi</h1>
                                            </div>
                                            <div class="detail-komp__ormawa-type text-left mt-4">
                                                <p>Individu</p>
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
                                        <div class="col-xs-12 ">
                                            <nav>
                                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Deskripsi</a>
                                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Dokumen</a>
                                                    <a class="nav-item nav-link" id="nav-notification-tab" data-toggle="tab" href="#nav-notification" role="tab" aria-controls="nav-notification" aria-selected="false">Pengumuman</a>
                                                    <a class="nav-item nav-link"  href="{{route('event.timeline','Poster-Design-Competition')}}" role="tab" aria-selected="false">Timeline</a>
                                                </div>
                                            </nav>
                                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                    Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.
                                                </div>
                                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                    Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.
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
                    <img src="{{url('assets/img/kompetisi-thumb/thumbnail.jpg')}}" class="img-fluid" alt="Responsive image">
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
                                <h1 class="detail-komp__footer-title">Design Competition</h1>
                                <h2 class="detail-komp__footer-status">Kamu belum mendaftar </h2>
                            </div>
                            <div class="col-6 d-lg-none d-xl-none d-md-none text-left">
                                <p class="text-white font-weight-bold">Design Competition</p>
                            </div>
                            <div class="col-6 d-lg-none d-xl-none d-md-none text-right">
                                <p class="text-white font-weight-bold">HIMATIF</p>
                            </div>
                            <div class="col-lg-4 col-md-12 col-12 text-center mt-2">
                                <a href="{{route('event.registration.team', 'Poster-Design-Competition')}}" class="detail-komp__footer-btn">
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