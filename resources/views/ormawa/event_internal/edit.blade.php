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
        <div class="card mb-2">
            <div class="card-body">
                 <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-orange" data-toggle="tab" href="#update-event" role="tab" aria-selected="true">Update Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-orange" data-toggle="tab" href="#detail-event" role="tab" aria-selected="false">Pengajuan Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-orange" data-toggle="tab" href="#berkas-event" role="tab" aria-selected="false">Berkas Event</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="update-event" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="h5 text-orange" id="title-pembina"><i class="icon-copy dw dw-user-2 mr-2"></i>{{$title}}
                                </p>
                            </div>
                            <div class="col-6 text-right">
                                <div id="container-btn">
                                    <a href="{{route('ormawa.timeline.index')}}" id="tambah-btn" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                        Kembali</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ormawa-banner_inp_profil shadow-sm mb-2">
                                    <img src="{{url('assets/img/banner-komp/'.$ei->banner_image)}}"
                                        id="banner-image" style="width: 100%" alt="" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-lg-8 col-12">
                                <form action="" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Nama Event</label>
                                        <input type="text" name="nama_event" class="form-control" value="{{$ei->nama_event}}" id="">
                                        @if ($errors->has('nama_event'))
                                            <span class="text-danger">{{ $errors->first('nama_event') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Ketegori Event</label>
                                        <select name="kategori" class="form-control" id="">
                                            @foreach ($kategoris as $kategori)
                                                @if ($ei->kategori_id == $kategori->id_kategori)
                                                    <option selected value="{{$kategori->id_kategori}}">{{$kategori->nama_kategori}}</option>
                                                @else
                                                     <option value="{{$kategori->id_kategori}}">{{$kategori->nama_kategori}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('kategori'))
                                            <span class="text-danger">{{ $errors->first('kategori') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Tipe Peserta</label>
                                        <select name="tipe_peserta" class="form-control" id="">
                                            @foreach ($tipes as $tipe)
                                                @if ($ei->tipe_peserta_id == $tipe->id_tipe_peserta)
                                                    <option selected value="{{$tipe->id_tipe_peserta}}">{{$tipe->nama_tipe}}</option>
                                                @else
                                                    <option value="{{$tipe->id_tipe_peserta}}">{{$tipe->nama_tipe}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('tipe_peserta'))
                                            <span class="text-danger">{{ $errors->first('tipe_peserta') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">Kuota Maksimal</label>
                                        <input type="text" name="maks" class="form-control" value="{{$ei->maks_participant}}" id="">
                                        @if ($errors->has('maks'))
                                            <span class="text-danger">{{ $errors->first('maks') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">Role Event</label>
                                        <select name="role" id="" class="form-control">
                                            @if ($ei->role == "Individu")
                                                <option selected value="{{$ei->role}}">{{$ei->role}}</option>
                                                <option value="Team" selected>Team</option>
                                            @else
                                                <option selected value="{{$ei->role}}">{{$ei->role}}</option>
                                                <option value="Individu" selected>Individu</option>
                                            @endif
                                        </select>
                                        @if ($errors->has('role'))
                                            <span class="text-danger">{{ $errors->first('role') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tanggal Pembukaan</label>
                                        <input type="date" name="tgl_buka" class="form-control" value="{{$ei->tgl_buka}}" id="">
                                        @if ($errors->has('tgl_buka'))
                                            <span class="text-danger">{{ $errors->first('tgl_buka') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tanggal Penutupan</label>
                                        <input type="date" name="tgl_tutup" class="form-control" value="{{$ei->tgl_tutup}}" id="">
                                        @if ($errors->has('tgl_tutup'))
                                            <span class="text-danger">{{ $errors->first('tgl_tutup') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi-inp" cols="30" rows="10">{!!$ei->deskripsi!!}</textarea>
                                        @if ($errors->has('deskripsi'))
                                            <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Ketentuan</label>
                                        <textarea name="ketentuan" id="ketentuan-inp" cols="30" rows="10">{!!$ei->ketentuan!!}</textarea>
                                        @if ($errors->has('ketentuan'))
                                            <span class="text-danger">{{ $errors->first('ketentuan') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">Banner Event</label>
                                        <input type="file" name="banner" class="form-control" id="">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Poster Event</label>
                                        <input type="file" name="poster" class="form-control" id="">
                                    </div>
                                    <input type="hidden" name="oldBanner" value="{{$ei->banner_image}}">
                                    <input type="hidden" name="oldPoster" value="{{$ei->poster_image}}">

                                    <input type="submit"  class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"  style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important" value="Submit">
                                </form>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="border mb-3 ormawa-banner_inp_profil shadow-sm px-4 py-4 mt-2">
                                        <img src="{{url('assets/img/kompetisi-thumb/'.$ei->poster_image)}}" id="profil-image"
                                            style="width: 100%" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="tab-pane fade" id="detail-event" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="h5 text-orange" id="title-pembina"><i class="icon-copy dw dw-user-2 mr-2"></i>{{$title}}
                                </p>
                            </div>
                            <div class="col-6 text-right">
                                <div id="container-btn">
                                    <a href="{{route('ormawa.timeline.index')}}" id="tambah-btn" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                        Kembali</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Sudah Divalidasi Pembina</label>
                                <select disabled id="" class="form-control">
                                    @if ($ei->pengajuanRef->is_validated_pembina == 1)
                                        <option selected value="{{$ei->pengajuanRef->is_validated_pembina}}">Sudah</option>
                                    @else
                                        <option selected value="{{$ei->pengajuanRef->is_validated_pembina}}">Belum</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Sudah Divalidasi Wadir 3</label>
                                <select disabled id="" class="form-control">
                                    @if ($ei->pengajuanRef->is_validated_wadir3 == 1)
                                        <option selected value="{{$ei->pengajuanRef->is_validated_wadir3}}">Sudah</option>
                                    @else
                                        <option selected value="{{$ei->pengajuanRef->is_validated_wadir3}}">Belum</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="berkas-event" role="tabpanel">
                    <div class="card-body">
                        <div class="row clearfix">
                            <div class="col-md-3 col-sm-12 ">
                                <ul class="nav flex-column vtabs nav-tabs customtab" style="width: 100%" role="tablist">
                                    <li class="nav-item mb-2">
                                        <a class="nav-link active" data-toggle="tab" href="#pengajuan" role="tab" aria-selected="true">Berkas Pengajuan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#pendaftaran" role="tab" aria-selected="false">Berkas Pendaftaran</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-9 col-sm-12">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="pengajuan" role="tabpanel">
                                        <div class="pd-20">
                                            
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pendaftaran" role="tabpanel">
                                        <div class="pd-20">

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

    CKEDITOR.replace( 'ketentuan-inp',{
        customConfig: '/public/assets/ckeditor/ckeditor_ormawa_profil.js'
    });

    $(document).ready( function () {
        $('#pembina-table').DataTable();
        $('#form-pembina').hide();
        $('.js-example-basic-single').select2();
    } );
</script>

@endpush