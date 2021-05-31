@extends('mahasiswa.app')

@section('title','Account')

@section('content')

<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="profile-photo">
                <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                <img src="{{url('assets/deskapp/vendors/images/photo1.jpg')}}" alt="" class="avatar-photo">
                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body pd-5">
                                <div class="img-container">
                                    <img id="image" src="{{url('assets/deskapp/vendors/images/photo2.jpg')}}" alt="Picture">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" value="Update" class="btn btn-primary">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="text-center h5 mb-0">Hifni Alimudin</h5>
            <p class="text-center text-muted font-14">Lorem ipsum dolor sit amet</p>
            <div class="profile-info">
                <h5 class="mb-20 h5 text-blue">Informasi Kontak</h5>
                <ul>
                    <li>
                        <span>Jurusan:</span>
                        Teknik Informatika
                    </li>
                    <li>
                        <span>Alamat Email:</span>
                        hifni@gmail.com
                    </li>
                    <li>
                        <span>Nomor Telepon:</span>
                        619-229-0054
                    </li>
                    <li>
                        <span>Alamat:</span>
                        1807 Holden Street<br>
                        San Diego, CA 92115
                    </li>
                </ul>
            </div>
            <div class="profile-social">
                <h5 class="mb-20 h5 text-blue">Sosial Media</h5>
                <ul class="clearfix">
                    <li><a href="#" class="btn" data-bgcolor="#3b5998" data-color="#ffffff"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#" class="btn" data-bgcolor="#1da1f2" data-color="#ffffff"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#" class="btn" data-bgcolor="#007bb5" data-color="#ffffff"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="#" class="btn" data-bgcolor="#c0406c" data-color="#ffffff"><i class="fa fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
        <div class="card-box height-100-p overflow-hidden">
            <div class="profile-tab height-100-p">
                <div class="tab height-100-p">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">Riwayat Kompetisi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pencapaian" role="tab">Pencapaian</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#setting" role="tab">Pengaturan</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Timeline Tab start -->
                        <div class="tab-pane fade show active" id="timeline" role="tabpanel">
                            <div class="pd-20">
                                <div class="profile-timeline">
                                    <div class="timeline-month">
                                        <h5>August, 2020</h5>
                                    </div>
                                    <div class="profile-timeline-list">
                                        <ul>
                                            <li>
                                                <div class="date">12 Aug</div>
                                                <div class="task-name"><i class="ion-android-alarm-clock"></i> Task Added</div>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                <div class="task-time">09:30 am</div>
                                            </li>
                                            <li>
                                                <div class="date">10 Aug</div>
                                                <div class="task-name"><i class="ion-ios-chatboxes"></i> Task Added</div>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                <div class="task-time">09:30 am</div>
                                            </li>
                                            <li>
                                                <div class="date">10 Aug</div>
                                                <div class="task-name"><i class="ion-ios-clock"></i> Event Added</div>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                <div class="task-time">09:30 am</div>
                                            </li>
                                            <li>
                                                <div class="date">10 Aug</div>
                                                <div class="task-name"><i class="ion-ios-clock"></i> Event Added</div>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                <div class="task-time">09:30 am</div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="timeline-month">
                                        <h5>July, 2020</h5>
                                    </div>
                                    <div class="profile-timeline-list">
                                        <ul>
                                            <li>
                                                <div class="date">12 July</div>
                                                <div class="task-name"><i class="ion-android-alarm-clock"></i> Task Added</div>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                <div class="task-time">09:30 am</div>
                                            </li>
                                            <li>
                                                <div class="date">10 July</div>
                                                <div class="task-name"><i class="ion-ios-chatboxes"></i> Task Added</div>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                <div class="task-time">09:30 am</div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="timeline-month">
                                        <h5>June, 2020</h5>
                                    </div>
                                    <div class="profile-timeline-list">
                                        <ul>
                                            <li>
                                                <div class="date">12 June</div>
                                                <div class="task-name"><i class="ion-android-alarm-clock"></i> Task Added</div>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                <div class="task-time">09:30 am</div>
                                            </li>
                                            <li>
                                                <div class="date">10 June</div>
                                                <div class="task-name"><i class="ion-ios-chatboxes"></i> Task Added</div>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                <div class="task-time">09:30 am</div>
                                            </li>
                                            <li>
                                                <div class="date">10 June</div>
                                                <div class="task-name"><i class="ion-ios-clock"></i> Event Added</div>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                <div class="task-time">09:30 am</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Timeline Tab End -->
                        <!-- Tasks Tab start -->
                        <div class="tab-pane fade" id="pencapaian" role="tabpanel">
                            <div class="pd-20 profile-task-wrap">
                                <div class="container pd-0">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 text-center">
                                            <div class="card text-center shadow" style="border-radius: 20px;">
                                                <img src="{{url('assets/img/icon/gold-medal.svg')}}" style="max-width: 90px" alt="" class="text-center mx-auto img-fluid">
                                                <div class="card-body">
                                                    <h3 class="card-title" style="color: #fb8c00">Design Competition</h3>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="float-left">
                                                        <img src="{{url('assets/img/ormawa-logo/himatif.png')}}" style="max-width: 25px;max-height:25px" alt="" class="text-center img-fluid">
                                                    </div>
                                                    <div class="float-right text-secondary">
                                                        <small style="color: #fb8c00">
                                                            19-May-2021</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 text-center">
                                            <div class="card text-center shadow" style="border-radius: 20px;">
                                                <img src="{{url('assets/img/icon/silver-medal.svg')}}" style="max-width: 90px;" alt="" class="text-center mx-auto img-fluid">
                                                <div class="card-body">
                                                    <h3 class="card-title" style="color: #fb8c00">Karya Competition</h3>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="float-left">
                                                        <img src="{{url('assets/img/ormawa-logo/kotak-pena.png')}}" style="max-width: 25px;max-height:25px" alt="" class="text-center img-fluid">
                                                    </div>
                                                    <div class="float-right text-secondary">
                                                        <small style="color: #fb8c00">
                                                            19-May-2021</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tasks Tab End -->

                        <!-- Setting Tab start -->
                        <div class="tab-pane fade height-100-p" id="setting" role="tabpanel">
                            <div class="profile-setting">
                                <form>
                                    <ul class="profile-edit-list row">
                                        <li class="weight-500 col-md-6">
                                            <h4 class="text-blue h5 mb-20">Pengaturan Akun</h4>
                                            <div class="form-group">
                                                <label>Nama Lengkap</label>
                                                <input class="form-control form-control-lg" value="Hifni Alimudin" disabled type="text">
                                            </div>
                                            <div class="form-group">
                                                <label>Jurusan</label>
                                                <input class="form-control form-control-lg" value="Teknik Informatika" disabled type="text">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control form-control-lg"  type="email">
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Lahir</label>
                                                <input class="form-control form-control-lg date-picker" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <div class="d-flex">
                                                <div class="custom-control custom-radio mb-5 mr-20">
                                                    <input type="radio" id="customRadio4" disabled name="customRadio" class="custom-control-input">
                                                    <label class="custom-control-label weight-400" for="customRadio4">Laki-laki</label>
                                                </div>
                                                <div class="custom-control custom-radio mb-5">
                                                    <input type="radio" id="customRadio5" disabled name="customRadio" class="custom-control-input">
                                                    <label class="custom-control-label weight-400" for="customRadio5">Perempuan</label>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nomor Telepon</label>
                                                <input class="form-control form-control-lg" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <textarea class="form-control"></textarea>
                                            </div>
                                            <div class="form-group mb-0">
                                                <input type="submit" class="btn btn-primary" value="Simpan">
                                            </div>
                                        </li>
                                        <li class="weight-500 col-md-6">
                                            <h4 class="text-blue h5 mb-20">Edit Link Sosial Media</h4>
                                            <div class="form-group">
                                                <label>Facebook URL:</label>
                                                <input class="form-control form-control-lg" type="text" placeholder="Paste your link here">
                                            </div>
                                            <div class="form-group">
                                                <label>Twitter URL:</label>
                                                <input class="form-control form-control-lg" type="text" placeholder="Paste your link here">
                                            </div>
                                            <div class="form-group">
                                                <label>Linkedin URL:</label>
                                                <input class="form-control form-control-lg" type="text" placeholder="Paste your link here">
                                            </div>
                                            <div class="form-group">
                                                <label>Instagram URL:</label>
                                                <input class="form-control form-control-lg" type="text" placeholder="Paste your link here">
                                            </div>
                                            <div class="form-group mb-0">
                                                <input type="submit" class="btn btn-primary" value="Save">
                                            </div>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                        <!-- Setting Tab End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@push('script')
<script src="{{url('assets/deskapp/vendors/scripts/core.js')}}"></script>
<script src="{{url('assets/deskapp/vendors/scripts/script.min.js')}}"></script>
<script src="{{url('assets/deskapp/vendors/scripts/process.js')}}"></script>
<script src="{{url('assets/deskapp/vendors/scripts/layout-settings.js')}}"></script>
<script src="{{url('assets/deskapp/src/plugins/cropperjs/dist/cropper.js')}}"></script>
<script>

    window.addEventListener('DOMContentLoaded', function () {
        var image = document.getElementById('image');
        var cropBoxData;
        var canvasData;
        var cropper;

        $('#modal').on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                autoCropArea: 0.5,
                dragMode: 'move',
                aspectRatio: 3 / 3,
                restore: false,
                guides: false,
                center: false,
                highlight: false,
                cropBoxMovable: false,
                cropBoxResizable: false,
                toggleDragModeOnDblclick: false,
                ready: function () {
                    cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                }
            });
        }).on('hidden.bs.modal', function () {
            cropBoxData = cropper.getCropBoxData();
            canvasData = cropper.getCanvasData();
            cropper.destroy();
        });
    });
</script>
@endpush