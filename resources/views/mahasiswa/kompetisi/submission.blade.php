@extends('mahasiswa.app')

@section('title', 'Submissin '.$slug)

@section('content')

<div class="row mt-2">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="col-12 mb-3">
            <h3 class="page-title-submission text-secondary"><span class="page-title-icon-submission mr-2"><i class="icon-copy dw dw-rocket text-white"></i></span>
                Submission
            </h3>
        </div>
        <div class="mt-5">
            <div class="tab">
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active  pb-2" data-toggle="tab" href="#home2" role="tab" aria-selected="true">Kriteria Submission</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  pb-2" data-toggle="tab" href="#profile2" role="tab" aria-selected="false">Semua Submission</a>
                    </li>
                </ul>
                <div class="tab-content mb-5">
                    <div class="tab-pane fade show active" id="home2" role="tabpanel">
                        <div class="pd-20">
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h3>Kriteria Submission</h3>
                                </div>
                            </div>
                            <div class="row mt-4 mx-4">
                                <div class="col-12">
                                    <ul style="list-style-type:disc;">
                                        <li>
                                        Tempus vulputate class cum iaculis ornare in ultrices ipsum quis.
                                        </li>
                                        <li>
                                        Dis vestibulum quam dui urna himenaeos fermentum quisque auctor proin!
                                        </li>
                                        <li>
                                        Inceptos luctus commodo urna rhoncus sociosqu lorem dapibus nec nostra.
                                        </li>
                                        <li>
                                        Aenean iaculis primis cum lacinia aptent sem iaculis venenatis lacus.
                                        </li>
                                        <li>
                                        Fermentum eleifend praesent magnis montes est nisi hac hac platea!
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h3>Submission yang Tidak Sesuai Kriteria
                                    </h3>
                                </div>
                            </div>
                            <div class="row mt-4 mx-4">
                                <div class="col-12">
                                    <ul style="list-style-type:disc;">
                                        <li>
                                        Tempus vulputate class cum iaculis ornare in ultrices ipsum quis.
                                        </li>
                                        <li>
                                        Dis vestibulum quam dui urna himenaeos fermentum quisque auctor proin!
                                        </li>
                                        <li>
                                        Inceptos luctus commodo urna rhoncus sociosqu lorem dapibus nec nostra.
                                        </li>
                                        <li>
                                        Aenean iaculis primis cum lacinia aptent sem iaculis venenatis lacus.
                                        </li>
                                        <li>
                                        Fermentum eleifend praesent magnis montes est nisi hac hac platea!
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 text-center mt-5">
                                    <div class="card-box" style="background-color: #142127 !important">
                                        <div class="pd-20">
                                                <a href="https://www.dicoding.com/students/638199/submissions" data-toggle="modal" data-target="#social-submit-modal" class="btn bg-orange text-white btn-md shadow">Upload Submission</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade mb-4" id="profile2" role="tabpanel">
                        <div class="row mt-5 pl-3">
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="float-md-left">
                                    <div class="row right-sorting">
                                        <div class="col-md pr-0">
                                            <small class="float-md-right text-nowrap py-2">Urut berdasarkan:</small>
                                        </div>
                                        <div class="col-md pr-0">
                                            <select class="form-control selectpicker d-inline" name="" id="" data-size="5">
                                                <option selected>Terbaru</option>
                                                <option value="Kotak Pena">Terlama</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 mb-3">
                                <div class="card-box card-submission">
                                    <div class="pd-20">
                                        <div class="card-submission__body" style="display: flex;align-items: center;">
                                            <a href="https://www.dicoding.com/academies/219" class="remove-style-link" style="    text-decoration: none;
                                            color: #3d3d3d!important;">
                                                <img src="{{url('assets/img/kompetisi-thumb/thumbnail.jpg')}}"  class="lazy" style="display: inline;">
                                            </a>
                                            <div>
                                                <div class="dcd-card-list__content">
                                                    <a href="#" class="remove-style-link">
                                                        <span class="dcd-card-list__title">Design Competition</span>
                                                    </a>
                                                    <span class="dcd-badge dcd-badge-sm dcd-badge-success">Disetujui</span>
                                                </div>
                                                <div class="d-none d-lg-block">
                                                    <div class="dcd-card-list__info">
                                                        <span>
                                                            <a class="dcd-link" title="Submission: Katalog Restoran" href="#">
                                                                Hifni Alimudin
                                                            </a>
                                                        </span>
                                                        <span class="text-gray-400 ml-3">|</span>
                                                        <span class="text-gray-600 mx-3"><i class="icon-copy dw dw-calendar-1 mr-2"></i>Dikirim pada : 16 May 2021</span>
                                                        <span class="text-gray-400 mr-3">|</span>                                                                                                </div>
                                                </div>
                                            </div>
                                            <div class="ml-auto">
                                                <div class="d-none d-lg-block">
                                                    <a href="https://www.dicoding.com/academysubmissions/724425" class="dcd-btn dcd-btn-sm dcd-btn-primary">
                                                        Buka Submission
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-block d-lg-none">
                                            <div class="dcd-card-list__info">
                                                <div class="row my-2">
                                                    <div class="col-12 mb-2">
                                                        <span><a class="dcd-link" href="https://www.dicoding.com/academies/219/tutorials/9301">Submission: Katalog Restoran</a></span>
                                                    </div>
                                                    <div class="col-12">
                                                        <span>Dikirim pada : 16 May 2021</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="https://www.dicoding.com/academysubmissions/724425" class="dcd-btn dcd-btn-sm dcd-btn-primary btn-block mt-2">
                                                Buka Submission
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="card-box card-submission">
                                    <div class="pd-20">
                                        <div class="card-submission__body" style="display: flex;align-items: center;">
                                            <a href="https://www.dicoding.com/academies/219" class="remove-style-link" style="    text-decoration: none;
                                            color: #3d3d3d!important;">
                                                <img src="{{url('assets/img/kompetisi-thumb/thumbnail.jpg')}}"  class="lazy" style="display: inline;">
                                            </a>
                                            <div>
                                                <div class="dcd-card-list__content">
                                                    <a href="#" class="remove-style-link">
                                                        <span class="dcd-card-list__title">Design Competition</span>
                                                    </a>
                                                    <span class="dcd-badge dcd-badge-sm dcd-badge-danger">Disetujui</span>
                                                </div>
                                                <div class="d-none d-lg-block">
                                                    <div class="dcd-card-list__info">
                                                        <span>
                                                            <a class="dcd-link" title="Submission: Katalog Restoran" href="#">
                                                                Hifni Alimudin
                                                            </a>
                                                        </span>
                                                        <span class="text-gray-400 ml-3">|</span>
                                                        <span class="text-gray-600 mx-3"><i class="icon-copy dw dw-calendar-1 mr-2"></i>Dikirim pada : 16 May 2021</span>
                                                        <span class="text-gray-400 mr-3">|</span>                                                                                                </div>
                                                </div>
                                            </div>
                                            <div class="ml-auto">
                                                <div class="d-none d-lg-block">
                                                    <a href="{{route('mahasiswa.kompetisi.submission.info','Design-competition')}}" class="dcd-btn dcd-btn-sm dcd-btn-primary">
                                                        Buka Submission
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-block d-lg-none">
                                            <div class="dcd-card-list__info">
                                                <div class="row my-2">
                                                    <div class="col-12 mb-2">
                                                        <span><a class="dcd-link" href="https://www.dicoding.com/academies/219/tutorials/9301">Submission: Katalog Restoran</a></span>
                                                    </div>
                                                    <div class="col-12">
                                                        <span>Dikirim pada : 16 May 2021</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="https://www.dicoding.com/academysubmissions/724425" class="dcd-btn dcd-btn-sm dcd-btn-primary btn-block mt-2">
                                                Buka Submission
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-box card-submission">
                                    <div class="pd-20">
                                        <div class="card-submission__body" style="display: flex;align-items: center;">
                                            <a href="https://www.dicoding.com/academies/219" class="remove-style-link" style="    text-decoration: none;
                                            color: #3d3d3d!important;">
                                                <img src="{{url('assets/img/kompetisi-thumb/thumbnail.jpg')}}"  class="lazy" style="display: inline;">
                                            </a>
                                            <div>
                                                <div class="dcd-card-list__content">
                                                    <a href="#" class="remove-style-link">
                                                        <span class="dcd-card-list__title">Design Competition</span>
                                                    </a>
                                                    <span class="dcd-badge dcd-badge-sm dcd-badge-success">Disetujui</span>
                                                </div>
                                                <div class="d-none d-lg-block">
                                                    <div class="dcd-card-list__info">
                                                        <span>
                                                            <a class="dcd-link" title="Submission: Katalog Restoran" href="#">
                                                                Hifni Alimudin
                                                            </a>
                                                        </span>
                                                        <span class="text-gray-400 ml-3">|</span>
                                                        <span class="text-gray-600 mx-3"><i class="icon-copy dw dw-calendar-1 mr-2"></i>Dikirim pada : 16 May 2021</span>
                                                        <span class="text-gray-400 mr-3">|</span>                                                                                                </div>
                                                </div>
                                            </div>
                                            <div class="ml-auto">
                                                <div class="d-none d-lg-block">
                                                    <a href="https://www.dicoding.com/academysubmissions/724425" class="dcd-btn dcd-btn-sm dcd-btn-primary">
                                                        Buka Submission
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-block d-lg-none">
                                            <div class="dcd-card-list__info">
                                                <div class="row my-2">
                                                    <div class="col-12 mb-2">
                                                        <span><a class="dcd-link" href="https://www.dicoding.com/academies/219/tutorials/9301">Submission: Katalog Restoran</a></span>
                                                    </div>
                                                    <div class="col-12">
                                                        <span>Dikirim pada : 16 May 2021</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="https://www.dicoding.com/academysubmissions/724425" class="dcd-btn dcd-btn-sm dcd-btn-primary btn-block mt-2">
                                                Buka Submission
                                            </a>
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

<div class="modal fade" id="file-submit-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Submit Berkas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">Referensi Submission</label>
                            <select name="" class="form-control" id="">
                                <option value="">Pilih</option>
                                <option value="">sdad</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="file" name="" class="form-control" id="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn bg-orange text-white">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="social-submit-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Submit Berkas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for=""><i class="fa fa-user mr-2"></i>Peserta</label>
                            <input type="text" name="" value="Jhon Doe" class="form-control" id="" disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label for=""><i class="fa fa-instagram mr-2"></i>Link Social Media</label>
                            <input type="text" name="" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <input type="file" name="" class="form-control" id="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn bg-orange text-white">Submit</button>
            </div>
        </div>
    </div>
</div>

@endsection