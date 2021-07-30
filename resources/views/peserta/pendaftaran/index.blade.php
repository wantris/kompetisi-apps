@extends('peserta.app')

@section('title','Riwayat Pendaftaran')

@section('content')

<div class="container-fluid" style="margin-bottom:50px">
    <div class="row">
        <div class="col-12 mb-2">
            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active  pb-2" data-toggle="tab" href="#internal" role="tab" aria-selected="true">Event Internal</a>
                </li>
                @if (Session::get('is_participant') == "0")
                    <li class="nav-item">
                        <a class="nav-link pb-2" data-toggle="tab" href="#eksternal" role="tab" aria-selected="false">Event Eksternal</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="internal" role="tabpanel">
                    <div class="card-box mb-5 mt-3">
                        <div class="card-body">
                            <div class="table-responsive py-3">
                                <table class="stripe table nowrap" id="pendaftaran-internal-table">
                                    <thead>
                                        <th>ID Registrasi</th>
                                        <th>ID Tim</th>
                                        <th >Nama Peserta/Ketua Tim</th>
                                        <th>Event</th>
                                        <th>Sudah Tervalidasi</th>
                                        <th>Status Pendaftar</th>
                                        <th>Tanggal</th>
                                        <th class="table-plus datatable-nosort">Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($registrations as $regis)
                                            @if ($regis->eventInternalRef->role == "Individu")
                                                <tr id="tr_{{$regis->id_event_internal_registration}}">
                                                    <td>{{$regis->id_event_internal_registration}}</td>
                                                    <td></td>
                                                    <td>
                                                        @if ($regis->nim)
                                                            {{$regis->mahasiswaRef->mahasiswa_nama}}
                                                        @else
                                                            {{$regis->participantRef->nama_participant}}
                                                        @endif
                                                    </td>
                                                    <td>{{$regis->eventInternalRef->nama_event}}</td>
                                                    <td>
                                                        @if ($regis->status == "0")
                                                            <a href="#" class="btn btn-warning" style="font-size: 12px">Belum</a> 
                                                        @else
                                                            <a href="#" class="btn btn-success" style="font-size: 12px">Sudah</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($regis->nim)
                                                            Mahasiswa Polindra
                                                        @else
                                                            Partisipan Eksternal
                                                        @endif
                                                    </td>
                                                    <td>{{$regis->created_at->isoFormat('D MMM Y')}}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                                href="#" role="button" data-toggle="dropdown">
                                                                <i class="dw dw-more"></i>
                                                            </a>
                                                            @php
                                                                $slug = \Str::slug($regis->eventInternalRef->nama_event);
                                                            @endphp
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                <a class="dropdown-item" href="{{route('peserta.eventinternal.detail', $slug)}}"><i class="dw dw-rocket"></i>Lihat Event</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr id="tr_{{$regis->id_event_internal_registration}}">
                                                    <td>{{$regis->id_event_internal_registration}}</td>
                                                    <td>{{$regis->tim_event_id}}</td>
                                                    <td>
                                                        @foreach ($regis->timRef->timDetailRef as $detail)
                                                            @if ($detail->role == "ketua")
                                                                @if ($detail->nim)
                                                                    {{$detail->mahasiswaRef->mahasiswa_nama}}
                                                                @else
                                                                    {{$detail->participantRef->nama_participant}}
                                                                @endif
                                                            @endif
                                                        @endforeach    
                                                    </td>
                                                    <td>{{$regis->eventInternalRef->nama_event}}</td>
                                                    <td>
                                                        @if ($regis->status == "0")
                                                            <a href="#" class="btn btn-warning" style="font-size: 12px">Belum</a>
                                                        @else
                                                            <a href="#" class="btn btn-success" style="font-size: 12px">Sudah</a> 
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @foreach ($regis->timRef->timDetailRef as $detail)
                                                            @if ($detail->role == "ketua")
                                                                @if ($detail->nim)
                                                                    Mahasiswa Polindra
                                                                @else
                                                                    Partisipan Eksternal
                                                                @endif
                                                            @endif
                                                        @endforeach  
                                                    </td>
                                                    <td>{{$regis->created_at->isoFormat('D MMM Y')}}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                                href="#" role="button" data-toggle="dropdown">
                                                                <i class="dw dw-more"></i>
                                                            </a>
                                                            @php
                                                                $slug = \Str::slug($regis->eventInternalRef->nama_event);
                                                            @endphp
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                <a class="dropdown-item" href="{{route('peserta.team.detail', $regis->tim_event_id)}}"><i class="dw dw-eye"></i>Lihat Tim</a>
                                                                <a class="dropdown-item" href="{{route('peserta.eventinternal.detail', $slug)}}"><i class="dw dw-rocket"></i>Lihat Event</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="eksternal" role="tabpanel">
                    <div class="card-box mb-5 mt-3">
                        <div class="card-body">
                            <div class="table-responsive py-3">
                                <table class="stripe table nowrap" id="pendaftaran-eksternal-table">
                                    <thead>
                                        <th>ID Registrasi</th>
                                        <th>ID Tim</th>
                                        <th>Nama Peserta/Ketua Tim</th>
                                        <th>Event</th>
                                        <th>Sudah Tervalidasi</th>
                                        <th>Status Pendaftar</th>
                                        <th>Tanggal</th>
                                        <th class="table-plus datatable-nosort">Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($eksternal_registrations as $eksternal)
                                            @if ($eksternal->eventEksternalRef->role == "Individu")
                                                <tr id="tr_{{$eksternal->id_event_eksternal_registration}}">
                                                    <td>{{$eksternal->id_event_eksternal_registration}}</td>
                                                    <td></td>
                                                    <td>
                                                        {{$eksternal->mahasiswaRef->mahasiswa_nama}}
                                                    </td>
                                                    <td>{{$eksternal->eventeksternalRef->nama_event}}</td>
                                                    <td>
                                                        @if ($eksternal->status == "0")
                                                            <a href="#" class="btn btn-warning" style="font-size: 12px">Belum</a> 
                                                        @else
                                                            <a href="#" class="btn btn-success" style="font-size: 12px">Sudah</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        Mahasiswa Polindra
                                                    </td>
                                                    <td>{{$eksternal->created_at->isoFormat('D MMM Y')}}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                                href="#" role="button" data-toggle="dropdown">
                                                                <i class="dw dw-more"></i>
                                                            </a>
                                                            @php
                                                                $slug = \Str::slug($eksternal->eventeksternalRef->nama_event);
                                                            @endphp
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                <a class="dropdown-item" href="{{route('peserta.eventeksternal.detail', $slug)}}"><i class="dw dw-rocket"></i>Lihat Event</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr id="tr_{{$eksternal->id_event_eksternal_registration}}">
                                                    <td>{{$eksternal->id_event_eksternal_registration}}</td>
                                                    <td>{{$eksternal->tim_event_id}}</td>
                                                    <td>
                                                        @foreach ($eksternal->timRef->timDetailRef as $detail)
                                                            @if ($detail->role == "ketua")
                                                                    {{$detail->mahasiswaRef->mahasiswa_nama}}
                                                            @endif
                                                        @endforeach    
                                                    </td>
                                                    <td>{{$eksternal->eventEksternalRef->nama_event}}</td>
                                                    <td>
                                                        @if ($eksternal->status == "0")
                                                            <a href="#" class="btn btn-warning" style="font-size: 12px">Belum</a>
                                                        @else
                                                            <a href="#" class="btn btn-success" style="font-size: 12px">Sudah</a> 
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @foreach ($eksternal->timRef->timDetailRef as $detail)
                                                            @if ($detail->role == "ketua")
                                                                    Mahasiswa Polindra
                                                            @endif
                                                        @endforeach  
                                                    </td>
                                                    <td>{{$eksternal->created_at->isoFormat('D MMM Y')}}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                                href="#" role="button" data-toggle="dropdown">
                                                                <i class="dw dw-more"></i>
                                                            </a>
                                                            @php
                                                                $slug = \Str::slug($eksternal->eventEksternalRef->nama_event);
                                                            @endphp
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                <a class="dropdown-item" href="{{route('peserta.team.detail', $eksternal->tim_event_id)}}"><i class="dw dw-eye"></i>Lihat Tim</a>
                                                                <a class="dropdown-item" href="{{route('peserta.eventeksternal.detail', $slug)}}"><i class="dw dw-rocket"></i>Lihat Event</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         $(document).ready( function () {
            $('#pendaftaran-internal-table').DataTable({
                "bLengthChange": false,
                
                "language": {
                    "emptyTable": "Tidak Ada Riwayat"
                }
            });

            $('#pendaftaran-eksternal-table').DataTable({
                "bLengthChange": false,
                
                "language": {
                    "emptyTable": "Tidak Ada Riwayat"
                }
            });

            $.ajax({    
                type: "GET",
                url: "/peserta/registration/eventinternal/list",             
                dataType: "JSON",               
                success: function(response){                    
                    console.log(response);
                    //alert(response);
                }

            });
        } );

        const terimaUndangan = (values) => {
            let id_tim = values.tim_event_id;
            let id_detail = values.id_tim_event_detail;
            let url = "/peserta/team/users/invite/accept/"+id_tim;
            event.preventDefault();
            Notiflix.Confirm.Show( 
                'Undangan Tim',
                'Anda yakin ingin menerima undangan?',
                'Yes',
                'No',
            function(){ 
                $.ajax(
                    {
                        url: url,
                        type: 'patch', 
                        dataType: "JSON",
                        data: {
                            "id_detail": id_detail
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                location.reload();
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

        const tolakUndangan = (values) => {
            let id_tim = values.tim_event_id;
            let id_detail = values.id_tim_event_detail;
            let url = "/peserta/team/users/invite/denied/"+id_tim;
            event.preventDefault();
            Notiflix.Confirm.Show( 
                'Undangan Tim',
                'Anda yakin ingin menolak undangan?',
                'Yes',
                'No',
            function(){ 
                $.ajax(
                    {
                        url: url,
                        type: 'delete', 
                        dataType: "JSON",
                        data: {
                            "id_detail": id_detail
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                location.reload();
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