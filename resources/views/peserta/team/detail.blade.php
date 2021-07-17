@extends('peserta.app')

@section('title','Anggota Tim')

@push('css')
<link rel="stylesheet" type="text/css" href="{{url('assets/deskapp/vendors/styles/ribbon.css')}}">
<style>
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
</style>
@endpush

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-2">
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active pb-2" data-toggle="tab" href="#keanggotaan" role="tab" aria-selected="true">Keanggotaan</a>
                    </li>
                    @if ($check)
                        <li class="nav-item">
                            <a class="nav-link pb-2" data-toggle="tab" href="#status" role="tab" aria-selected="false">Status Undangan</a>
                        </li> 
                    @endif
                    <li class="nav-item">
                        <a class="nav-link pb-2" data-toggle="tab" href="#pembimbing" role="tab" aria-selected="false">Pembimbing</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="keanggotaan" role="tabpanel">
                        <div class="contact-directory-list">
                            <ul class="row">
                                @foreach ($tim->timDetailRef as $detail)
                                    @if ($detail->status == "Done")
                                        @if ($detail->nim)
                                            @php
                                                $pengguna = App\Pengguna::where('nim', $detail->nim)->first();
                                            @endphp
                                        @else
                                            @php
                                                $pengguna = App\Pengguna::where('participant_id', $detail->participant_id)->first();
                                            @endphp
                                        @endif
                                        <li class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-4">
                                            <div class="contact-directory-box" style="position: relative">
                                                <div class="ribbon ribbon-top-left"><span>{{$detail->role}}</span></div>
                                                <div class="contact-dire-info text-center">
                                                    <div class="contact-avatar">
                                                        <span>
                                                            @if ($pengguna)
                                                                @if ($pengguna->photo)
                                                                    <img src="{{asset('assets/img/photo-pengguna/'.$pengguna->photo)}}"  id="profil-image" alt="">
                                                                @else
                                                                    <img src="{{asset('assets/img/user.svg')}}" id="profil-image" alt="">
                                                                @endif
                                                            @else
                                                                <img src="{{asset('assets/img/user.svg')}}" id="profil-image" alt="">
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="contact-name">
                                                        <h4>
                                                            @if ($detail->nim)
                                                                {{$detail->nama_mhs}}
                                                            @else
                                                                {{$detail->participantRef->nama_participant}}
                                                            @endif
                                                        </h4>
                                                        {{-- <p>Teknik informatika</p> --}}
                                                        <div class="work text-success" style="font-size: 14px">
                                                            @if ($pengguna)
                                                            <i class="icon-copy dw dw-email-1 mr-1"></i>{{$pengguna->email}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="profile-sort-desc">
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing magna aliqua.
                                                    </div>
                                                </div>
                                                <div class="view-contact">
                                                    <a href="#">Lihat Profil</a>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade mb-5" id="status" role="tabpanel">
                        <div class="row mb-2">
                            <div class="col-lg-6 col-12">
                                <p class="h4 text-secondary">Manajemen Tim :</p>
                            </div>
                            <div class="col-lg-6 col-12 text-right">
                                <a href="#" onclick="showModalInvite({{$tim->id_tim_event}})" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2" style="border:none;padding:5px 15px;font-size:12px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                    Undang Anggota</a>
                            </div>
                        </div>
                        <div class="card-box mb-5">
                            <div class="card-body">
                                <table class="stripe table nowrap" id="tim-undangan-table">
                                    <thead>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($invitationals as $invite)
                                            @if ($invite->penggunaParticipantRef)
                                                @php
                                                    $pengguna = $invite->penggunaParticipantRef;
                                                @endphp
                                            @else
                                                @php
                                                    $pengguna = $invite->penggunaMhsRef;
                                                @endphp
                                            @endif
                                            <tr>
                                                <td >
                                                    <div class="d-flex flex-items-center">
                                                        <div class="mx-3">
                                                            @if ($pengguna->photo)
                                                                <img  src="{{asset('assets/img/photo-pengguna/'.$pengguna->photo)}}" style="width: 30px ;height:30px; border-radius:50%"  id="profil-image" alt="">
                                                            @else
                                                                <img  src="{{asset('assets/img/user.svg')}}" style="width: 30px ;height:30px; border-radius:50%" id="profil-image" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="d-flex flex-column flex-auto">
                                                            @if ($invite->nim)
                                                                <a href="#" class="text-orange"><strong>{{$invite->nama_mhs}}</strong></a>
                                                                <small class="text-secondary">{{$invite->role}}</small>
                                                            @else
                                                                <a href="#" class="text-orange"><strong>{{$invite->participantRef->nama_participant}}</strong></a>
                                                                <small class="text-secondary">{{$invite->role}}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td> {{$invite->status}} invite</td>
                                                <td>
                                                    <a href="#" class="text-secondary"><i class="icon-copy dw dw-trash1"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pembimbing" role="tabpanel">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        if ($tim->eventInternalRegisRef) {
            $type = "internal";
            $id_event = $tim->eventInternalRegisRef->event_internal_id;
        }else{
            $type = "eksternal";
            $id_event = $tim->eventEksternalRegisRef->event_eksternal_id;
        }
    @endphp

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
                            <select name="id_pengguna" style="width: 100%" id="invite-inp">
                                <option selected>Cari berdasarkan nama atau username</option>
                            </select>
                            <input type="hidden" name="type" id="type-inp">
                            <input type="hidden" name="id_event" id="id-event-inp">
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
        const showModalInvite = (id_tim_event) => {
            event.preventDefault();
            let type = "{{$type}}";
            let id_event = "{{$id_event}}";
            let url = '/peserta/team/users/invite/'+id_tim_event;
          
            $('#modal-invite').modal('show');
            $('#type-inp').val(type);
            $('#id-event-inp').val(id_event);
            $('#form-invite').attr('action', url);
        }
        const renderInviteSelect = () => {
            let id = "{{$id}}";
            $.ajax({
                url: "/peserta/team/users/search/"+id,
                type:"GET",
                dataType: "json",
                success: function(values){
                    $.each(values, function (i, item) {
                        if(item.nim){
                            $('#invite-inp').append($('<option>', { 
                                value: item.id_pengguna,
                                text : item.nama_mhs + " ("+item.username+")"
                            }));
                        }else{
                            $('#invite-inp').append($('<option>', { 
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

        $(document).ready( function () {
            $('#invite-inp').select2();
            renderInviteSelect();

            $('#tim-undangan-table').DataTable({
                "bLengthChange": false,
                "fnDrawCallback": function ( oSettings ) {
                    $(oSettings.nTHead).hide();
                }
            });
        } );

        
    </script>
@endpush