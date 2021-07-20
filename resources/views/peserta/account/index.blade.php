@extends('peserta.app')

@section('title','Account')

@section('content')

<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="profile-photo text-center">
                <a href="#" onclick="savePhoto()" class="upload-avatar d-none"><i class="icon-copy dw dw-upload1"></i></a>
                <a href="#" onclick="hapusPhoto()" class="hapus-avatar d-none"><i class="fa fa-trash"></i></a>
                <a href="#" onclick="uploadPhoto()" class="edit-avatar"><i class="fa fa-pencil"></i></a>
              
                @if ($pengguna->photo)
                    <img src="{{asset('assets/img/photo-pengguna/'.$pengguna->photo)}}" data-photo="1" data-filename="{{$pengguna->photo}}" id="profil-image" alt="" class="avatar-photo">
                @else
                    <img src="{{asset('assets/img/user.svg')}}" id="profil-image" data-photo="0" data-filename="user.svg" alt="" class="avatar-photo">
                @endif
              
                
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
            <h5 class="text-center h5 mb-0">
                @if ($pengguna->is_mahasiswa)
                    {{$pengguna->nama_mhs}}
                @else
                    {{$pengguna->participantRef->nama_participant}}
                @endif
            </h5>
            {{-- <p class="text-center text-muted font-14">Lorem ipsum dolor sit amet</p> --}}
            <div class="profile-info">
                <h5 class="mb-20 h5 text-blue">Informasi Profil</h5>
                <ul>
                    {{-- <li>
                        <span>Jurusan:</span>
                        Teknik Informatika
                    </li> --}}
                    <li>
                        <span>Alamat Email:</span>
                        {{$pengguna->email}}
                    </li>
                    <li>
                        <span>Nomor Telepon:</span>
                        {{$pengguna->phone}}
                    </li>
                    <li>
                        <span>Alamat:</span>
                        {{$pengguna->alamat}}
                    </li>
                </ul>
            </div>
            <div class="profile-social">
                <h5 class="mb-20 h5 text-blue">Sosial Media</h5>
                <ul class="clearfix">
                    <li><a @if($pengguna->facebook_url) href="{{$pengguna->facebook_url}}" @else href="#" @endif class="btn" data-bgcolor="#3b5998" data-color="#ffffff"><i class="fa fa-facebook"></i></a></li>
                    <li><a @if($pengguna->twitter_url) href="{{$pengguna->twitter_url}}" @else href="#" @endif class="btn" data-bgcolor="#1da1f2" data-color="#ffffff"><i class="fa fa-twitter"></i></a></li>
                    <li><a @if($pengguna->linkedin_url) href="{{$pengguna->linkedin_url}}" @else href="#" @endif class="btn" data-bgcolor="#007bb5" data-color="#ffffff"><i class="fa fa-linkedin"></i></a></li>
                    <li><a @if($pengguna->insta_url) href="{{$pengguna->insta_url}}" @else href="#" @endif class="btn" data-bgcolor="#c0406c" data-color="#ffffff"><i class="fa fa-instagram"></i></a></li>
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
                                    <ul class="profile-edit-list row">
                                        <li class="weight-500 col-md-6">
                                            <h4 class="text-blue h5 mb-20">Pengaturan Akun</h4>
                                            <form action="{{route('peserta.account.save')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('patch')
                                                <div class="form-group">
                                                    <label>Nama Lengkap</label>
                                                    @if (Session::get('is_mahasiswa') == "1")
                                                        <input class="form-control form-control-lg" value="{{$pengguna->nama_mhs}}" disabled type="text">
                                                    @else
                                                        <input class="form-control form-control-lg" name="nama" value="{{$pengguna->participantRef->nama_participant}}" type="text">
                                                    @endif
                                                    
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label>Jurusan</label>
                                                    <input class="form-control form-control-lg" value="Teknik Informatika" disabled type="text">
                                                </div> --}}
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input class="form-control form-control-lg" name="email" value="{{$pengguna->email}}"  type="email">
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label>Tanggal Lahir</label>
                                                    <input class="form-control form-control-lg date-picker" name="tgl_lahir" type="text">
                                                </div>
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <div class="d-flex">
                                                    <div class="custom-control custom-radio mb-5 mr-20">
                                                        <input type="radio" id="customRadio4"  name="gender" class="custom-control-input">
                                                        <label class="custom-control-label weight-400" for="customRadio4">Laki-laki</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-5">
                                                        <input type="radio" id="customRadio5"  name="gender" class="custom-control-input">
                                                        <label class="custom-control-label weight-400" for="customRadio5">Perempuan</label>
                                                    </div>
                                                    </div>
                                                </div> --}}
                                                <div class="form-group">
                                                    <label>Nomor Telepon</label>
                                                    <input class="form-control form-control-lg" name="phone" value="{{$pengguna->phone}}" type="text">
                                                </div>
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <textarea name="alamat" class="form-control">
                                                        {{$pengguna->alamat}}
                                                    </textarea>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input type="submit" class="btn btn-primary" value="Simpan">
                                                </div>
                                            </form>
                                        </li>
                                        <li class="weight-500 col-md-6">
                                            <h4 class="text-blue h5 mb-20">Edit Link Sosial Media</h4>
                                            <form action="{{route('peserta.account.save.socialmedia')}}" method="post">
                                                @csrf
                                                @method('patch')
                                                <div class="form-group">
                                                    <label>Facebook URL:</label>
                                                    <input class="form-control form-control-lg" value="{{$pengguna->facebook_url}}" name="facebook" type="text" placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group">
                                                    <label>Twitter URL:</label>
                                                    <input class="form-control form-control-lg" value="{{$pengguna->twitter_url}}" name="twitter" type="text" placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group">
                                                    <label>Linkedin URL:</label>
                                                    <input class="form-control form-control-lg" value="{{$pengguna->linkedin_url}}" name="linkedin" type="text" placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group">
                                                    <label>Instagram URL:</label>
                                                    <input class="form-control form-control-lg" value="{{$pengguna->insta_url}}" name="instagram" type="text" placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input type="submit" class="btn btn-primary" value="Save">
                                                </div>
                                            </form>
                                        </li>
                                    </ul>
                            </div>
                        </div>

                        <form action="{{route('peserta.account.save.photo')}}" id="form-upload-photo" enctype="multipart/form-data" method="post">
                            @csrf
                            @method('patch')
                            <input type="file" class="d-none" onchange="displayPhoto()" id="photo-inp" name="photo" >
                            <input type="hidden" name="oldPhoto" value="{{$pengguna->photo}}">
                        </form>
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

<script>
    const uploadPhoto = () => {
        event.preventDefault();
        $('#photo-inp').trigger('click');
        return false;
    } 
    const displayPhoto = () => {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("photo-inp").files[0]);
        oFReader.onload = (oFREvent) =>  {
            document.getElementById("profil-image").src = oFREvent.target.result;
        };

        $('.hapus-avatar').removeClass('d-none'); 
        $('.upload-avatar').removeClass('d-none'); 
    };

    const hapusPhoto = () => {
        let value = $('#profil-image').data('filename');
        let is_photo = $('#profil-image').data('photo');
        let url = "/assets/img/"+value;
        if(is_photo == 1){
            url = "/assets/img/photo-pengguna/"+value;
        }

        $("#profil-image").attr("src", url);
        $('#photo-inp').val('');
        $('.hapus-avatar').addClass('d-none'); 
        $('.upload-avatar').addClass('d-none'); 
    }

    // submit form photo
    const savePhoto = () => {
        event.preventDefault();
        $("#form-upload-photo").submit();
    }
</script>
@endpush