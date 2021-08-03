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
                 @if ($ee->role == "Individu")
                    <div class="table-responsive">
                        <table class="pendaftaran-table table stripe hover nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">Nama</th>
                                    <th>Kelas</th>
                                    <th>Email</th>
                                    <th>Nomor Telepon</th>
                                    <th>Status Pendaftar</th>
                                    <th>Sudah Tervalidasi</th>
                                    <th>Status Juara</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftaran as $regis)
                                    <tr id="tr_{{$regis->id_event_eksternal_registration}}">
                                        <td>
                                            @if ($regis->mahasiswaRef)
                                                {{$regis->mahasiswaRef->mahasiswa_nama}}
                                            @else
                                                {{$regis->nim}}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($regis->mahasiswaRef)
                                                {{$regis->mahasiswaRef->kelas_kode}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$regis->penggunaRef->email}}
                                        </td>
                                        <td>
                                            {{$regis->penggunaRef->phone}}
                                        </td>
                                        <td>
                                            Mahasiswa Polindra
                                        </td>
                                        <td>
                                            @if ($regis->status == "0")
                                                <a href="#" class="btn btn-warning" style="font-size: 12px">Tidak</a> 
                                            @else
                                                <a href="#" class="btn btn-success" style="font-size: 12px">Sudah</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($regis->prestasiRef)
                                            {{$regis->prestasiRef->posisi}}
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
                                                        @php
                                                            $regis_json = json_encode($regis);
                                                        @endphp
                                                        <a class="dropdown-item" href="#" onclick="statusJuara({{$regis_json}})"><i class="dw dw-fire"></i>Status Juara</a>
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
                                    <th>Kelas</th>
                                    <th>Sudah Tervalidasi</th>
                                    <th>Status Juara</th>
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
                                                    @if ($detail->mahasiswaRef)
                                                        {{$detail->mahasiswaRef->mahasiswa_nama}}
                                                    @else
                                                        {{$detail->nim}}
                                                    @endif
                                                @endif
                                            @endforeach    
                                        </td>
                                        <td>
                                            @foreach ($regis->timRef->timDetailRef as $detail)
                                                @if ($detail->role == "ketua")
                                                    @if ($detail->mahasiswaRef)
                                                        {{$detail->mahasiswaRef->kelas_kode}}
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
                                            @if ($regis->prestasiRef)
                                            {{$regis->prestasiRef->posisi}}
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
                                                        @php
                                                            $regis_json = json_encode($regis);
                                                        @endphp
                                                        <a class="dropdown-item" href="#" onclick="statusJuara({{$regis_json}})"><i class="dw dw-fire"></i>Status Juara</a>
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

{{-- Modal Prestasi --}}
<div style="border: none !important" class="modal fade" id="modal-prestasi"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-orange" id="myLargeModalLabel"><i class="icon-copy dw-fire1 mr-2"></i>Update Status Juara</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="" id="form-prestasi" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="regis_id" id="eventeksternal_regis_id-inp">
                    <div class="form-group">
                        <label for="">Posisi</label>
                        <select name="posisi" class="form-control" id="posisi-select">
                            @php
                                for($i = 1; $i <= 10; $i++):
                            @endphp
                                <option value="{{$i}}">{{$i}}</option>
                            @php
                                endfor;
                            @endphp
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Catatan</label>
                       <textarea name="catatan" id="catatan-prestasi" class="form-control"></textarea>
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
    let id_event = "{{$ee->id_event_eksternal}}";
    let status = "all";
    $(document).ready( function () {
        var table = $('.pendaftaran-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
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
                },
                {
                    text: 'Export Excel',
                    action: function ( e, dt, node, config ) {
                        let url = "/ormawa/eventeksternal/pendaftar/export/"+id_event+"/"+status;
                        window.location = url;
                    }
                }
            ],
            
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

                table.column(3).search($(this).val()).draw(); 
            });
        });
    } );

   const statusJuara = (values) => {
       event.preventDefault();
       let url = "/ormawa/prestasi/eventeksternal";
       $('#form-prestasi').attr('action', url)

       $('#modal-prestasi').modal('show');

       $('#eventeksternal_regis_id-inp').val(values.id_event_eksternal_registration);

       $('#catatan-prestasi').text(values.prestasi_ref.catatan);
   }

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