@extends('mahasiswa.app')

@section('title','Tim')

@section('content')

<div class="container-fluid">
    <div class="pd-20">
        <div class="product-wrap">
            <div class="product-list">
                <ul class="row">
                    <li class="col-lg-4 col-md-6 col-sm-12">
                        <div class="product-box">
                            
                            <div class="producct-img"><img src="{{url('assets/img/kompetisi-thumb/thumbnail.jpg')}}" alt=""></div>
                            <div class="product-caption">
                                <h4><a href="#">Design Competition</a></h4>
                                <small class="text-muted">Oleh: <a href="https://www.dicoding.com/users/378" class="text-orange" target="_blank" rel="noopener noreferrer">
                                    HIMATIF
                                </a></small>
                                <div class="mb-3">
                                    <small class="text-muted">4/5 Anggota</small>
                                </div>
                                <span class="my-3 d-block">Terdaftar: 24 Nov 2018 15:33</span>
                                <a href="{{route('mahasiswa.team.detail',1)}}" class="btn bg-orange text-white" style="padding: 5px 20px">Lihat</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="blog-pagination mb-30">
                <div class="btn-toolbar justify-content-center mb-15">
                    <div class="btn-group">
                        <a href="#" class="btn btn-outline-primary prev"><i class="fa fa-angle-double-left"></i></a>
                        <a href="#" class="btn btn-outline-primary">1</a>
                        <a href="#" class="btn btn-outline-primary">2</a>
                        <span class="btn btn-primary current">3</span>
                        <a href="#" class="btn btn-outline-primary">4</a>
                        <a href="#" class="btn btn-outline-primary">5</a>
                        <a href="#" class="btn btn-outline-primary next"><i class="fa fa-angle-double-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection