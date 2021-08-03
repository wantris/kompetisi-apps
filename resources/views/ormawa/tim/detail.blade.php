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

    <div class="container-fluid" style="margin-bottom: 50px !important">
        <div class="row">
            <div class="col-12 mb-2">
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active pb-2" data-toggle="tab" href="#keanggotaan" role="tab" aria-selected="true">Keanggotaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pb-2" data-toggle="tab" href="#pembimbing" role="tab" aria-selected="false">Pembimbing</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="tab-content">
                    <div class="tab-pane fade show active"  id="keanggotaan" role="tabpanel">
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
                                                                @if ($detail->mahasiswaRef)
                                                                    {{$detail->mahasiswaRef->mahasiswa_nama}}
                                                                @else
                                                                    {{$detail->nim}}
                                                                @endif
                                                            @else
                                                                {{$detail->participantRef->nama_participant}}
                                                            @endif
                                                        </h4>
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
                    <div class="tab-pane fade" id="pembimbing" role="tabpanel">
                        <div class="row mb-2">
                            <div class="col-lg-6 col-12">
                                <p class="h4 text-secondary">Daftar Pembimbing:</p>
                            </div>
                            <div class="col-lg-6 col-12 text-right">
                                @php
                                    $jsonDosens = json_encode($dosens)
                                @endphp
                                @if ($tim->status == "0")
                                    <a href="#" onclick="showModalDosen({{$tim->id_tim_event}}, {{$jsonDosens}})" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2" style="border:none;padding:5px 15px;font-size:12px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                    Pilih Pembimbing</a>
                                @endif
                            </div>
                        </div>
                        <div class="card-box mb-5">
                            <div class="card-body">
                                <table class="stripe table nowrap" id="pembimbing-table">
                                    <thead>
                                        <th>Nama Dosen</th>
                                        <th>Jurusan</th>
                                    </thead>
                                    <tbody>
                                        @if ($tim->nidn)
                                            <tr>
                                                <td >
                                                    @if ($tim->dosenRef)
                                                        {{$tim->dosenRef->dosen_lengkap_nama}}
                                                    @else
                                                        {{$tim->nidn}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($tim->dosenRef)
                                                        {{$tim->dosenRef->program_studi_nama}}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
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

    {{-- Modal add pembimbing --}}
    <div style="border: none !important" class="modal fade" id="modal-pembimbing"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-orange" id="myLargeModalLabel"><i class="icon-copy dw dw-user-11 mr-2"></i>Pilih Pembimbing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="" id="form-pembimbing" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('patch')
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="nidn" style="width: 100%" id="pembimbing-inp">
                                <option selected>Cari Nama Dosen</option>
                            </select>
                            <input type="hidden" name="id_tim" id="id-tim-inp">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Pilih Dosen" class="dcd-btn dcd-btn-sm dcd-btn-primary d-print-inline-block mr-2" style="width:100%;border:none;padding:10px 15px;font-size:12px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const showModalDosen = (id_tim, dosens) => {
            event.preventDefault();
            let url = '/ormawa/team/ajukanpembimbing/'+id_tim;

            $('#form-pembimbing').attr('action', url);
            $('#modal-pembimbing').modal('show');

            $.each(dosens, function (i, item) {
                $('#pembimbing-inp').append($('<option>', { 
                    value: item.dosen_nidn,
                    text : item.dosen_nama+" "+item.dosen_gelar_belakang
                }));
            });

            
        }

        $(document).ready( function () {
            $('#invite-inp, #pembimbing-inp').select2();

            $('#pembimbing-table').DataTable({
                "bLengthChange": false,
                "language": {
                    "emptyTable": "Belum ada pembimbing"
                }
            });
        } );


    </script>
@endpush