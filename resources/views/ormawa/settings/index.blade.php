@extends('ormawa.app')

@section('title','Settings Profile')

@push('css')
<style>
    .nav-link:hover {
        color: #f5a461 !important;
    }
</style>
@endpush

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="card mb-3">
            <div class="card-body">
                <div class="tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-orange" data-toggle="tab" href="#profil" role="tab"
                                aria-selected="true">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-orange" data-toggle="tab" href="#pembina" role="tab"
                                aria-selected="false">Pembina</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="profil" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <p class="h5 text-orange"><i class="icon-copy dw dw-settings mr-2"></i>FORM PENGATURAN
                                    PROFIL
                                </p>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 table-responsive">
                                <div class="mx-auto " style="width: 80%;">
                                    @if ($ormawa->banner)
                                    <div class="ormawa-banner_inp_profil shadow-sm">
                                        <img src="{{url('assets/img/banner-ormawa/'.$ormawa->banner)}}"
                                            id="banner-image" style="width: 100%" alt="" class="img-fluid">
                                    </div>
                                    @else
                                    <div class="ormawa-banner_inp_profil shadow-sm">
                                        <img src="{{url('assets/img/banner-ormawa-upload.png')}}" id="banner-image"
                                            style="width: 100%" alt="" class="img-fluid">
                                    </div>
                                    @endif
                                    <a href="#" onclick="bannerUpload()" id="banner-upload-btn"
                                        class="mt-3 dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">Banner
                                        Profil</a>
                                </div>
                            </div>
                        </div>
                        <form action="{{route('ormawa.settings.index.update')}}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="row mt-5">
                                <div class="col-lg-3 col-12">
                                    @if ($ormawa->photo)
                                    <div class="border mb-3 ormawa-banner_inp_profil shadow-sm px-4 py-4">
                                        <img src="{{url('assets/img/ormawa-logo/'.$ormawa->photo)}}" id="profil-image"
                                            style="width: 100%" alt="" class="img-fluid">
                                    </div>
                                    @else
                                    <div class="border mb-3 ormawa-banner_inp_profil shadow-sm px-4 py-4">
                                        <img src="{{url('assets/img/no-image.png')}}" id="profil-image"
                                            style="width: 100%" alt="" class="img-fluid">
                                    </div>
                                    @endif
                                    <a href="#" onclick="profilUpload()" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">Logo
                                        Profil</a>
                                </div>
                                <div class="col-lg-9 col-12">
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">Nama Ormawa</label>
                                        <input type="text" value="{{$ormawa->nama_ormawa}}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">Username</label>
                                        <input type="text" value="{{$ormawa->username}}" disabled class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">Nama Akronim</label>
                                        <input type="text" name="akronim" value="{{$ormawa->nama_akronim}}" disabled
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">Email</label>
                                        <input type="text" name="email" value="{{$ormawa->email}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control" id="deskripsi-inp"
                                            name="syarat">{{$ormawa->deskripsi}}</textarea>
                                    </div>
                                    {{-- <div class="form-group">
                                    <label for="" class="font-weight-bold">Alamat Facebook</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="" class="font-weight-bold">Alamat Instagram</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="" class="font-weight-bold">Alamat Youtube</label>
                                    <input type="text" class="form-control">
                                </div> --}}
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">Website</label>
                                        <input type="text" name="website" value="{{$ormawa->website}}"
                                            class="form-control">
                                    </div>
                                    <input type="file" onchange="previewBannerImage()" name="banner" id="banner-inp"
                                        class="d-none">
                                    <input type="file" onchange="previewProfilImage()" name="photo" id="profil-inp"
                                        class="d-none">
                                    <input type="hidden" name="oldPhoto" value="{{$ormawa->photo}}">
                                    <input type="hidden" name="oldBanner" value="{{$ormawa->photo}}">

                                    <div class="form-group">
                                        <input type="submit" value="Submit"
                                            class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                            style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="pembina" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <p class="h5 text-orange"><i class="icon-copy dw dw-user-2 mr-2"></i>Daftar Pembina
                                </p>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ url('assets/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace( 'deskripsi-inp',{
	customConfig: '/public/assets/ckeditor/ckeditor_ormawa_profil.js'
});

// upload poster
const bannerUpload = () => {
        event.preventDefault();
        $('#banner-inp').trigger('click');
        return false;
    } 
const previewBannerImage = () => {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("banner-inp").files[0]);
        oFReader.onload = (oFREvent) =>  {
                document.getElementById("banner-image").src = oFREvent.target.result;
            };
    };

const profilUpload = () => {
    event.preventDefault();
    $('#profil-inp').trigger('click');
    return false;
} 
const previewProfilImage = () => {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("profil-inp").files[0]);
        oFReader.onload = (oFREvent) =>  {
                document.getElementById("profil-image").src = oFREvent.target.result;
            };
    };
</script>

@endpush