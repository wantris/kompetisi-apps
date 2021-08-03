@extends('ormawa.app')

@section('title','Event')

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="pd-20 card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="mb-2 col-12 col-lg-3">
                        <select id="status-select" class="form-control">
                            <option value="" selected>Semua Status</option>
                            <option value="Sudah">Tervalidasi</option>
                            <option value="Tidak">Belum Tervalidasi</option>
                        </select>
                    </div>
                    <div class="mb-2 col-12 col-lg-4">
                        <select id="events-select" class="form-control">
                            <option value="" selected>Semua Event</option>
                            @foreach ($events as $event)
                                <option value="{{$event->nama_event}}">{{$event->nama_event}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2 col-12 col-lg-4">
                        <select id="partisipan-select" class="form-control">
                            <option value="" selected>Semua Status Peserta</option>
                            <option value="Mahasiswa Polindra">Mahasiswa Polindra</option>
                            <option value="Partisipan Eksternal">Partisipan Eksternal</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive py-3">
                    <table class="pendaftaran-table table stripe hover nowrap" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID Registrasi</th>
                                <th>ID Tim</th>
                                <th >Nama Peserta/Ketua Tim</th>
                                <th>Event</th>
                                <th>Sudah Tervalidasi</th>
                                <th>Status Pendaftar</th>
                                <th>Tanggal</th>
                                <th class="table-plus datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registrations as $regis)
                                @if ($regis->eventInternalRef->role == "Individu")
                                    <tr id="tr_{{$regis->id_event_internal_registration}}">
                                        <td>{{$regis->id_event_internal_registration}}</td>
                                        <td></td>
                                        <td>
                                            @if ($regis->nim)
                                                @if ($regis->mahasiswaRef)
                                                    {{$regis->mahasiswaRef->mahasiswa_nama}}
                                                @else
                                                    {{$regis->nim}}
                                                @endif
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
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" target="_blank"
                                                            href="#"><i class="dw dw-eye"></i>Lihat Profil</a>
                                                    @if (Session::get('is_pembina') == "0")
                                                        @if ($regis->status == "0")
                                                            <a class="dropdown-item" href="{{route('ormawa.registration.eventinternal.updatestatus', ['id_regis'=>$regis->id_event_internal_registration,'status'=>1])}}"><i class="icon-copy dw dw-checked"></i>Buat Tervalidasi</a>
                                                        @else
                                                            <a class="dropdown-item" href="{{route('ormawa.registration.eventinternal.updatestatus', ['id_regis'=>$regis->id_event_internal_registration,'status'=>0])}}"><i class="icon-copy dw dw-ban"></i>Buat Belum Tervalidasi</a>
                                                        @endif
                                                            <a class="dropdown-item" href="#" onclick="deletePendaftar({{$regis->id_event_internal_registration}})"><i class="dw dw-delete-3"></i> Hapus</a>
                                                    @endif
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
                                                        @if ($detail->mahasiswaRef)
                                                            {{$detail->mahasiswaRef->mahasiswa_nama}}
                                                        @else
                                                            {{$detail->nim}}
                                                        @endif
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
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    @if (Session::get('is_pembina') == "0")
                                                        <a class="dropdown-item" href="{{route('ormawa.team.detail', $regis->tim_event_id)}}"><i class="dw dw-eye"></i>Lihat Tim</a>
                                                        @if ($regis->status == "0")
                                                            <a class="dropdown-item" href="{{route('ormawa.registration.eventinternal.updatestatus', ['id_regis'=>$regis->id_event_internal_registration,'status'=>1])}}"><i class="icon-copy dw dw-checked"></i>Buat Tervalidasi</a>
                                                        @else
                                                            <a class="dropdown-item" href="{{route('ormawa.registration.eventinternal.updatestatus', ['id_regis'=>$regis->id_event_internal_registration,'status'=>0])}}"><i class="icon-copy dw dw-ban"></i>Buat Belum Tervalidasi</a>
                                                        @endif
                                                            <a class="dropdown-item" href="#" onclick="deletePendaftar({{$regis->id_event_internal_registration}})"><i class="dw dw-delete-3"></i> Hapus</a>
                                                    @endif
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
@endsection

@push('script')
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
<script>
    
    $(document).ready( function () {
        var table = $('.pendaftaran-table').DataTable({
        });

        $('#status-select').each(function(){
            $(this).on('change', function(){
                table.column(4).search($(this).val()).draw(); 
            });
        });

        $('#events-select').each(function(){
            $(this).on('change', function(){
                table.column(3).search($(this).val()).draw(); 
            });
        });

        $('#partisipan-select').each(function(){
            $(this).on('change', function(){
                table.column(5).search($(this).val()).draw(); 
            });
        });
    } );

    const deletePendaftar = (id_regis) => {
        let url = "/ormawa/registration/eventinternal/delete/"+id_regis;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Pendaftaran',
            'Apakah anda yakin ingin menghapus?',
            'Yes',
            'No',
        function(){ 
            $.ajax(
                {
                    url: url,
                    type: 'delete', 
                    dataType: "JSON",
                    success: function (response){
                        console.log(response.status); 
                        if(response.status == 1){
                            Notiflix.Notify.Success(response.message);
                            $('#tr_' + id_regis).remove();
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