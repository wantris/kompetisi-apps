@extends('peserta.app')

@section('title', $slug)

@push('css')
<style>
    .like-btn{
        position:fixed;
        width:60px;
        height:60px;
        bottom:40px;
        right:40px;
        background-color:#126afe;
        color:#FFF;
        border-radius:50px;
        font-size: 20px;
        text-align:center;
        text-decoration: none;
        box-shadow: 2px 2px 3px #999;
    }

    .like-btn:hover{
        color: #fff;
    }

    .my-like-btn{
        margin-top:22px;
    }    

    .banner-event{
        /* Background image is centered vertically and horizontally at all times */
        background-position: center center;

        /* Background image doesn’t tile */
        background-repeat: no-repeat;

        /* This is what makes the background image rescale based
        on the container’s size */
        background-size: cover;

        width: 100%;
        height: 300px;
    }

    .user-profile-picture {
    height: 200px;
    width: 200px;
    background: #fff;
}
.minus-top {
    position: absolute;
    top: -40px;
}
.wrapper-kelas {
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.shadow {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
.rounded {
    border-radius: .25rem!important;
}
.event-description-detail p {
    font-size: 14px;
}
@media (max-width: 991.98px){
    .wrapper-kelas-sm {
        height: 180px!important;
        width: 180px!important;
        margin: 0 auto 30px auto;
    }
    .wrapper-kelas-sm.minus-top {
        position: unset;
        margin: -80px auto 0 auto;
    }
}

@media (min-width: 991.98px){
    .event-description-detail{
        padding-left: 80px;
    }
}

.separator {
  display: flex;
  align-items: center;
  text-align: center;
}

.separator::before,
.separator::after {
  content: '';
  flex: 1;
  border-bottom: 1px solid #f5a461;
}

.separator:not(:empty)::before {
  margin-right: .25em;
}

.separator:not(:empty)::after {
  margin-left: .25em;
}

.select2-selection {
        -webkit-box-shadow: 0;
        box-shadow: 0;
        background-color: #fff;
        border: 0;
        border-radius: 0;
        color: #555555;
        font-size: 14px;
        outline: 0;
        min-height: 48px;
        text-align: left;
        }

        .select2-selection__rendered {
        margin: 10px;
        }

        .select2-selection__arrow {
        margin: 10px;
        }

        div.scrollmenu {
            border-radius: 10px;
        background-color: #0079ff;
        overflow: auto;
        white-space: nowrap;
        }

        div.scrollmenu a {
        display: inline-block;
        color: white;
        text-align: center;
        padding: 14px 25px;
        background-color: #0079ff;
        text-decoration: none;
        }

        div.scrollmenu a:hover {
        background-color: #f5a461;
        }

        div.scrollmenu::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
div.scrollmenu {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
</style>    
@endpush


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="banner-event" data-background="{{url('assets/img/banner-komp/'.$event->banner_image)}}" style="border-radius: 20px">
                
            </div>
        </div>
    </div>
    <div class="container" style="margin-bottom: 50px">
        <div class="row">
            <div class="col-lg-2 col-sm-12 col-12 col-md-4 mb-sm-7">
                <div class="px-3 mx-auto py-3 wrapper-kelas rounded shadow minus-top logo-center wrapper-kelas-sm user-profile-picture">
                    <img src="{{url('assets/img/ormawa-logo/'.$event->cakupanOrmawaRef->ormawaRef->photo)}}" class="img-fluid" alt="{{$event->cakupanOrmawaRef->ormawaRef->nama_ormawa}}">
                </div>
            </div>
            <div class="event-description-detail" class="col-lg-9 mx-4 col-sm-7 col-md-8 pt-3 pl-xl-5 pl-lg-5 pl-sm-4">
                <div class="d-flex mt-3">
                    <h4>{{$event->nama_event}}</h4>
                </div>
                <p class="mt-2">
                    <span class="text-icon">
                        <i class="icon-copy dw dw-user-2 mr-2"></i>{{$event->cakupanOrmawaRef->ormawaRef->nama_ormawa}}
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
                        <a class="nav-link" data-toggle="tab" href="#deskripsi" role="tab" aria-selected="true">Deksripsi</a>
                        <a class="nav-link" data-toggle="tab" href="#dokumen" role="tab" aria-selected="false">Dokumen Event</a>
                        <a class="nav-link" data-toggle="tab" href="#pendaftar" role="tab" aria-selected="false">Pendaftar</a>
                        <a class="nav-link" href="#about">Upload Berkas</a>
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
                               {{-- <div class="row mt-2">
                                    <div class="col-lg-1">
                                        <div class="rounded-circle shadow-sm text-center bg-primary text-white pt-1" style="width: 30px; height:30px;position: relative;"><i class="icon-copy dw dw-right-chevron text-center" style="font-size:14px"></i></div>
                                    </div>
                                    <div class="col-8">
                                        <div class="py-1 px-2" style="width:100%; border-bottom:1px solid #126afe !important;">
                                            asdad
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <a href="#" class="btn btn-outline-primary" style="font-size: 14px">Download</a>
                                    </div>
                               </div> --}}
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
                    </div>
                </div>
            </div>
        </div>
       </div>
       <div class="col-lg-4 col-md-12 col-sm-12 mb-30">
            <div class="row clearfix progress-box position-sticky">
                <div class="col-lg-12 col-md-4">
                    <div class="col-12">
                        <div class="alert alert-success">
                            @if ($check_regis)
                                Anda sudah terdaftar pada event ini
                            @else
                                Yuk daftar event {{$event->nama_event}}
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        @if (!$check_regis)
                            @if ($event->role == "Team")
                                @php
                                    $jsonPengguna = json_encode($pengguna);
                                    $jsonEvent = json_encode($event);
                                    $jsonSearch = json_encode($search);
                                @endphp
                                <button class="btn btn-primary shadow" onclick="showModalInvite({{$jsonPengguna}}, {{$jsonEvent}}, {{$jsonSearch}})" style="font-size: 14px !important; padding:5px 10px;background-color:#0079ff;border-color:#0079ff; width:100%">Daftar Sekarang</button>
                            @else
                                <button class="btn btn-primary shadow" onclick="registerEvent()" style="font-size: 14px !important; padding:5px 10px;background-color:#0079ff;border-color:#0079ff; width:100%">Daftar Sekarang</button>
                            @endif                  
                        @else
                            <button class="btn btn-primary shadow" style="font-size: 14px !important; padding:5px 10px;background-color:#0079ff;border-color:#0079ff; width:100%">Sudah Terdaftar</button>
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

    <a href="#" class="like-btn">
        <i class="icon-copy fa fa-heart-o my-like-btn" aria-hidden="true"></i>
    </a>

    <form id="regis-event-form" action="{{route('peserta.eventeksternal.register', $slug)}}" method="POST">
        @csrf
    </form>

    
    {{-- Modal Invite --}}
    <div style="border: none !important" class="modal fade" id="modal-invite"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-orange" id="myLargeModalLabel"><i class="icon-copy dw dw-user-11 mr-2"></i>Undang Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="" id="form-invite" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Ketua Tim</label>
                            <input type="text" disabled value="" id="nama-ketua-text" class="form-control">
                            <input type="hidden" id="id-ketua-text" name="ketua">
                        </div>
                        <div class="separator">Tambah Anggota</div>
                        <div class="form-group mb-3">
                            <button onclick="removeAnggota()" type="button" class="dcd-btn dcd-btn-sm dcd-btn-primary d-print-inline-block mr-2 float-left" style="border:none;padding:5px 10px;font-size:10px;background: linear-gradient(60deg,#f5a461,#e86b32) !important"><i class="icon-copy dw dw-trash1"></i></button>
                            <button onclick="addAnggota()" class="dcd-btn dcd-btn-sm dcd-btn-primary d-print-inline-block mr-2 float-right" style="border:none;padding:5px 10px;font-size:10px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">+</button>
                        </div>
                        <div class="form-group" style="margin-top: 50px !important">
                            <select name="anggota[]" style="width: 100%" id="invite-inp">
                                <option selected>Cari berdasarkan nama atau username</option>
                            </select>
                        </div>
                        <div class="anggota-containter_inp">

                        </div>
                        <div class="form-group">
                            <input type="submit" value="Pilih anggota" class="dcd-btn dcd-btn-sm dcd-btn-primary d-print-inline-block mr-2" style="width:100%;border:none;padding:10px 15px;font-size:12px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
<script>
    let events = null;

     $("[data-background]").each(function () {
        $(this).css("background-image", "url(" + $(this).attr("data-background") + ")")
    });

    const registerEvent = () => {
        $('#regis-event-form').submit();
    }

    const showModalInvite = (pengguna, events, search) => {
        event.preventDefault();
        this.events = events;
        
        $('#modal-invite').modal('show');

        let id_pengguna = pengguna.id_pengguna;
        let slug = "{{$slug}}";
        let url = "/peserta/eventeksternal/detail/register/"+slug;

        $('#form-invite').attr('action', url);

        if(pengguna.is_mahasiswa){
            $('#nama-ketua-text').val(pengguna.nama_mhs);
        }else{
            $('#nama-ketua-text').val(pengguna.participant_ref.nama_participant);
        }
        $('#id-ketua-text').val(pengguna.id_pengguna);

        $.each(search, function (i, item) {
            if(item.is_mahasiswa){
                $('#invite-inp').append($('<option>', { 
                    value: item.id_pengguna,
                    text : item.nama_mhs + " ("+item.username+")"
                }));
            }else if(item.is_participant){
                $('#invite-inp').append($('<option>', { 
                    value: item.id_pengguna,
                    text : item.participant_ref.nama_participant + " ("+item.username+")"
                }));
            }
        });
    } 

    const renderInviteSelect = (id, id_event) => {
        $.ajax({
            url: "/event/users/search/"+id_event,
            type:"GET",
            dataType: "json",
            success: function(values){
                console.log(values);
                $.each(values, function (i, item) {
                    if(item.is_mahasiswa){
                        $('#select_anggota_'+id).append($('<option>', { 
                            value: item.id_pengguna,
                            text : item.nama_mhs + " ("+item.username+")"
                        }));
                    }else if(item.is_participant){
                        $('#select_anggota_'+id).append($('<option>', { 
                            value: item.id_pengguna,
                            text : item.participant_ref.nama_participant + " ("+item.username+")"
                        }));
                    }
                });
            },
            error:function(err){
                console.log(err);
            },
        });
    }

    // add row func
    let id = 1;
    const addAnggota = () => {
        event.preventDefault();
        if(id < 4){
            id = id +1;
            var html = '';
            html = `<div class="form-group" style="margin-top: 20px !important">
                        <select id="select_anggota_${id}" name="anggota[]" class="select-single" style="width: 100%">
                            <option selected>Cari berdasarkan nama atau username</option>
                        </select>
                    </div>`;

            $('.anggota-containter_inp').append(html);

            renderInviteSelect(id, this.events.id_event_eksternal);
            
            $('.select-single').each(function () {
                $('.select-single').select2();
            });
       }
    };

    const removeAnggota = () => {
        event.preventDefault();
        if(id > 1){
            id = id - 1;
            $('.anggota-containter_inp .form-group').last().remove();
        }
    }

    $(document).ready( function () {
        $('#invite-inp').select2();
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

