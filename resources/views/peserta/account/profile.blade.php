@extends('peserta.app')

@section('title','Account')

@section('content')

<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="profile-photo text-center">
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
                    @if ($pengguna->mahasiswaRef)
                        {{$pengguna->mahasiswaRef->mahasiswa_nama}}
                    @endif
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
                            <a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">Riwayat Event</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pencapaian" role="tab">Pencapaian</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Timeline Tab start -->
                        <div class="tab-pane fade show active" id="timeline" role="tabpanel">
                            <div class="pd-20">
                                <div class="profile-timeline">
                                    
                                </div>
                            </div>
                        </div>
                        <!-- Timeline Tab End -->
                        <!-- Tasks Tab start -->
                        <div class="tab-pane fade" id="pencapaian" role="tabpanel">
                            <div class="pd-20 profile-task-wrap">
                                <div class="container pd-0">
                                    <div class="row" id="prestasi-container">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tasks Tab End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

{{-- Modal Prestasi --}}
<div style="border: none !important" class="modal fade" id="modal-prestasi"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-orange" id="myLargeModalLabel"><i class="icon-copy dw-fire1 mr-2"></i>Catatan Prestasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="container-fluid">
                <div class="catatan-container y-5">

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')

<script>
    const id_pengguna = "{{$pengguna->id_pengguna}}";

    $(document).ready( function () {    
        getAllPrestasi();
        getEventHistory();
    });



    const getAllPrestasi = () => {
        $.ajax({
            url: "/peserta/account/profile/prestasi/"+id_pengguna,
            type:"GET",
            dataType: "json",
            success: function(values){
                renderPrestasi(values);
            },
            error:function(err){
                console.log(err);
            },
        });
    }

    const renderPrestasi = (prestasis) => {
        let html = ``;
        
        prestasis.forEach(function(prestasi,index){ 
            let logo_ormawa = "";
            let img_url = "";
            
            if(prestasi.event_internal_regis_ref){
                logo_ormawa = "/assets/img/ormawa-logo/"+prestasi.event_internal_regis_ref.event_internal_ref.ormawa_ref.photo;
                img_url = "";
                if(prestasi.posisi == "1"){
                    img_url = "{{url('assets/img/icon/gold-medal.svg')}}";
                }else if(prestasi.posisi == "2"){
                    img_url = "{{url('assets/img/icon/silver-medal.svg')}}";
                }
                html += `
                    <div class="col-lg-6 col-md-6 col-12 text-center">
                        <div class="card text-center shadow" style="border-radius: 20px;">
                            <img src="${img_url}" style="max-width: 90px;" alt="" class="text-center mx-auto img-fluid">
                            <div class="card-body">
                                <a class="card-title" href="#" style="color: #fb8c00" onclick="modalCatatanPrestasi('${prestasi.catatan}')" >${prestasi.event_internal_regis_ref.event_internal_ref.nama_event}</a>
                            </div>
                            <div class="card-footer">
                                <div class="float-left">
                                    <img src="${logo_ormawa}" style="max-width: 25px;max-height:25px" alt="" class="text-center img-fluid">
                                </div>
                                <div class="float-right text-secondary">
                                    <small style="color: #fb8c00">
                                        19-May-2021</small>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }else{
                logo_ormawa = "/assets/img/ormawa-logo/"+prestasi.event_eksternal_regis_ref.event_eksternal_ref.cakupan_ormawa_ref.ormawa_ref.photo;
                img_url = "";
                if(prestasi.posisi == "1"){
                    img_url = "{{url('assets/img/icon/gold-medal.svg')}}";
                }else if(prestasi.posisi == "2"){
                    img_url = "{{url('assets/img/icon/silver-medal.svg')}}";
                }
                html += `
                    <div class="col-lg-6 col-md-6 col-12 text-center">
                        <div class="card text-center shadow" style="border-radius: 20px;">
                            <img src="${img_url}" style="max-width: 90px;" alt="" class="text-center mx-auto img-fluid">
                            <div class="card-body">
                                <a class="card-title" href="#" style="color: #fb8c00" onclick="modalCatatanPrestasi('${prestasi.catatan}')" >${prestasi.event_eksternal_regis_ref.event_eksternal_ref.nama_event}</a>
                            </div>
                            <div class="card-footer">
                                <div class="float-left">
                                    <img src="${logo_ormawa}" style="max-width: 25px;max-height:25px" alt="" class="text-center img-fluid">
                                </div>
                                <div class="float-right text-secondary">
                                    <small style="color: #fb8c00">
                                        19-May-2021</small>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        }); 

        $('#prestasi-container').html(html);
    }

    const getEventHistory = () => {
        $.ajax({
            url: "/peserta/account/profile/eventhistory/"+id_pengguna,
            type:"GET",
            dataType: "json",
            success: function(values){
                console.log(values);
                renderHistoryEvent(values);
            },
            error:function(err){
                console.log(err);
            },
        });
    }

    const renderHistoryEvent = (tanggals) => {
        let html = ``;
      
        for (const [key, value] of Object.entries(tanggals)) {
            var newStr = key.replace("_", ", ");
            html += `
                <div class="timeline-month">
                    <h5>${newStr}</h5>
                </div>
                <div class="profile-timeline-list">
                    <ul class="${key}">
                    </ul>
                </div>
            `;
        }

        $('.profile-timeline').html(html);

        for (const [key, value] of Object.entries(tanggals)) {
            let html_event = ``;
            value.forEach(function(event, index){
                if(event.event_internal_ref){
                    html_event += `
                        <li>
                            <div class="task-name"><i class="icon-copy dw dw-rocket mr-5"></i>${event.event_internal_ref.nama_event}</div>
                            <div class="task-time">${event.event_internal_ref.ormawa_ref.nama_ormawa}</div>
                            <div class="task-time">${event.created_at}</div>
                        </li>
                    `;
                }else{
                    html_event += `
                        <li>
                            <div class="task-name"><i class="icon-copy dw dw-rocket mr-5"></i>${event.event_eksternal_ref.nama_event}</div>
                            <div class="task-time">${event.event_eksternal_ref.cakupan_ormawa_ref.ormawa_ref.nama_ormawa}</div>
                            <div class="task-time">${event.created_at}</div>
                        </li>
                    `;
                }
                $('.'+key).html(html_event);
            });  
        }
    }

    const modalCatatanPrestasi = (catatan) => {
        event.preventDefault();
        $('.catatan-container').text(catatan);
        $('#modal-prestasi').modal('show');
    }
</script>
@endpush