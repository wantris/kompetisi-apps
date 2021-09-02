@extends('template')

@section('title', 'Buat Event')

@push('cs-css')
<style>
    /* Tabs*/

    .section-title {
        text-align: center;
        color: #007b5e;
        margin-bottom: 50px;
        text-transform: uppercase;
    }

    #tabs {
        margin-top: 100px;
    }

    #tabs h6.section-title {
        color: #000000;
    }

    #tabs .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        color: #007AFF !important;
        background-color: transparent;
        border-color: #007AFF;
        border-bottom: 4px solid #007AFF !important;
        font-size: 20px;
        font-weight: bold;
    }

    #tabs .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
        color: #000000;
        font-size: 20px;
    }

    #komp-title_inp {
        border-style: none;
    }

    #pilih-kategori:hover {
        color: #fb8c00;
    }


    .button-type:hover {
        color: #fb8c00;
        border: 1px solid #fb8c00;
    }

    .button-type {
        margin: 5px 5px 0 0;
        padding: 8px 15px;
        color: #9f9f9f;
        border: 1px solid #d8d8d8;
        border-radius: 40px;
        text-transform: capitalize;
        font-size: .775rem;
        background: #fff;
    }

    .button-type-selected {
        background-color: #fb8c00 !important;
        color: #fff !important;
        border: 1px solid #fb8c00 !important;
    }

    .button-peserta:hover {
        color: #fb8c00;
        border: 1px solid #fb8c00;
    }

    .button-peserta {
        margin: 5px 5px 0 0;
        padding: 8px 15px;
        color: #9f9f9f;
        border: 1px solid #d8d8d8;
        border-radius: 40px;
        text-transform: capitalize;
        font-size: .775rem;
        background: #fff;
    }

    .button-peserta-selected {
        background-color: #fb8c00 !important;
        color: #fff !important;
        border: 1px solid #fb8c00 !important;
    }

    .button-category:hover {
        color: #fb8c00;
        border: 1px solid #fb8c00;
    }

    .button-category {
        margin: 5px 5px 0 0;
        padding: 8px 15px;
        color: #9f9f9f;
        border: 1px solid #d8d8d8;
        border-radius: 40px;
        text-transform: capitalize;
        font-size: .775rem;
        background: #fff;
    }

    .button-category-selected {
        background-color: #fb8c00 !important;
        color: #fff !important;
        border: 1px solid #fb8c00 !important;
    }


    .btn-save-category {
        width: 100%;
        background-color: #e86b32;
        color: #fff;
        border: 1px solid transparent;
        padding: auto 20px !important;
        font-size: .875rem;
        line-height: 38px;
    }

    #peserta-text:hover {
        color: #777575 !important;
        text-decoration: none !important;
    }


    .input-modal {
        border-top-style: hidden;
        border-left-style: hidden;
        border-right-style: hidden;
        width: 100%;
    }

    .input-modal:focus {
        border-color: #fb8c00;
    }

    .detail-komp__verified:hover {
        color: #007AFF;
    }

    .tooltip-inner {
        background-color: red !important;
    }
</style>

@endpush


@section('content')
<!-- Hero Area Start-->
<div class="slider-area ">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" id="banner-img-event"
        data-background="{{url('assets/img/banner/banner-upload.png')}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2><a href="#" onclick="uploadBanner()"><i class="fas fa-plus-circle"></i></a></h2>
                        <h3 class="text-white" style="font-szie:12px !important">Unggah gambar/banner</h3>
                        <h5 class="text-white">Direkomendasikan 724 x 340px dan tidak lebih dari 2MB</h5>
                        <h5 class="text-white bg-danger" id="banner-error-text"></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero Area End -->


<div class="main-detail__sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-detil__komp">
                            <div class="card-body px-5">
                                <div class="row">
                                    <div class="col-lg-3 px-3 py-3 border-bottom text-center">
                                        <img src="{{url('assets/img/ormawa-logo/'.$ormawa->photo)}}"
                                            class="img-fluid detail-komp__image" alt="Responsive image">
                                    </div>
                                    <div class="col-lg-9 border-bottom">
                                        <h1 class="detail-komp__title red-tooltip mt-4"><input type="text"
                                                onkeyup="changeText()" id="komp-title_inp" style="width: 100%" placeholder="Nama Event*">
                                        </h1>
                                        <h2 class="detail-komp__category" id="div-category"><a href="#"
                                                data-toggle="modal" data-target="#category-modal" type="button"
                                                id="pilih-kategori" style="text-decoration: none;">Pilih Kategori</a>
                                        </h2>
                                        <div class="mt-4">
                                            <a href="#" class="detail-komp__const float-left" data-toggle="modal"
                                                data-target="#peserta-modal" type="button" id="peserta-text">0/0
                                                Peserta</a>
                                            <a class="detail-komp__verified float-right" style="text-decoration: none !important" href="#">Belum Tervalidasi</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-4">
                                        <div class="detail-komp__ormawa text-left">
                                            <h1>Diselenggarakan Oleh</h1>
                                        </div>
                                        <div class="detail-komp__ormawa-desc mt-4 text-left">
                                            <h2><a href="{{route('ormawa.index','HIMATIF')}}"
                                                    style="text-decoration: none !important">HIMATIF</a></h2>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="detail-komp__ormawa text-left">
                                            <h1>Tanggal & Batas Peserta</h1>
                                        </div>
                                        <div class="detail-komp__ormawa-date text-secondary mt-4 text-left">
                                            <a href="#" class="text-secondary" id="pilih-tanggal" data-toggle="modal"
                                                data-target="#date-modal" type="button">Pilih Tanggal</a>
                                        </div>
                                        <div class="detail-komp__ormawa-const text-left mt-3 mb-3">
                                            <a href="#" class="text-secondary" id="peserta-text2">100 peserta</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="detail-komp__ormawa text-left">
                                            <h1>Jenis Event</h1>
                                        </div>
                                        <div class="detail-komp__ormawa-type text-left mt-4">
                                            <a href="#" class="text-secondary" id="jenis-text" data-toggle="modal"
                                                data-target="#jenis-modal" type="button">Pilih jenis Event</a>
                                        </div>
                                        <div class="detail-komp__ormawa-peserta text-left mt-4">
                                            <a href="#" class="text-secondary" id="jenis-peserta" data-toggle="modal"
                                                data-target="#jenis-peserta-modal" type="button">Tipe Peserta</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- form group --}}
                <form action="{{route('ormawa.eventinternal.save')}}" enctype="multipart/form-data" id="form-all"
                    method="post">
                    <!-- Tabs Event -->
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <section id="tabs">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-12 col-lg-12">
                                            <nav>
                                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link active" id="nav-home-tab"
                                                        data-toggle="tab" href="#nav-home" role="tab"
                                                        aria-controls="nav-home" aria-selected="true">Deskripsi</a>
                                                    <a class="nav-item nav-link" id="nav-syarat-tab" data-toggle="tab"
                                                        href="#nav-syarat" role="tab" aria-controls="nav-syarat"
                                                        aria-selected="false">Syarat & Ketentuan</a>
                                                    <a class="nav-item nav-link" id="nav-dokumen-tab" data-toggle="tab"
                                                        href="#nav-dokumen" role="tab" aria-controls="nav-dokumen"
                                                        aria-selected="false">Dokumen</a>
                                                </div>
                                            </nav>
                                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                                    aria-labelledby="nav-home-tab">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <textarea class="form-control" id="deskripsi-inp"
                                                                name="deskripsi"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="nav-syarat" role="tabpanel"
                                                    aria-labelledby="nav-syarat-tab">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <textarea class="form-control" id="syarat-inp"
                                                                name="ketentuan"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="nav-dokumen" role="tabpanel"
                                                    aria-labelledby="nav-dokumen-tab">
                                                    <div class="row mt-2">
                                                        <div class="col-12">
                                                            <h5 class="text-dark font-weight-bold float-left">Dokumen
                                                                Event</h5>
                                                            <a href="#" onclick="addUploadRow()"
                                                                class="float-right btn btn-primary"
                                                                title="Tambah dokumen" style="padding: 10px 10px">+</a>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-lg-1">
                                                            <a href="" class="float-right btn"
                                                                style="background-color: #fb8c00;padding: 10px 10px"
                                                                title="Tambah dokumen">-</a>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="nama_dokumen[]"
                                                                placeholder="Nama Dokumen" class="inp-dokumen"
                                                                style="width:100%" id="">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text" placeholder="Format .pdf, .docx, .zip"
                                                                class="inp-dokumen" disabled style="width:100%"
                                                                id="nama_file_1">
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <a href="#" class="float-right btn" onclick="uploadFile(1)"
                                                                style="background-color: #fb8c00;padding: 20px 30px"
                                                                title="Tambah dokumen">Upload</a>
                                                            <input type="file" class="d-none" id="file_dokumen_1"
                                                                name="file_dokumen[]">
                                                        </div>
                                                    </div>
                                                    <div id="dokumen-div">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
            </div>
            <div class="col-lg-4" id="div-poster">
                <div class="card shadow-sm" id="poster-bg-upload">
                    <a href="#" id="poster-upload" onclick="posterUpload()"><i class="fas fa-plus-square"></i></a>
                    <a href="#" class="bg-danger text-white mt-5 px-2" style="font-size: 16px" id="poster-error-text"></a>
                </div>
            </div>
        </div>
        <div class="row mt-5 ">
            <div class="col-12">
                <div class="detail-komp__footer ">
                    <div class="row">
                        <div class="col-lg-1 col-md-2 text-right col-6 pt-2 d-none d-md-block d-lg-block">
                            <img src="{{url('assets/img/adapt_icon/medal.svg')}}" class="medal-icon" alt="">
                        </div>
                        <div class="col-lg-7 col-md-6 col-6 d-none d-md-block d-lg-block">
                            <h1 class="detail-komp__footer-title">Nama Event</h1>
                            <h2 class="detail-komp__footer-status">Belum Ada Pendaftar </h2>
                        </div>
                        <div class="col-6 d-lg-none d-xl-none d-md-none text-left">
                            <p class="text-white font-weight-bold">Nama Event</p>
                        </div>
                        <div class="col-6 d-lg-none d-xl-none d-md-none text-right">
                            <p class="text-white font-weight-bold">HIMATIF</p>
                        </div>
                        <div class="col-lg-4 col-md-12 col-12 text-center mt-5 d-none d-md-none d-lg-block">
                            <a href="#" onclick="submitForm()" class="detail-komp__footer-btn">
                                Simpan
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-12 col-12 text-center mt-2 d-block d-md-none d-lg-none ">
                            <a href="#" onclick="submitForm()" style="display:inline-block;
                            width: 100%;" class="detail-komp__footer-btn">
                                Simpan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<input type="file" class="d-none" name="banner" id="banner-inp">
<input type="file" class="d-none" name="poster" onchange="previewPosterImage()" id="poster-inp">
<input type="text" class="d-none" name="event_title" id="event-title-inp">
<input type="text" class="d-none" name="peserta" id="peserta-inp">
<input type="text" class="d-none" name="category" id="category-inp">
<input type="text" class="d-none" name="tgl_mulai" id="tgl-mulai-inp">
<input type="text" class="d-none" name="tgl_tutup" id="tgl-tutup-inp">
<input type="text" class="d-none" name="jenis" id="jenis-inp">
<input type="text" class="d-none" name="jenis_peserta" id="jenis-peserta-inp">
<input type="submit" value="submit" class="d-none" id="form-submit">


{{-- modal inp --}}

{{-- kategori modal --}}
<div class="modal fade" id="category-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none">
                <h5 class="modal-title" id="myLargeModalLabel">Kategori<span class="text-orange">*</span></h5>
                <button type="button" class="close" data-dismiss="modal" onclick="discardCategory()"
                    aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach ($kategoris as $kategori)
                    <div class="col-4">
                        <button type="button" class="button-category" id="btn_kategori_{{$kategori->id_kategori}}"
                            style="width: 100%" onclick="chooseCategory({{$kategori->id_kategori}})"
                            data-value="{{$kategori->nama_kategori}}">{{$kategori->nama_kategori}}</button>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="saveCategory()" class="btn-save-category">Save changes</button>
            </div>
        </div>
    </div>
</div>

{{-- peserta modal --}}
<div class="modal fade" id="peserta-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header px-4" style="border-bottom: none">
                <h5 class="modal-title" id="myLargeModalLabel">Jumlah Peserta<span class="text-orange">*</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body px-4">
                <div class="form-group">
                    <label for="">Jumlah peserta maksimum</label>
                    <div class="d-block">
                        <input type="text" class="input-modal" id="peserta-inp-modal" placeholder="Jumlah">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="savePeserta()" class="btn-save-category">Save changes</button>
            </div>
        </div>
    </div>
</div>

{{-- tanggal modal --}}
<div class="modal fade" id="date-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header px-4" style="border-bottom: none">
                <h5 class="modal-title" id="myLargeModalLabel">Tanggal Pendaftaran<span class="text-orange">*</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body px-4">
                <div class="form-group">
                    <label for="">Tanggal Mulai </label>
                    <div class="d-block mt-2">
                        <input type="date" class="input-modal" id="tgl-mulai-modal">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="">Tanggal Penutupan</label>
                    <div class="d-block mt-2">
                        <input type="date" class="input-modal" id="tgl-tutup-modal">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="saveTanggal()" class="btn-save-category">Save changes</button>
            </div>
        </div>
    </div>
</div>

{{-- jenis modal --}}
<div class="modal fade" id="jenis-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none">
                <h5 class="modal-title" id="myLargeModalLabel">Jenis event<span class="text-orange">*</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <button type="button" class="button-type" style="width: 100%" onclick="chooseType('Individu')"
                            data-value="Individu">Individu</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="button-type" style="width: 100%" onclick="chooseType('Team')"
                            data-value="Team">Team</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="saveType()" class="btn-save-category">Save changes</button>
            </div>
        </div>
    </div>
</div>

{{-- jenis Peserta modal --}}
<div class="modal fade" id="jenis-peserta-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none">
                <h5 class="modal-title" id="myLargeModalLabel">Jenis Peserta<span class="text-orange">*</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach ($tipes as $tipe)
                    <div class="col-4">
                        <button type="button" id="tipe_peserta_{{$tipe->id_tipe_peserta}}" class="button-peserta"
                            style="width: 100%" onclick="choosePeserta('{{$tipe->id_tipe_peserta}}')"
                            data-value="{{$tipe->nama_tipe}}">{{$tipe->nama_tipe}}</button>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="saveJenisPeserta()" class="btn-save-category">Save changes</button>
            </div>
        </div>
    </div>
</div>

{{-- Perijinan modal --}}
<div class="modal fade" id="berkas-perijinan-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none">
                <h5 class="modal-title" id="myLargeModalLabel">Berkas Perijinan<span class="text-orange">*</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body px-4">
                <div class="form-group mt-3">
                    <label for="">Upload Berkas Perijinan</label>
                    <div class="d-block mt-2">
                        <input type="file" class="form-control" name="berkas_perijinan">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="savePerijian()" class="btn-save-category">Save changes</button>
            </div>
        </div>
    </div>
</div>

</form>


@endsection

@push('cs-script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ url('assets/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace( 'deskripsi-inp');
    CKEDITOR.replace( 'syarat-inp');
</script>

<script>
    // submit form
    const submitForm = () => {
        event.preventDefault();
        $("#form-all").submit();
    }

    // func for trigger banner file input
    const uploadBanner = () => {
        event.preventDefault();
        $('#banner-inp').trigger('click');
    };

    $('#banner-inp').change(function () {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onloadend = function () {
               $('#banner-img-event').css('background-image', 'url("' + reader.result + '")');
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
            }
    });

    // upload poster
    const posterUpload = () => {
        event.preventDefault();
        $('#poster-inp').trigger('click');
        return false;
    } 

    const previewPosterImage = () => {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("poster-inp").files[0]);

        if(!$('#div-poster').hasClass('selected-poster')){
            renderPreviewPoster(oFReader);
            $('#div-poster').addClass('selected-poster');
        }else{
            oFReader.onload = (oFREvent) =>  {
                document.getElementById("img-poster").src = oFREvent.target.result;
            };
        }
    };

    const renderPreviewPoster = (oFReader) => {
        oFReader.onload = (oFREvent) =>  {
            var html = `
                <div class="card shadow-sm">
                    <div class="card-body px-0 py-0">
                        <img src="" id="img-poster" alt="" class="img-fluid">
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn float-left" onclick="posterUpload()" style="padding: 10px 10px;background-color: #327657" title="Ganti Poster"><i class="fas fa-undo"></i></a>
                        <a href="#" class="btn float-right" onclick="removeImgPoster()"  style="padding: 10px 10px;background-color:red" title="Hapus Poster"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            `;
            document.getElementById("div-poster").innerHTML = html;
            document.getElementById("img-poster").src = oFREvent.target.result;
        };
    }

    const removeImgPoster = () => {
        event.preventDefault();
        let html = `
            <div class="card shadow-sm" id="poster-bg-upload">
                <a href="#" id="poster-upload" onclick="posterUpload()"><i class="fas fa-plus-square"></i></a>
            </div>
        `;
        $("#poster-inp").val(null);
        $('#div-poster').removeClass('selected-poster');
        document.getElementById("div-poster").innerHTML = html;
        
    }
            
    // Title event
    const changeText = () => {
        let value = $('#komp-title_inp').val();
        console.log(value);
        if(value.length != 0 ){
            $('#event-title-inp').val(value);
            $('.detail-komp__footer-title').text(value);

        }else{
            $('#event-title-inp').val();
            $('.detail-komp__footer-title').text('Nama Event');
        }   
    }

    const savePerijian = () => {
        $('#berkas-perijinan-modal').modal('hide');
    }


    // Input Category
    let tmpCategoryValue = "";
    let categoryValue = "";
    let categoryId = "";

    const chooseCategory = (value) => {
        let valueText = "";
        categoryId = value;
        valueText = $('#btn_kategori_'+value).data('value');
        tmpCategoryValue = valueText;
        toggleCategoryFunc();
    }

    const toggleCategoryFunc = () => {
        $('.button-category').each(function () {
            if(tmpCategoryValue === $(this).data('value')){
                $(this).addClass('button-category-selected');
            }else{
                $(this).removeClass('button-category-selected');
            }
        });
    }

    const saveCategory = () => {
        categoryValue = tmpCategoryValue;
        $('#category-inp').val(categoryId);
        $('#pilih-kategori').text(categoryValue);
        $('#category-modal').modal('hide');
    }


    // const discardCategory = () => {
    //     TmpCategoryValues = [];

    //     if(categoryValues.length !== 0){
    //         console.log(categoryValues.length);
    //         $('#pilih-kategori').text(categoryValues.join(', '));
    //         $('.button-category').each(function () {
    //             $(this).removeClass('button-category-selected');
    //         });
    //     }else{
    //         console.log(categoryValues);
    //         $('#pilih-kategori').text('Pilih Kategori');
    //     }
        
    // }


    // peserta inp
    const savePeserta = () => {
       let valPeserta =  $('#peserta-inp-modal').val();
       if(valPeserta){
           $('#peserta-text').text('0/'+valPeserta+' peserta');
           $('#peserta-text2').text(valPeserta+' peserta');
           $('#peserta-inp').val(valPeserta);
       }
       $("#peserta-modal").modal('hide');
    };


    // Tanggal input
    let tglMulaiTxt = "";
    let tglTutupTxt = "";

    const saveTanggal = () => {
        let tglMulai = $('#tgl-mulai-modal').val();
        let tglTutup = $('#tgl-tutup-modal').val();
        
        $('#tgl-mulai-inp').val(tglMulai);
        $('#tgl-tutup-inp').val(tglTutup);

        convertDateDBtoIndo(tglMulai, tglTutup);
        $("#date-modal").modal('hide');
        
    }
	
    const convertDateDBtoIndo = (tglMulai, tglTutup) => {
        bulanIndo = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep' , 'Oct', 'Nov', 'Dec'];
    
        tanggalMulai = tglMulai.split("-")[2];
        bulanMulai = tglMulai.split("-")[1];
        tahunMulai = tglMulai.split("-")[0];

        tanggalTutup = tglTutup.split("-")[2];
        bulanTutup = tglTutup.split("-")[1];
        tahunTutup = tglTutup.split("-")[0];

        tglMulaiTxt = tanggalMulai + ' ' + bulanIndo[Math.abs(bulanMulai)] + ' ' + tahunMulai;
        tglTutupTxt = tanggalTutup + ' ' + bulanIndo[Math.abs(bulanTutup)] + ' ' + tahunTutup;

        $('#pilih-tanggal').text(tglMulaiTxt + '-' + tglTutupTxt);
    }


    // Jenis input
    let TmpTypeValue = "";
    let typeValue = "";

    const chooseType = (value) => {
        TmpTypeValue = value;
        toggleFunc();
    }

    const toggleFunc = () => {
        console.log(TmpTypeValue);
        $('.button-type').each(function () {
            if(TmpTypeValue === $(this).data('value')){
                $(this).addClass('button-type-selected');
            }else{
                $(this).removeClass('button-type-selected');
            }
        });
    }

    const saveType = () => {
        typeValue = TmpTypeValue;
        $('#jenis-inp').val(typeValue);
        $('#jenis-text').text(typeValue);
        $('#jenis-modal').modal('hide');
    }


    // Jenis Peserta input
    let tmpPesertaValue = "";
    let pesertaValue = "";
    let pesertaId = "";

    const choosePeserta = (value) => {
        pesertaId = value;
        let pesertaText = $('#tipe_peserta_'+value).data('value');
        tmpPesertaValue = pesertaText;
        togglePesertaFunc();
    }

    const togglePesertaFunc = () => {
        // console.log(TmpTypeValue);
        $('.button-peserta').each(function () {
            if(tmpPesertaValue === $(this).data('value')){
                $(this).addClass('button-type-selected');
            }else{
                $(this).removeClass('button-type-selected');
            }
        });
    }

    const saveJenisPeserta = () => {
        pesertaValue = tmpPesertaValue;
        $('#jenis-peserta-inp').val(pesertaId);
        $('#jenis-peserta').text(pesertaValue);
        $('#jenis-peserta-modal').modal('hide');
    }

    // func for add row upload dokumen
    let countUpload = 1;
    const addUploadRow = () => {
        event.preventDefault();
        countUpload = countUpload + 1;
        if(countUpload > 5){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Batas Maksimum 5 Dokumen',
            });
        }else{
            let html = `
                <div class="row mt-4" id="row_dokumen_${countUpload}">
                    <div class="col-lg-1">
                        <a href="#" class="float-right btn" onclick="removeDokumen(${countUpload})" id="remove_button_${countUpload}" style="background-color: #fb8c00;padding: 10px 10px" title="Hapus dokumen">-</a>
                    </div>
                    <div class="col-lg-4">
                        <input type="text" placeholder="Nama Dokumen" name="nama_dokumen[]" class="inp-dokumen" style="width:100%" id="">
                    </div>
                    <div class="col-lg-4">
                        <input type="text" name="" placeholder="Format .pdf, .docx, .zip" class="inp-dokumen" disabled style="width:100%" id="nama_file_${countUpload}">
                    </div>
                    <div class="col-lg-3">
                        <a href="#" class="float-right btn" onclick="uploadFile(${countUpload})" id="upload_btn_${countUpload}" style="background-color: #fb8c00;padding: 20px 30px" title="Tambah dokumen">Upload</a>
                        <input type="file" id="file_dokumen_${countUpload}" name="file_dokumen[]" class="d-none">
                    </div>
                </div>
            `;
            $('#dokumen-div').append(html);
        };
    }

    // for trigger file input
    const uploadFile = (id) => {
        event.preventDefault();
        $('#file_dokumen_'+id).trigger('click');

        $('#file_dokumen_'+id).change(function(e){
            var fileValue = $(this).val();
            var fileName = e.target.files[0].name;

            regex = new RegExp('[^.]+$');
            extension = fileValue.match(regex);
            
            if(extension == "pdf" || extension == "docx" || extension == "zip"){
                $('#nama_file_'+id).val(fileName);
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Dokumen harus berformat .pdf, .docx, .zip',
                });
            }
        });
    }

    const removeDokumen = (id) => {
        countUpload = countUpload - 1;
        event.preventDefault();
        $('#remove_button_'+id).closest('#row_dokumen_'+id).remove();
    }


    // let typeValue = "";
    // $('.button-type').each(function () {
    //     if(typeValue === $(this).data('value')){
    //         $(this).addClass('button-type-selected');
    //     };
    //     // $(this).addClass('button-type-selected');
    //     // $(this).on('click', function(){
    //     //     if(typeValue != $(this).data('value')){
    //     //         typeValue = $(this).data('value');
    //     //         $(this).addClass('button-type-selected');
    //     //     };
    //     //     console.log(typeValue);
    //     // });
    //     // if(typeValue != $(this).data('value')){
    //     //     $(this).removeClass('button-type-selected');
    //     // };
       
    // });
</script>

{{-- Validation --}}
@if ($errors->has('event_title'))
<script>
    $(document).ready(function(){
            $('#komp-title_inp').tooltip('dispose').tooltip({title: "Nama Event Wajib Diisi !"}).tooltip('show');
        });
</script>
@endif

@if ($errors->has('category'))
<script>
    $(document).ready(function(){
            $('#pilih-kategori').tooltip('dispose').tooltip({title: "Pilih Kategori Event Internal"}).tooltip('show');
        });
</script>
@endif

@if ($errors->has('banner'))
<script>
    $('#banner-error-text').text('Banner Wajib Diisi !');
</script>
@endif

@if ($errors->has('poster'))
    <script>
        $('#poster-error-text').text('Poster Wajib Diisi !');
    </script>
@endif

@if ($errors->has('peserta'))
<script>
    $(document).ready(function(){
            $('.detail-komp__const').tooltip('dispose').tooltip({title: "Kuota Peserta Wajib Diisi !"}).tooltip('show');
        });
</script>
@endif

@if ($errors->has('tgl_mulai') && $errors->has('tgl_tutup'))
<script>
    $(document).ready(function(){
            $('#pilih-tanggal').tooltip('dispose').tooltip({title: "Tanggal Mulai & Tutup Pendaftaran Wajib Diisi !"}).tooltip('show');
        });
</script>
@endif

@if ($errors->has('jenis'))
<script>
    $(document).ready(function(){
            $('#jenis-text').tooltip('dispose').tooltip({title: "Jenis Event Wajib Diisi !"}).tooltip('show');
        });
</script>
@endif

@if ($errors->has('jenis_peserta'))
<script>
    $(document).ready(function(){
            $('#jenis-peserta').tooltip('dispose').tooltip({title: "Jenis Peserta Wajib Diisi !"}).tooltip('show');
        });
</script>
@endif

@if ($errors->has('deskripsi'))
<script>
    $(document).ready(function(){
            $('#jdeskripsi-inp').tooltip('dispose').tooltip({title: "Deskripsi Event Internal Wajib Diisi !"}).tooltip('show');
        });
</script>
@endif


@endpush