@extends('peserta.app')

@section('title', $slug)

@section('content')

    <div class="row my-5">
       <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box" style="border-radius: 20px">
                    <div class="">
                        <img src="{{url('assets/img/banner-komp/example.jpeg')}}" style="border-radius: 20px" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30 mt-5">
                <div class="tab">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item mx-3 mb-3">
                            <a class="nav-link active text-blue" data-toggle="tab" href="#home5" role="tab" aria-selected="true">Deskripsi</a>
                        </li>
                        <li class="nav-item mx-3 mb-3">
                            <a class="nav-link text-blue" data-toggle="tab" href="#profile5" role="tab" aria-selected="false">Ketentuan</a>
                        </li>
                        <li class="nav-item mx-3 mb-3">
                            <a class="nav-link text-blue" data-toggle="tab" href="#contact5" role="tab" aria-selected="false">Pendaftar</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="home5" role="tabpanel">
                            <div class="pd-20">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile5" role="tabpanel">
                            <div class="pd-20">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact5" role="tabpanel">
                            <div class="mt-4">
                                <table class="data-table table stripe hover nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="table-plus datatable-nosort">Nama</th>
                                            <th>Jurusan</th>
                                            <th>Submission</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="table-plus">Hifni Alimudin</td>
                                            <td>Teknik Informatika</td>
                                            <td><i class="icon-copy dw dw-checked text-orange"></i></td>
                                        </tr>
                                        <tr>
                                            <td class="table-plus">Hifni Alimudin</td>
                                            <td>Teknik Informatika</td>
                                            <td><i class="icon-copy dw dw-checked text-orange"></i></td>
                                        </tr>
                                        <tr>
                                            <td class="table-plus">Hifni Alimudin</td>
                                            <td>Teknik Informatika</td>
                                            <td><i class="icon-copy dw dw-checked text-orange"></i></td>
                                        </tr>
                                        <tr>
                                            <td class="table-plus">Hifni Alimudin</td>
                                            <td>Teknik Informatika</td>
                                            <td><i class="icon-copy dw dw-checked text-orange"></i></td>
                                        </tr>
                                        <tr>
                                            <td class="table-plus">Hifni Alimudin</td>
                                            <td>Teknik Informatika</td>
                                            <td><i class="icon-copy dw dw-checked text-orange"></i></td>
                                        </tr>
                                        <tr>
                                            <td class="table-plus">Hifni Alimudin</td>
                                            <td>Teknik Informatika</td>
                                            <td><i class="icon-copy dw dw-checked text-orange"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div>
       <div class="col-lg-4 col-md-12 border col-sm-12 mb-30">
            <div class="row clearfix progress-box">
                <div class="col-lg-12 col-md-4">
                    <div class="card-box pd-30 height-100-p">
                        <div class="progress-box text-center">
                             <input type="text" class="knob dial1" value="80" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#1b00ff" data-angleOffset="180" readonly>
                            <h5 class="text-blue padding-top-10 h5">Pendaftar</h5>
                            <span class="d-block">20/100 Pendaftar</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-4 mt-3">
                    <div class="card-box pd-30 height-100-p text-center">
                        <img src="{{url('assets/img/ormawa-logo/himatif.png')}}" style="max-width: 100px" alt="" class="img-fluid">
                        <h5 class="text-blue padding-top-10 h5">HIMATIF</h5>
                    </div>
                </div>
                <div class="col-lg-12 col-md-4 mt-3">
                    <div class="card-box text-center " style="padding: 0 !important">
                        <img src="{{url('assets/img/kompetisi-thumb/thumbnail.jpg')}}" style="border-radius: 10px" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

