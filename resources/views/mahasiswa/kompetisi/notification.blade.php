@extends('mahasiswa.app')

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
        <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
            <div class="card card-box">
                <img class="card-img-top" src="{{url('assets/img/notif-kompetisi/example.png')}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title weight-500">Pengumuman Pemenang</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn bg-orange text-white">Lihat</a>
                </div>
            </div>
        </div>
    </div>

@endsection