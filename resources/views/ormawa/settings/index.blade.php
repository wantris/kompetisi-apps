@extends('ormawa.app')

@section('title','Settings Profile')

@push('css')
<style>
    .nav-link:hover {
        color: #f5a461 !important;
    }

    .dataTables_length {
        margin-bottom: 20px !important;
    }
    
    .dataTables_paginate {
        margin-top: 20px !important;
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
                        @if (Session::get('is_pembina') == "0")
                        <li class="nav-item">
                            <a class="nav-link text-orange" data-toggle="tab" href="#pembina" role="tab"
                                aria-selected="false">Pembina</a>
                        </li>
                        @endif
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
                                        <input type="text" name="akronim" value="{{$ormawa->nama_akronim}}"
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
                                    @if (Session::get('is_pembina') == "0")
                                    <div class="form-group">
                                        <input type="submit" value="Submit"
                                            class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                            style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="pembina" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="h5 text-orange" id="title-pembina"><i
                                        class="icon-copy dw dw-user-2 mr-2"></i>Daftar Pembina
                                </p>
                            </div>
                            <div class="col-6 text-right">
                                {{-- <div id="container-btn">
                                    <a href="#" onclick="showForm()" id="tambah-btn"
                                        class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                        Tambah</a>
                                </div> --}}
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>

                        <div class="row" id="table-pembina">
                            <div class="col-12">
                                <table id="pembina-table" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Dosen</th>
                                            <th>Jurusan</th>
                                            <th>Tahun Jabatan</th>
                                            <th>Status Keaktifan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pembinas as $pembina)
                                        <tr id="tr_{{$pembina->id_pembina}}">
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                @if ($pembina->dosenRef)
                                                    {{$pembina->dosenRef->dosen_lengkap_nama}}
                                                @else
                                                    {{$pembina->nidn}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($pembina->dosenRef)
                                                    {{$pembina->dosenRef->program_studi_nama}}
                                                @endif
                                            </td>
                                            <td>{{$pembina->tahun_jabatan}}</td>
                                            <td>
                                                @if ($pembina->status == 1)
                                                <a href="#" style="font-size: 11px; margin-bottom:10px"
                                                    class="btn btn-success btn-sm">Aktif</a>
                                                @else
                                                <a href="#" style="font-size: 11px;margin-bottom:10px"
                                                    class="btn btn-danger btn-sm">Tidak</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="form-pembina">
                            <div class="col-12">
                                <form action="{{route('ormawa.settings.tambah.pembina')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Nama Dosen</label>
                                        <select class="js-example-basic-single" style="width: 100%" name="nama_dosen">
                                            <option selected>Pilih Dosen</option>
                                            @foreach ($dosens as $dosen)
                                                <option value="{{$dosen->dosen_nidn}}">
                                                    {{$dosen->dosen_gelar_depan . " " . $dosen->dosen_nama . " " . $dosen->dosen_gelar_belakang}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('nama_dosen'))
                                        <span class="text-danger">{{ $errors->first('nama_dosen') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Tahun Jabatan</label>
                                        <select name="tahun_jabatan" id="" class="form-control">
                                            <option selected>Pilih Tahun</option>
                                            @for ($i = 2015; $i <= date('Y'); $i++) <option value="{{$i}}">{{$i}}
                                                </option>
                                                @endfor
                                        </select>
                                        @if ($errors->has('tahun_jabatan'))
                                        <span class="text-danger">{{ $errors->first('tahun_jabatan') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Status Keaktifan</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="0">Tidak</option>
                                            <option value="1">Aktif</option>
                                        </select>
                                        @if ($errors->has('status'))
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @endif
                                    </div>
                                    <input type="submit" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important"
                                        value="Submit">

                                </form>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    CKEDITOR.replace( 'deskripsi-inp',{
        customConfig: '/public/assets/ckeditor/ckeditor_ormawa_profil.js'
    });

    $(document).ready( function () {
        $('#pembina-table').DataTable();
        $('#form-pembina').hide();
        $('.js-example-basic-single').select2();
    } );

    const showForm = () => {
        let html = `
             <a href="#" onclick="showTable()" id="table-btn" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                List</a>
        `;
        $('#table-pembina').hide(1000);
        $('#form-pembina').show(1000);
        $('#title-pembina').html('<i class="icon-copy dw dw-user-2 mr-2"></i>Tambah Pembina');
        document.getElementById('container-btn').innerHTML = html;
    };

    const showTable = () => {
        let html = `
            <a href="#" onclick="showForm()" id="tambah-btn" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                Tambah</a>
        `;
        $('#form-pembina').hide(1000);
        $('#table-pembina').show(1000);
        $('#title-pembina').html('<i class="icon-copy dw dw-user-2 mr-2"></i>Daftar Pembina');

        document.getElementById('container-btn').innerHTML = html;
    }

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

    const deletePembina = (id_pembina) => {
        let url = "/ormawa/settings/profile/pembina/"+id_pembina;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Pembina',
            'Apakah anda yakin ingin menghapus?',
            'Yes',
            'No',
        function(){ 
            $.ajax(
                {
                    url: url,
                    type: 'delete', 
                    dataType: "JSON",
                    data: {
                        "id_pembina": id_pembina
                    },
                    success: function (response){
                        console.log(response.status); 
                        if(response.status == 1){
                            Notiflix.Notify.Success(response.message);
                            $('#tr_' + id_pembina).remove();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Notiflix.Notify.Failure('Ooopss');
                    }
            });
        }, function(){
                // No button callback alert('If you say so...'); 
        } ); 
    }
</script>

@endpush