@extends('template')

@section('title', 'Kompetisi')


@section('content')
    <!-- Hero Area Start-->
    <div class="slider-area ">
        <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="assets/img/banner/banner-komp2.jpeg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>Ikuti Event yang Kamu Inginkan</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End -->
    <!-- Job List Area Start -->
    <div class="job-listing-area pt-120 pb-120">
        <div class="container">
            <div class="row">
                <!-- Left content -->
                <div class="col-xl-3 col-lg-3 col-md-12">
                    <div class="row">
                        <div class="col-12">
                                <div class="small-section-tittle2 mb-45">
                                <div class="ion"> <svg 
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="20px" height="12px">
                                <path fill-rule="evenodd"  fill="rgb(7, 79, 191)"
                                    d="M7.778,12.000 L12.222,12.000 L12.222,10.000 L7.778,10.000 L7.778,12.000 ZM-0.000,-0.000 L-0.000,2.000 L20.000,2.000 L20.000,-0.000 L-0.000,-0.000 ZM3.333,7.000 L16.667,7.000 L16.667,5.000 L3.333,5.000 L3.333,7.000 Z"/>
                                </svg>
                                </div>
                                <h4>Filter Event</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Job Category Listing start -->
                    <div class="job-category-listing mb-50">
                        <!-- single one -->
                        <div class="single-listing">
                            <div class="small-section-tittle2">
                                <h4>Nama Event</h4>
                            </div>
                            <div class="input-form mb-4">
                                <input type="text" class="form-control" name="name" placeholder="Nama Event">
                            </div>
                            <div class="small-section-tittle2">
                                <h4>Kategori Event</h4>
                            </div>
                            <!-- Select job items start -->
                            <div class="select-job-items2">
                                <select name="select" class="select-single" style="width: 100%">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{$kategori->id_kategori}}">{{$kategori->nama_kategori}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--  Select job items End-->
                            <!-- select-Categories start -->
                            <div class="select-Categories pt-30 pb-30">
                                <div class="small-section-tittle2">
                                    <h4>Status</h4>
                                </div>
                                <label class="container">Selesai
                                    <input type="checkbox" >
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container">Dibuka
                                    <input type="checkbox" checked="checked active">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <!-- select-Categories End -->
                        </div>
                        <!-- single two -->
                        <div class="single-listing">
                            <div class="small-section-tittle2">
                                    <h4>Ormawa</h4>
                            </div>
                            <!-- Select job items start -->
                            <div class="select-job-items2">
                                <select name="select" class="select-single" style="width: 100%">
                                    <option value="">Semua</option>
                                    @foreach ($ormawas as $ormawa)
                                        <option value="{{$ormawa->id_ormawa}}">{{$ormawa->nama_ormawa}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--  Select job items End-->
                        </div>
                        <!-- single three -->
                        <div class="single-listing pt-30 pb-50">
                            <!-- Range Slider Start -->
                            <aside class="left_widgets p_filter_widgets price_rangs_aside sidebar_box_shadow">
                                <div class="small-section-tittle2">
                                    <h4>Jumlah Pendaftar</h4>
                                </div>
                                <div class="widgets_inner">
                                    <div class="range_item">
                                        <!-- <div id="slider-range"></div> -->
                                        <input type="text" class="js-range-slider" value="" />
                                        <div class="d-flex align-items-center">
                                            <div class="price_text">
                                                <p>Pendaftar :</p>
                                            </div>
                                            <div class="price_value d-flex justify-content-center">
                                                <input type="text" class="js-input-from" id="amount" readonly />
                                                <span> - </span>
                                                <input type="text" class="js-input-to" id="amount" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </aside>
                        <!-- Range Slider End -->
                        <input type="submit" class="btn-search mt-3" style="padding: 20px 30px" value="Cari">
                        </div>
                    </div>
                    <!-- Job Category Listing End -->
                </div>
                <!-- Right content -->
                <div class="col-xl-9 col-lg-9 col-md-12">
                    <!-- Featured_job_start -->
                    <section class="featured-job-area">
                        <div class="container">
                            <!-- Count of Job list Start -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="count-job mb-35">
                                        <span>39, 782 Event Ditemukan</span>
                                        <!-- Select job items start -->
                                        <div class="select-job-items">
                                            <span>Sort by</span>
                                            <select name="select" class="form-control">
                                                <option value="">None</option>
                                                <option value="">job list</option>
                                                <option value="">job list</option>
                                                <option value="">job list</option>
                                            </select>
                                        </div>
                                        <!--  Select job items End-->
                                    </div>
                                </div>
                            </div>
                            <!-- Count of Job list End -->
                            <div class="row">
                                @foreach ($events as $event)
                                <div class="col-lg-6 col-md-6 col-12 mt-5">
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
                                            @php
                                                 $slug = \Str::slug($event->nama_event);
                                            @endphp
                                            <a href="{{route('event.detail', $slug)}}"><h1 class="mt-3">
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
                            <div class="row mt-5">
                                <div class="col-12">
                                        <!--Pagination Start  -->
                                        <div class="pagination-area pb-115 text-center">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        {{ $events->links('vendor.pagination.event_pagination') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Pagination End  -->
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Featured_job_end -->
                </div>
            </div>
        </div>
    </div>
    <!-- Job List Area End -->



@endsection
