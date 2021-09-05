@extends('ormawa.app')

@section('title','Settings Profile')

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <p class="h5 text-orange"><i class="icon-copy dw dw-settings mr-2"></i>
                            PROFIL
                        </p>
                        <hr>
                    </div>
                </div>
                <form action="{{route('profile.dosen.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="row mt-5">
                        <div class="col-lg-3 col-12">
                            @if ($pengguna->photo)
                                <div class="border mb-3 ormawa-banner_inp_profil shadow-sm px-4 py-4">
                                    <img src="{{url('assets/img/photo-pengguna/'.$pengguna->photo)}}" id="profil-image"
                                        style="width: 100%" alt="" class="img-fluid">
                                </div>
                            @else
                                <div class="border mb-3 ormawa-banner_inp_profil shadow-sm px-4 py-4">
                                    <img src="{{url('assets/img/no-image.png')}}" id="profil-image"
                                        style="width: 100%" alt="" class="img-fluid">
                                </div>
                            @endif
                            <a href="#" onclick="profilUpload()" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">Upload Photo</a>
                        </div>
                        <div class="col-lg-9 col-12">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Nama </label>
                                @if ($pengguna->dosenRef)
                                    <input type="text" value="{{$pengguna->dosenRef->dosen_lengkap_nama}}" disabled class="form-control">
                                @else
                                    <input type="text" value="{{$pengguna->nidn}}" disabled class="form-control">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Username</label>
                                <input type="text" value="{{$pengguna->username}}" disabled class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Email</label>
                                <input type="text" name="email" value="{{$pengguna->email}}"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{$pengguna->phone}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Alamat</label>
                                <textarea name="alamat" class="form-control" id="alamat-inp">{{$pengguna->alamat}}</textarea>
                            </div>
                            <input type="file" onchange="previewProfilImage()" name="photo" id="profil-inp"
                                class="d-none">
                            <input type="hidden" name="oldPhoto" value="{{$pengguna->photo}}">
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
    </div>
</div>
@endsection

@push('script')
<script src="{{ url('assets/ckeditor/ckeditor.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready( function () {
        $('.js-example-basic-single').select2();
    } );

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