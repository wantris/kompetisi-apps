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

@php
$eiJson = json_encode($ei);
@endphp
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="card mb-2">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        @if (Session::get('is_pembina') == "0")
                        <a class="nav-link active text-orange" data-toggle="tab" href="#update-event" role="tab"
                            aria-selected="true">Update Event</a>
                        @else
                        <a class="nav-link active text-orange" data-toggle="tab" href="#update-event" role="tab"
                            aria-selected="true">Detail Event</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-orange" data-toggle="tab" href="#detail-event" role="tab"
                            aria-selected="false">Pengajuan Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-orange" data-toggle="tab" href="#berkas-event" role="tab"
                            aria-selected="false">Berkas Event</a>
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
                                <p class="h5 text-orange" id="title-pembina"><i
                                        class="icon-copy dw dw-user-2 mr-2"></i>{{$title}}
                                </p>
                            </div>
                            <div class="col-6 text-right">
                                <div id="container-btn">
                                    <a href="{{route('ormawa.eventinternal.index')}}" id="tambah-btn"
                                        class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                        Kembali</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="ormawa-banner_inp_profil shadow-sm mb-1">
                                    <img data-filename="{{$eiJson}}"
                                        src="{{url('assets/img/banner-komp/'.$ei->banner_image)}}" id="banner-image"
                                        style="width: 100%" alt="" class="img-fluid">
                                </div>
                                <div id="btn-hapus-container_banner" class="mt-2">

                                </div>
                            </div>
                            <div class="col-lg-8 col-12">
                                <form action="{{route('ormawa.eventinternal.update', $ei->id_event_internal)}}"
                                    enctype="multipart/form-data" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="form-group">
                                        <label for="">Nama Event</label>
                                        <input type="text" name="event_title" class="form-control"
                                            value="{{$ei->nama_event}}" id="">
                                        @if ($errors->has('event_title'))
                                        <span class="text-danger">{{ $errors->first('event_title') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Ketegori Event</label>
                                        <select name="kategori" class="form-control" id="">
                                            @foreach ($kategoris as $kategori)
                                            @if ($ei->kategori_id == $kategori->id_kategori)
                                            <option selected value="{{$kategori->id_kategori}}">
                                                {{$kategori->nama_kategori}}</option>
                                            @else
                                            <option value="{{$kategori->id_kategori}}">{{$kategori->nama_kategori}}
                                            </option>
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
                                            <option selected value="{{$tipe->id_tipe_peserta}}">{{$tipe->nama_tipe}}
                                            </option>
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
                                        <input type="text" name="maks" class="form-control"
                                            value="{{$ei->maks_participant}}" id="">
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
                                        <input type="date" name="tgl_buka" class="form-control"
                                            value="{{$ei->tgl_buka}}" id="">
                                        @if ($errors->has('tgl_buka'))
                                        <span class="text-danger">{{ $errors->first('tgl_buka') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tanggal Penutupan</label>
                                        <input type="date" name="tgl_tutup" class="form-control"
                                            value="{{$ei->tgl_tutup}}" id="">
                                        @if ($errors->has('tgl_tutup'))
                                        <span class="text-danger">{{ $errors->first('tgl_tutup') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi-inp" cols="30"
                                            rows="10">{!!$ei->deskripsi!!}</textarea>
                                        @if ($errors->has('deskripsi'))
                                        <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Ketentuan</label>
                                        <textarea name="ketentuan" id="ketentuan-inp" cols="30"
                                            rows="10">{!!$ei->ketentuan!!}</textarea>
                                        @if ($errors->has('ketentuan'))
                                        <span class="text-danger">{{ $errors->first('ketentuan') }}</span>
                                        @endif
                                    </div>
                                    @if (Session::get('is_pembina') == "0")
                                    <div class="form-group">
                                        <label for="">Banner Event</label>
                                        <input type="file" name="banner" onchange="previewBannerImage()"
                                            class="form-control" id="banner-inp">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Poster Event</label>
                                        <input type="file" name="poster" onchange="previewPosterImage()"
                                            class="form-control" id="poster-inp">
                                    </div>
                                    <input type="hidden" name="oldBanner" value="{{$ei->banner_image}}">
                                    <input type="hidden" name="oldPoster" value="{{$ei->poster_image}}">

                                    <input type="submit" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important"
                                        value="Submit">
                                    @endif
                                </form>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="border mb-3 ormawa-banner_inp_profil shadow-sm px-4 py-4 mt-2">
                                    <img data-filename="{{$eiJson}}"
                                        src="{{url('assets/img/kompetisi-thumb/'.$ei->poster_image)}}" id="poster-image"
                                        style="width: 100%" alt="" class="img-fluid">
                                </div>
                                <div id="btn-hapus-container_poster" class="mt-2">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="detail-event" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="h5 text-orange" id="title-pembina"><i
                                        class="icon-copy dw dw-user-2 mr-2"></i>Status Validasi {{$ei->nama_event}}
                                </p>
                            </div>
                            <div class="col-6 text-right">
                                <div id="container-btn">
                                    <a href="{{route('ormawa.eventinternal.index')}}" id="tambah-btn"
                                        class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                        Kembali</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>
                        <div class="col-12">
                            <form action="{{route('ormawa.eventinternal.validasi.pembina')}}" method="post">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="id_eid"
                                    value="{{$ei->pengajuanRef->id_event_internal_detail}}">
                                <div class="form-group">
                                    <label for="">Sudah Divalidasi Pembina</label>
                                    <select name="status" @if (Session::get('is_pembina')=="0" ) disabled @endif id=""
                                        class="form-control">
                                        @if ($ei->pengajuanRef->is_validated_pembina == 1)
                                        <option selected value="{{$ei->pengajuanRef->is_validated_pembina}}">Sudah
                                        </option>
                                        <option value="0">Belum</option>
                                        @else
                                        <option selected value="{{$ei->pengajuanRef->is_validated_pembina}}">Belum
                                        </option>
                                        <option value="1">Sudah</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Sudah Divalidasi Wadir 3</label>
                                    <select disabled id="" class="form-control">
                                        @if ($ei->pengajuanRef->is_validated_wadir3 == 1)
                                        <option selected value="{{$ei->pengajuanRef->is_validated_wadir3}}">Sudah
                                        </option>

                                        @else
                                        <option selected value="{{$ei->pengajuanRef->is_validated_wadir3}}">Belum
                                        </option>

                                        @endif
                                    </select>
                                </div>
                                @if (Session::get('is_pembina')=="1")
                                <div class="form-group">
                                    <input type="submit" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important"
                                        value="Submit">
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="berkas-event" role="tabpanel">
                    <div class="card-body">
                        <div class="row clearfix">
                            <div class="col-md-3 col-sm-12 ">
                                <ul class="nav flex-column vtabs nav-tabs customtab" style="width: 100%" role="tablist">
                                    <li class="nav-item mb-4 text-center">
                                        <a class="nav-link active py-2" data-toggle="tab" href="#pengajuan" role="tab"
                                            aria-selected="true">Berkas Pengajuan</a>
                                    </li>
                                    <li class="nav-item text-center">
                                        <a class="nav-link py-2" data-toggle="tab" href="#pendaftaran" role="tab"
                                            aria-selected="false">Berkas Pendaftaran</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-9 col-sm-12">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="pengajuan" role="tabpanel">
                                        <div class="pd-20">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="h5 text-orange" id="title-pembina"><i
                                                            class="icon-copy dw dw-file mr-2"></i>Berkas Pengajuan
                                                    </p>
                                                </div>
                                                <div class="col-6 text-right">
                                                    @if (Session::get('is_pembina')=="0" )
                                                    <div id="container-btn">
                                                        <a onclick="uploadPengajuan({{$eiJson}})"
                                                            data-values="{{$eiJson}}" type="button"
                                                            id="tambah-pengajuan-btn"
                                                            class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2 text-white"
                                                            style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                                            Tambah</a>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="col-12">
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    @foreach ($feips as $feip)
                                                    <div class="row mb-4"
                                                        id="tr_pengajuan_{{$feip->id_file_event_internal_detail }}">
                                                        <div class="col-10">
                                                            <div class="py-2 px-2"
                                                                style="width:100%; border-bottom:1px solid #fb8c00 !important;">
                                                                {{$feip->nama_file}}
                                                            </div>
                                                        </div>
                                                        @php
                                                        $pengajuanJson = json_encode($feip);
                                                        @endphp
                                                        <div class="col-2 pt-2">
                                                            <a data-toggle="collapse"
                                                                href="#collapseExample_{{$feip->id_file_event_internal_detail }}"
                                                                role="button" aria-expanded="false"
                                                                aria-controls="collapseExample"
                                                                class="text-orange d-inline mr-2"
                                                                style="font-size:22px"><i
                                                                    class="icon-copy dw dw-eye"></i></a>
                                                            @if (Session::get('is_pembina')=="0" )
                                                            <a href="#"
                                                                onclick="hapusBerkas({{$pengajuanJson}},'pengajuan')"
                                                                class="text-orange d-inline" style="font-size:22px"><i
                                                                    class="icon-copy dw dw-trash1"></i></a>
                                                            @endif
                                                        </div>
                                                        <div class="collapse col-12 mt-3"
                                                            id="collapseExample_{{$feip->id_file_event_internal_detail }}">
                                                            <div style="width: 100%; height:400px"
                                                                class="pengajuan-container border"
                                                                data-id="{{$feip->id_file_event_internal_detail}}"
                                                                data-filename="{{$feip->filename}}"
                                                                id="pengajuan_container_{{$feip->id_file_event_internal_detail}}">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pendaftaran" role="tabpanel">
                                        <div class="pd-20">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="h5 text-orange" id="title-pembina"><i
                                                            class="icon-copy dw dw-file mr-2"></i>Berkas Kebtuhan
                                                        Pendaftaran
                                                    </p>
                                                </div>
                                                <div class="col-6 text-right">
                                                    @if (Session::get('is_pembina')=="0" )
                                                    <div id="container-btn">
                                                        <a onclick="uploadPendaftaran({{$eiJson}})"
                                                            data-values="{{$eiJson}}" type="button"
                                                            id="tambah-pengajuan-btn"
                                                            class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2 text-white"
                                                            style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                                            Tambah</a>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="col-12">
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    @foreach ($feids as $feid)
                                                    <div class="row mb-4"
                                                        id="tr_pendaftaran_{{$feid->id_file_event_internal_detail }}">
                                                        <div class="col-10">
                                                            <div class="py-2 px-2"
                                                                style="width:100%; border-bottom:1px solid #fb8c00 !important;">
                                                                {{$feid->nama_file}}
                                                            </div>
                                                        </div>
                                                        <div class="col-2 pt-2">
                                                            <a target="_blank"
                                                                href="{{url('assets/file/dokumen-event/'.$feid->filename)}}"
                                                                class="text-orange d-inline mr-2" title="Download"
                                                                style="font-size:22px"><i
                                                                    class="icon-copy dw dw-download"></i></a>
                                                            @php
                                                            $pendaftaranJson = json_encode($feid);
                                                            @endphp
                                                            @if (Session::get('is_pembina')=="0" )
                                                            <a href="#"
                                                                onclick="hapusBerkas({{$pendaftaranJson}},'pendaftaran')"
                                                                class="text-orange d-inline" title="Hapus"
                                                                style="font-size:22px"><i
                                                                    class="icon-copy dw dw-trash1"></i></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endforeach
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
    </div>
</div>

{{-- Modal upload pengajuan --}}
<div class="modal fade" id="upload-pengajuan-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="berkas-upload-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{route('ormawa.eventinternal.save.pengajuan')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Berkas</label>
                        <input type="text" disabled id="keterangan-text" class="form-control">
                        <input type="hidden" name="keterangan" id="keterangan-inp">
                        <input type="hidden" name="id_event" id="id-inp">
                    </div>
                    <div class="form-group">
                        <label for="">Berkas</label>
                        <input type="file" name="berkas" id="" class="form-control">
                        @if ($errors->has('berkas'))
                        <span class="text-danger">{{ $errors->first('berkas') }}</span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal upload berkas pendaftaran --}}
<div class="modal fade" id="upload-pendaftaran-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="pendaftaran-upload-title">Upload Berkas Keperluan Pendaftaran
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{route('ormawa.eventinternal.save.pendaftaran')}}" enctype="multipart/form-data"
                method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Keterangan Berkas</label>
                                <input type="text" name="keterangan_pendaftaran" class="form-control">
                                <input type="hidden" name="id_event" id="id-event-inp">
                                @if ($errors->has('keterangan_pendaftaran'))
                                <span class="text-danger">{{ $errors->first('keterangan_pendaftaran') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Berkas</label>
                                <input type="file" name="berkas_pendaftaran" class="form-control">
                                @if ($errors->has('berkas_pendaftaran'))
                                <span class="text-danger">{{ $errors->first('berkas_pendaftaran') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ url('assets/ckeditor/ckeditor.js') }}"></script>
<script src="https://unpkg.com/pdfobject@2.2.5/pdfobject.min.js"></script>

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

    const uploadPengajuan = (values) => {
        $('#upload-pengajuan-modal').modal('show');
        $('#berkas-upload-title').text('Upload Pengajuan '+values.nama_event);
        $('#keterangan-text').val('Berkas Pengajuan '+values.nama_event);
        $('#keterangan-inp').val('Berkas Pengajuan '+values.nama_event);
        $('#id-inp').val(values.id_event_internal);
    } 

    const uploadPendaftaran = (values) => {
        $('#upload-pendaftaran-modal').modal('show');
        $('#id-event-inp').val(values.id_event_internal);
    }

    if(PDFObject.supportsPDFs){
        console.log("Yay, this browser supports inline PDFs.");
    } else {
        Notiflix.Notify.Failure("Harap matikan capture download Internet Download Manager");
    }

    // var status = (PDFObject.supportsPDFs) ? "supports" : "does not support";
    

    $('.pengajuan-container').each(function(){
        let id = $(this).data('id');
        let url = "/assets/file/pengajuan_event/" + $(this).data('filename');
        let container = "#pengajuan_container_"+id;
        PDFObject.embed(url, container);
    });

    const previewBannerImage = () => {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("banner-inp").files[0]);
        oFReader.onload = (oFREvent) =>  {
                document.getElementById("banner-image").src = oFREvent.target.result;
        };

        let html = `
            <a id="hapus-banner" onclick="hapusBanner()" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2 text-white"
                style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                <i class="icon-copy dw dw-trash1"></i></a>
        `;
        $('#btn-hapus-container_banner').html(html);
    };

    const previewPosterImage = () => {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("poster-inp").files[0]);
        oFReader.onload = (oFREvent) =>  {
                document.getElementById("poster-image").src = oFREvent.target.result;
        };

        let html = `
            <a id="hapus-poster" onclick="hapusPoster()" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2 text-white"
                style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                <i class="icon-copy dw dw-trash1"></i></a>
        `;
        $('#btn-hapus-container_poster').html(html);
    };

    const hapusPoster = () => {
        let value = $('#poster-image').data('filename');
        console.log(value);
        let url = "/assets/img/kompetisi-thumb/"+value.poster_image;

        $("#poster-image").attr("src", url);
        $('#poster-inp').val('');
        // $('.custom-file-label').html(fileName);
        $('#btn-hapus-container_poster').html(''); 
    }

    const hapusBanner = () => {
        let value = $('#banner-image').data('filename');
        console.log(value);
        let url = "/assets/img/banner-komp/"+value.banner_image;

        $("#banner-image").attr("src", url);
        $('#banner-inp').val('');
        // $('.custom-file-label').html(fileName);
        $('#btn-hapus-container_banner').html(''); 
    }

    const hapusBerkas = (values, type) => {
        let url = "";
        let remove = "";
        if(type == "pendaftaran"){
            url = "/ormawa/eventinternal/pendaftaran/detele/"+values.id_file_event_internal_detail ;
            remove = $('#tr_pendaftaran_' + values.id_file_event_internal_detail);
        }else{
            url = "/ormawa/eventinternal/pengajuan/detele/"+values.id_file_event_internal_detail ;
            remove = $('#tr_pengajuan_' + values.id_file_event_internal_detail);
        }
        
        console.log(url);
        event.preventDefault();
        Notiflix.Confirm.Show( 
            values.nama_file,
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
                        "id_berkas": values.id_file_event_internal_detail
                    },
                    success: function (response){
                        console.log(response.status); 
                        if(response.status == 1){
                            Notiflix.Notify.Success(response.message);
                            remove.remove();
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



@if ($errors->has('berkas'))
<script>
    let values = $('#tambah-pengajuan-btn').data('values');
        uploadPengajuan(values);
</script>
@endif

@if ($errors->has('berkas_pendaftaran') || $errors->has('keterangan_pendaftaran'))
<script>
    let values = $('#tambah-pendaftaran-btn').data('values');
        uploadPendaftaran(values);
</script>
@endif


@endpush