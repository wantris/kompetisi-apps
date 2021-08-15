       
    @extends('template')

    @section('title', 'Beranda')

    @push('cs-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .komp-faq{
            margin-top: 40px;
            margin-bottom: 100px;
        }
        .accordion{
            max-width: 765px;
            margin: auto;
        }

        .accordion .card{
            border: none;
        }

        .accordion .card .card-header{
            background: #fff;
            border: none;
            border-bottom: 1px solid #d8d8d8;
            padding-bottom:25px;
        }
        .card-header:before{
            font-family: 'FontAwesome';  
            content: "\f192";
            color:#007AFF;
            margin-right: 20px;
        }

        .accordion .card-header:after {
            font-family: 'FontAwesome';  
            content: "\f068";
            float: right; 
            background: #F6FBFF;
            width: 30px;
            height: 30px;
            font-size: 20px;
            color:#007AFF;
            text-align: center;
            border-radius: 50%;
        }
        .accordion .card-header.collapsed:after {
            /* symbol for "collapsed" panels */
            content: "\f067"; 
        }

        .card-header a{
            font-family: "Nunito Sans";
            font-size: 18px;
            font-weight: bold;
            color: #3A4166 !important;
            text-decoration: none !important;
        }
        .slider-hero{
            filter: brightness(50%)
        }
    </style>
        
    @endpush

    @section('content')
       <!-- slider Area Start-->
        <div class="slider-area ">
            <!-- Mobile Menu -->
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($sliders as $key => $slider)
                        @if ($key == 0)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" class="active"></li>
                        @else
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" ></li>
                        @endif
                        
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach ($sliders as $key => $slider)
                        <div class="carousel-item @if($key == 0) active @endif">
                            <img class="d-block img-fluid slider-hero"  src="{{$slider->image_url}}"  alt="First slide">
                            <div class="carousel-caption">
                                <h1>{{$slider->title}}</h1>
                                <p>{{$slider->deskripsi}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
              </div>
        </div>
        <!-- slider Area End-->

        <!-- About Us-->
        <div class="about-us">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle text-center">
                            <h2>Tentang Kami</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <img src="{{url('assets/img/service/komp.jpg')}}" class="img-fluid" alt="Responsive image">
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 pr-5">
                        <div class="section-tittle text-left">
                            <h1>SIEVENT</h1>
                        </div>
                        <div class="section-desc">
                            <p>
                                Sievent adalah portal bagi Unit Kegiatan Mahasiswa (UKM) dan Bidang Kemahasiswaan Politeknik Negeri Indramayu dalam memperkenalkan event ke khalayak umum. Sievent memberikan kemudahan bagi calon partisipan dalam mendaftar event yang telah tersedia. 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End About Us-->

        <!-- Ormawa -->
        <div class="ormawa-sec">
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle text-center" >
                            <h2 style="margin-bottom: 30px !important">Organisasi Mahasiswa</h2>
                        </div>
                    </div>
                </div>
                <div class="row pb-3">
                    @foreach ($ormawas as $ormawa)
                        <div class="col-lg-2 col-md-3 col-6 mt-5" data-toggle="tooltip" data-placement="top" title="{{$ormawa->nama_ormawa}}">
                            <div class="card-ormawa mx-auto">
                                @if ($ormawa->photo)
                                    <img src="{{url('assets/img/ormawa-logo/'.$ormawa->photo)}}" class="img-fluid" alt="Responsive image">
                                @else
                                    <img src="{{url('assets/img/ormawa-default-logo.png')}}" class="img-fluid rounded-circle" alt="Responsive image">
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- End Ormawa -->

        <!-- Our Services Start -->
        {{-- <div class="our-services section-pad-t30">
            <div class="container">
                <!-- Section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle text-center">
                            <h2>Eksplorasi Kategori Event</h2>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-contnet-center">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span><i class="icofont-addons"></i></span>
                            </div>
                            <div class="services-cap">
                               <h5><a href="job_listing.html">Design & Creative</a></h5>
                                <span>(653)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-cms"><i class="icofont-address-book"></i></span>
                            </div>
                            <div class="services-cap">
                               <h5><a href="job_listing.html">Design & Development</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-report"></span>
                            </div>
                            <div class="services-cap">
                               <h5><a href="job_listing.html">Sales & Marketing</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-app"></span>
                            </div>
                            <div class="services-cap">
                               <h5><a href="job_listing.html">Mobile Application</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-helmet"></span>
                            </div>
                            <div class="services-cap">
                               <h5><a href="job_listing.html">Construction</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-high-tech"></span>
                            </div>
                            <div class="services-cap">
                               <h5><a href="job_listing.html">Information Technology</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-real-estate"></span>
                            </div>
                            <div class="services-cap">
                               <h5><a href="job_listing.html">Real Estate</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-content"></span>
                            </div>
                            <div class="services-cap">
                               <h5><a href="job_listing.html">Content Writer</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- More Btn -->
                <!-- Section Button -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="browse-btn2 text-center mt-50">
                            <a href="job_listing.html" class="border-btn2">Semua Kategori</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Our Services End -->

        <!-- Online CV Area Start -->
         <div class="online-cv cv-bg section-overly pt-90 pb-120"  data-background="assets/img/banner/polindra-building.jpg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="cv-caption text-center">
                            <p class="pera2">Ayoo Ikut Event Sekarang!</p>
                            <a href="#" class="border-btn3">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Online CV Area End-->

        <!-- Featured_job_start -->
        <section class="featured-job-area feature-padding">
            <div class="container">
                <!-- Section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle text-center">
                            <h2>Event Terbaru</h2>
                        </div>
                    </div>
                </div>
                <div class="row" id="komp-container">
                    @foreach ($events as $event)
                        <div class="col-lg-6 col-md-6 mt-4">
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
                                    <a href="#"><h1 class="mt-3">
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
        </section>
        <!-- Featured_job_end -->

        <!-- Testimonial Start -->
        <div class="testimonial-area testimonial-padding">
            <div class="container">
                <!-- Testimonial contents -->
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-8 col-lg-8 col-md-10">
                        <div class="h1-testimonial-active dot-style">
                            @foreach ($testimonis as $testimoni)
                                  <!-- Single Testimonial -->
                                <div class="single-testimonial text-center">
                                    <!-- Testimonial Content -->
                                    <div class="testimonial-caption ">
                                        <!-- founder -->
                                        <div class="testimonial-founder  ">
                                            <div class="founder-img mb-30">
                                                <img src="{{asset('assets/img/testimonial/'.$testimoni->photo)}}" alt="">
                                                <span>{{$testimoni->name}}</span>
                                                <p>{{$testimoni->role}}</p>
                                            </div>
                                        </div>
                                        <div class="testimonial-top-cap">
                                            <p>“{{$testimoni->description}}”</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->

        <!-- Question    -->
        <div class="komp-faq">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle text-center">
                            <h2>Pertanyaan yang Sering Diajukan</h2>
                        </div>
                    </div>
                </div>
                <div id="accordion" class="accordion">
                    <div class="card mb-0">
                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
                            <a class="card-title">Apa itu website SIEVENT?</a>
                        </div>
                        <div id="collapseOne" class="card-body collapse" data-parent="#accordion">
                            <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </p>
                        </div>
                        <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            <a class="card-title"> Bagaimana cara mendaftar akun di sistem kegiatan perlombaan polindra?</a>
                        </div>
                        <div id="collapseTwo" class="card-body collapse" data-parent="#accordion">
                            <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </p>
                        </div>
                        <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            <a class="card-title"> Apa kemudahan yang saya dapat dengan sistem ini ? </a>
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#accordion">
                            <div class="card-body">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. samus labore sustainable VHS. </div>
                        </div>
                        <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            <a class="card-title"> Bagaimana cara untuk mendaftar kompetisi ? </a>
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#accordion">
                            <div class="card-body">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. samus labore sustainable VHS. </div>
                        </div>
                    </div>
                </div>
            </div>
              
        </div>
       
    @endsection

    @push('cs-script')
    
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @endpush