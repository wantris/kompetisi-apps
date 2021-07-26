@extends('ormawa.app')

@section('title','Event')

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="pd-20 card">
            <div class="card-body">
                 @if ($ee->role == "Individu")
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
                                    <tr id="tr_{{$regis->id_event_eksternal_registration}}">
                                        <td>
                                            {{$regis->nama_mhs}}
                                        </td>
                                        <td>
                                            Mahasiswa Polindra
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
                                                            <a class="dropdown-item" href="{{route('ormawa.eventeksternal.pendaftar.updatestatus', ['id_regis'=>$regis->id_event_eksternal_registration,'status'=>1])}}"><i class="icon-copy dw dw-checked"></i>Buat Tervalidasi</a>
                                                        @else
                                                            <a class="dropdown-item" href="{{route('ormawa.eventeksternal.pendaftar.updatestatus', ['id_regis'=>$regis->id_event_eksternal_registration,'status'=>0])}}"><i class="icon-copy dw dw-ban"></i>Buat Belum Tervalidasi</a>
                                                        @endif
                                                            <a class="dropdown-item" href="#" onclick="deletePendaftar({{$regis->id_event_eksternal_registration}})"><i class="dw dw-delete-3"></i> Hapus</a>
                                                    @endif
                                                    @if ($regis->count() > 0)
                                                        @if ($regis->fileEeRegisRef->count() > 0 && $feeds->count() > 0)
                                                            <a class="dropdown-item" href="{{route('ormawa.eventeksternal.pendaftar.downloadberkas', $regis->id_event_eksternal_registration)}}"><i class="icon-copy dw dw-inbox"></i>Download Berkas</a>
                                                        @endif
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
                                    <tr id="tr_{{$regis->id_event_eksternal_registration}}">
                                        <td>{{$regis->tim_event_id}}</td>
                                        <td>
                                            @foreach ($regis->timRef->timDetailRef as $detail)
                                                @if ($detail->role == "ketua")
                                                    {{$detail->nama_mhs}}
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
                                                            <a class="dropdown-item" href="{{route('ormawa.eventeksternal.pendaftar.updatestatus', ['id_regis'=>$regis->id_event_eksternal_registration,'status'=>1])}}"><i class="icon-copy dw dw-checked"></i>Buat Tervalidasi</a>
                                                        @else
                                                            <a class="dropdown-item" href="{{route('ormawa.eventeksternal.pendaftar.updatestatus', ['id_regis'=>$regis->id_event_eksternal_registration,'status'=>0])}}"><i class="icon-copy dw dw-ban"></i>Buat Belum Tervalidasi</a>
                                                        @endif
                                                            <a class="dropdown-item" href="#" onclick="deletePendaftar({{$regis->id_event_eksternal_registration}})"><i class="dw dw-delete-3"></i> Hapus</a>
                                                    @endif
                                                    @if ($regis->count() > 0)
                                                        @if ($regis->fileEeRegisRef->count() > 0 && $feeds->count() > 0)
                                                            <a class="dropdown-item" href="{{route('ormawa.eventeksternal.pendaftar.downloadberkas', $regis->id_event_eksternal_registration)}}"><i class="icon-copy dw dw-inbox"></i>Download Berkas</a>
                                                        @endif
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
    let id_event = "{{$ee->id_event_eksternal}}";
    $(document).ready( function () {
        $('.pendaftaran-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf',
                {
                    text: 'Validasi Semua',
                    action: function ( e, dt, node, config ) {
                        let url = "/ormawa/eventeksternal/pendaftar/validasisemua/"+id_event;
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
                }
            ]
        });
    } );

      const deletePendaftar = (id_regis) => {
        let url = "/ormawa/eventeksternal/pendaftar/delete/"+id_regis;
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