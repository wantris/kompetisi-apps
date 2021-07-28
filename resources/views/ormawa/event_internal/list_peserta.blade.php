@extends('ormawa.app')

@section('title','Event')

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="pd-20 card">
            <div class="card-body">
                <div class="mb-2 col-12 col-lg-3">
                    <select id="status-select" class="form-control">
                        <option value="" selected>Semua Status</option>
                        <option value="Sudah">Tervalidasi</option>
                        <option value="Tidak">Belum Tervalidasi</option>
                    </select>
                </div>
                 @if ($ei->role == "Individu")
                    <div class="table-responsive">
                        <table class="pendaftaran-table table stripe hover nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">Nama</th>
                                    <th>Status Pendaftar</th>
                                    <th>Sudah Tervalidasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftaran as $regis)
                                    <tr id="tr_{{$regis->id_event_internal_registration}}">
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
                                        <td>
                                            @if ($regis->status == "0")
                                                <a href="#" class="btn btn-warning" style="font-size: 12px">Belum</a> 
                                            @else
                                                <a href="#" class="btn btn-success" style="font-size: 12px">Sudah</a>
                                            @endif
                                        </td>
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
                                                            <a class="dropdown-item" href="{{route('ormawa.eventinternal.pendaftar.updatestatus', ['id_regis'=>$regis->id_event_internal_registration,'status'=>1])}}"><i class="icon-copy dw dw-checked"></i>Buat Tervalidasi</a>
                                                        @else
                                                            <a class="dropdown-item" href="{{route('ormawa.eventinternal.pendaftar.updatestatus', ['id_regis'=>$regis->id_event_internal_registration,'status'=>0])}}"><i class="icon-copy dw dw-ban"></i>Buat Belum Tervalidasi</a>
                                                        @endif
                                                            <a class="dropdown-item" href="#" onclick="deletePendaftar({{$regis->id_event_internal_registration}})"><i class="dw dw-delete-3"></i> Hapus</a>
                                                    @endif
                                                    @if ($regis->fileEiRegisRef->count() > 0 && $feeds->count() > 0)
                                                        <a class="dropdown-item" href="{{route('ormawa.eventinternal.pendaftar.downloadberkas', $regis->id_event_internal_registration)}}"><i class="icon-copy dw dw-inbox"></i>Download Berkas</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="pendaftaran-table table stripe hover nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">ID Tim</th>
                                    <th>Ketua Tim</th>
                                     <th>Sudah Tervalidasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftaran as $regis)
                                    <tr id="tr_{{$regis->id_event_internal_registration}}">
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
                                        <td>
                                            @if ($regis->status == "0")
                                                <a href="#" class="btn btn-warning" style="font-size: 12px">Belum</a>
                                            @else
                                                <a href="#" class="btn btn-success" style="font-size: 12px">Sudah</a> 
                                            @endif
                                        </td>
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
                                                            <a class="dropdown-item" href="{{route('ormawa.eventinternal.pendaftar.updatestatus', ['id_regis'=>$regis->id_event_internal_registration,'status'=>1])}}"><i class="icon-copy dw dw-checked"></i>Buat Tervalidasi</a>
                                                        @else
                                                            <a class="dropdown-item" href="{{route('ormawa.eventinternal.pendaftar.updatestatus', ['id_regis'=>$regis->id_event_internal_registration,'status'=>0])}}"><i class="icon-copy dw dw-ban"></i>Buat Belum Tervalidasi</a>
                                                        @endif
                                                            <a class="dropdown-item" href="#" onclick="deletePendaftar({{$regis->id_event_internal_registration}})"><i class="dw dw-delete-3"></i> Hapus</a>
                                                    @endif
                                                    @if ($regis->fileEiRegisRef->count() > 0 && $feeds->count() > 0)
                                                        <a class="dropdown-item" href="{{route('ormawa.eventinternal.pendaftar.downloadberkas', $regis->id_event_internal_registration)}}"><i class="icon-copy dw dw-inbox"></i>Download Berkas</a>
                                                  
                                                    @endif
                                                </div>
                                            </div>
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
@endsection

@push('script')
<script>
    let id_event = "{{$ei->id_event_internal}}";
    let status = "all"
    
    $(document).ready( function () {
        var table = $('.pendaftaran-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Validasi Semua',
                    action: function ( e, dt, node, config ) {
                        let url = "/ormawa/eventinternal/pendaftar/validasisemua/"+id_event;
                        console.log(url);
                         $.ajax(
                            {
                                url: url,
                                type: 'GET', 
                                dataType: "JSON",
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
                    }
                },
                {
                    text: 'Export Excel',
                    action: function ( e, dt, node, config ) {
                        let url = "/ormawa/eventinternal/pendaftar/export/"+id_event+"/"+status;
                        window.location = url;
                    }
                }
            ]
        });

        $('#status-select').each(function(){
            $(this).on('change', function(){
                if($(this).val() == "Sudah"){
                    status = 1;
                }else if($(this).val() == "Tidak"){
                    status = 0;
                }else{
                    status = "all";
                }

                table.column(2).search($(this).val()).draw(); 
            });
        });
    } );

      const deletePendaftar = (id_regis) => {
        let url = "/ormawa/eventinternal/pendaftar/delete/"+id_regis;
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