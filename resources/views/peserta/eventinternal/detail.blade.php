@extends('peserta.app')

@section('title', $slug)

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="banner-event" data-background="{{url('assets/img/banner-komp/'.$event->banner_image)}}" style="border-radius: 20px;">
                
            </div>
        </div>
    </div>
    <div class="container" style="margin-bottom: 50px">
        <div class="row">
            <div class="col-lg-2 col-sm-12 col-12 col-md-4 mb-sm-7">
                <div class="px-3 mx-auto py-3 wrapper-kelas rounded shadow minus-top logo-center wrapper-kelas-sm user-profile-picture">
                    <img src="{{url('assets/img/ormawa-logo/'.$event->ormawaRef->photo)}}" class="img-fluid" alt="{{$event->ormawaRef->nama_ormawa}}">
                </div>
            </div>
            <div class="event-description-detail" class="col-lg-9 mx-4 col-sm-7 col-md-8 pt-3 pl-xl-5 pl-lg-5 pl-sm-4">
                <div class="d-flex mt-3">
                    <h4>{{$event->nama_event}}</h4>
                </div>
                <p class="mt-2">
                    <span class="text-icon">
                        <i class="icon-copy dw dw-user-2 mr-2"></i>{{$event->ormawaRef->nama_ormawa}}
                    </span>
                </p>
                <p>
                    @php
                        $tglbuka = Carbon\Carbon::parse($event->tgl_buka)->toDatetime()->format('d M Y');
                        $tgltutup = Carbon\Carbon::parse($event->tgl_tutup)->toDatetime()->format('d M Y');
                    @endphp
                    <span class="text-icon" title="XP">
                        <i class="icon-copy dw dw-calendar-1 mr-2"></i>{{$tglbuka}} - {{$tgltutup}}
                    </span>
                </p>
                <p>
                    <span class="text-icon mr-3">
                        <i class="icon-copy dw dw-user-11 mr-2"></i>{{$event->role}}
                    </span>
                    <span class="text-icon">
                        <i class="icon-copy dw dw-user-1 mr-2"></i>0 / {{$event->maks_participant}}
                    </span>
                </p>
                
            </div>
        </div>
    </div>
    <div class="row mb-5 mt-3">
       <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30 mt-5">
                <div class="tab">
                    <div class="scrollmenu mb-4">
                        <a class="nav-link" data-toggle="tab" href="#deskripsi" role="tab" aria-selected="true">Deskripsi</a>
                        <a class="nav-link" data-toggle="tab" href="#dokumen" role="tab" aria-selected="false">Dokumen Event</a>
                        <a class="nav-link" data-toggle="tab" href="#pendaftar" role="tab" aria-selected="false">Pendaftar</a>
                        @if ($check_regis && $feeds->count() > 0)
                            <a class="nav-link" data-toggle="tab" href="#berkas-pendaftaran" role="tab" aria-selected="false">Upload Berkas</a>
                        @endif
                        
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="deskripsi" role="tabpanel">
                            <div class="pd-20">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <p class="font-weight-bold"><i class="icofont-plus-circle mr-2" style="color:#0079ff"></i>Deskripsi</p>
                                    </div>
                                    <div class="col-12 mt-1 pl-4" style="font-size: 14px">
                                        {!!$event->deskripsi!!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <p class="font-weight-bold"><i class="icofont-plus-circle mr-2" style="color:#0079ff"></i>Ketentuan</p>
                                    </div>
                                    <div class="col-12 mt-1 pl-4" style="font-size: 14px">
                                        {!!$event->ketentuan!!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="dokumen" role="tabpanel">
                            <div class="pd-20">
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">Dokumen</th>
                                        <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($feeds as $file)
                                        <tr>
                                            <td>{{$file->nama_file}}</td>
                                            <td>
                                                <a href="#" class="btn btn-primary" style="font-size: 14px !important; padding:5px 10px;background-color:#0079ff;border-color:#0079ff">Download</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pendaftar" role="tabpanel">
                            <div class="mt-4">
                                @if ($event->role == "Individu")
                                    <div class="table-responsive">
                                        <table class="data-table table stripe hover nowrap" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th class="table-plus datatable-nosort">Nama</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($registrations as $regis)
                                                    <tr>
                                                        <td>
                                                            @if ($regis->nim)
                                                                {{$regis->nama_mhs}}
                                                            @else
                                                                {{$regis->participantRef->nama_participant}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($regis->nim)
                                                                Mahasiswa Polindra
                                                            @else
                                                                Partisipan Eksternal
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="data-table table stripe hover nowrap" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th class="table-plus datatable-nosort">ID Tim</th>
                                                    <th>Ketua Tim</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($registrations as $regis)
                                                    <tr>
                                                        <td>{{$regis->tim_event_id}}</td>
                                                        <td>
                                                            @foreach ($regis->timRef->timDetailRef as $detail)
                                                                @if ($detail->role == "ketua")
                                                                    @if ($detail->nim)
                                                                        {{$detail->nama_mhs}}
                                                                    @else
                                                                        {{$detail->participantRef->nama_participant}}
                                                                    @endif
                                                                @endif
                                                            @endforeach    
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="berkas-pendaftaran" role="tabpanel">
                            <div class="row mb-2">
                                <div class="col-6">

                                </div>
                                <div class="col-6 text-right">
                                    @if ($event->role == "Team")
                                        @php
                                            $jsonRegis = json_encode($check_regis->eventInternalRegisRef);
                                        @endphp
                                    @else
                                        @php
                                            $jsonRegis = json_encode($check_regis);
                                        @endphp
                                    @endif
                                    <button class="btn btn-primary shadow" onclick="addBerkas({{$jsonRegis}})" style="font-size: 14px !important; padding:5px 10px;background-color:#0079ff;border-color:#0079ff;">Upload Berkas</button>
                                </div>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Berkas</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($check_regis)
                                        @if($event->role == "Team")
                                            @foreach ($check_regis->eventInternalRegisRef->fileEiRegisRef as $berkas)
                                                <tr>
                                                    <td>{{$berkas->filename}}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-primary" style="font-size: 14px !important; padding:5px 10px;background-color:#0079ff;border-color:#0079ff">Download</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach ($check_regis->fileEiRegisRef as $berkas)
                                                <tr>
                                                    <td>{{$berkas->filename}}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-primary" style="font-size: 14px !important; padding:5px 10px;background-color:#0079ff;border-color:#0079ff">Download</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div>
       <div class="col-lg-4 col-md-12 col-sm-12 mb-30">
            <div class="row clearfix progress-box position-sticky">
                <div class="col-lg-12 col-md-4">
                    <div class="col-12">
                        <div class="alert alert-primary">
                            @if ($check_regis)
                                Anda sudah terdaftar pada event ini
                            @else
                                Yuk daftar event {{$event->nama_event}}
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                            @if ($check_regis)
                                @if ($check_regis->eventInternalRegisRef)
                                    @if ($check_regis->eventInternalRegisRef->status == "0")
                                    <div class="alert alert-danger">
                                        Pendaftaran belum tervalidasi
                                    </div>
                                    @else
                                    <div class="alert alert-success">
                                        Pendaftaran tervalidasi
                                    </div>
                                    @endif
                                @else
                                    @if ($check_regis->status == "0")
                                    <div class="alert alert-danger">
                                        Pendaftaran belum tervalidasi
                                    </div>
                                    @else
                                    <div class="alert alert-success">
                                        Pendaftaran tervalidasi
                                    </div>
                                    @endif
                                @endif
                            @endif
                    </div>
                    <div class="col-lg-12 col-md-4 mt-3">
                        <div class="card-box text-center " style="padding: 0 !important">
                            <img src="{{url('assets/img/kompetisi-thumb/'.$event->poster_image)}}" style="border-radius: 10px" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Berkas --}}
    <div style="border: none !important" class="modal fade" id="modal-upload-berkas"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-orange" id="myLargeModalLabel"><i class="icon-copy dw dw-file mr-2"></i>Upload Berkas Pendaftaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="" id="form-upload-berkas" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Berkas Pendaftaran</label>
                            <input type="file" id="upload-berkas-inp" name="file" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Upload Berkas" class="dcd-btn dcd-btn-sm dcd-btn-primary d-print-inline-block mr-2" style="width:100%;border:none;padding:10px 15px;font-size:12px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <a href="#" class="like-btn">
        <i class="icon-copy fa fa-heart-o my-like-btn" aria-hidden="true"></i>
    </a>

@endsection

@push('script')
<script>
    $("[data-background]").each(function () {
        $(this).css("background-image", "url(" + $(this).attr("data-background") + ")")
    });

    $(".dial1").knob();
    $({ animatedVal: 0 }).animate(
        { animatedVal: "{{$registrations->count()}}" },
        {
            duration: 3000,
            easing: "swing",
            step: function () {
                $(".dial1").val(Math.ceil(this.animatedVal)).trigger("change");
            },
        }
    );

    const addBerkas = (regis) => {
        $('#modal-upload-berkas').modal('show');
        let url = "/peserta/eventinternal/detail/uploadfile/"+regis.id_event_internal_registration;

        $('#form-upload-berkas').attr('action', url);
    };

    $(document).ready( function () {
        $(".nav-link").click(function(){
            $(this).removeClass('active');
        });
    });
    
    const slider = document.querySelector('.scrollmenu');
    let isDown = false;
    let startX;
    let scrollLeft;

    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('active-scroll');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('active-scroll');
        });
        slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('active-scroll');
        });
        slider.addEventListener('mousemove', (e) => {
        if(!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 3; //scroll-fast
        slider.scrollLeft = scrollLeft - walk;
        console.log(walk);
    });
</script>
@endpush

