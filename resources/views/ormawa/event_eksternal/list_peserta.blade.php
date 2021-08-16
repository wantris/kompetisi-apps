@extends('ormawa.app')

@section('title','Event')

@push('css')
    <style>
        .select2-container--default .select2-selection--multiple {
            min-height: 40px;
            border-color: #d4d4d4;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e86b32 !important;
            color: #fff !important;
            border-color: #e86b32 !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e4e4e4;
            font-size: 12px;
            padding: 0px 20px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            padding-top: 3px;
        }
        .select2-selection__choice__remove {
            color: #fff !important;
        }
    </style>
@endpush

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="pd-20 card mb-3">
            <div class="card-body">
                <div class="tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-orange" data-toggle="tab" href="#list-tab" role="tab"
                                aria-selected="true">Daftar Peserta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-orange" data-toggle="tab" href="#tahapan-tab" role="tab"
                                aria-selected="true">Tambahkan Ke Tahapan</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link text-orange" data-toggle="tab" href="#status-juara" role="tab"
                                aria-selected="false">Status Juara</a>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </div>
        <div class="pd-20 card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="list-tab" role="tabpanel">
                        <div class="row">
                            <div class="mb-2 col-12 col-lg-3">
                                <select id="status-select" class="form-control">
                                    <option value="" selected>Semua Status</option>
                                    <option value="Sudah">Tervalidasi</option>
                                    <option value="Tidak">Belum Tervalidasi</option>
                                </select>
                             </div>
                             <div class="mb-2 col-12 col-lg-3">
                                 <select id="tahapan-select" class="form-control">
                                     <option value="" selected>Semua Tahapan</option>
                                     @foreach ($tahapans as $tahapan)
                                         <option value="{{$tahapan->nama_tahapan}}">{{$tahapan->nama_tahapan}}</option>
                                     @endforeach
                                 </select>
                             </div>
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
                                            <th>Tahapan</th>
                                            <th>Tahapan Terakhir</th>
                                            {{-- <th>Sudah Tervalidasi</th> --}}
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
                                                    @if ($regis->tahapanRegisRef->count() > 0)
                                                        @foreach ($regis->tahapanRegisRef as $tahapan_regis)
                                                            <i class="icon-copy dw dw-fire" style="color: #ff0000;font-weight:bold !important"></i>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($regis->tahapanRegisRef->count() > 0)
                                                        {{$regis->tahapanRegisRef[0]->tahapanEventEksternal->nama_tahapan}}
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
                                                            @php
                                                                $regis_json = json_encode($regis);
                                                                $tahapan_json = json_encode($regis->tahapanRegisRef);
                                                            @endphp
                                                            <a class="dropdown-item" target="_blank" href="#"><i class="dw dw-eye"></i>Lihat Profil</a>
                                                            <a class="dropdown-item" href="#" onclick="seeTahapanHistory({{$tahapan_json}})"><i class="dw dw-clipboard1"></i>Riwayat Tahapan</a>
                                                            @if (Session::get('is_pembina') == "0")
                                                                <a class="dropdown-item" href="{{route('ormawa.tahapan.eventeksternal.pendaftaran.save',['regisid'=>$regis->id_event_eksternal_registration,'eventid'=>$regis->event_eksternal_id])}}"><i class="icon-copy dw dw-fire"></i>Lolos ke tahapan selanjutnya</a>
                                                                @if ($regis->status == "0")
                                                                    <a class="dropdown-item" href="{{route('ormawa.eventeksternal.pendaftar.updatestatus', ['id_regis'=>$regis->id_event_eksternal_registration,'status'=>1])}}"><i class="icon-copy dw dw-checked"></i>Buat Tervalidasi</a>
                                                                @else
                                                                    <a class="dropdown-item" href="{{route('ormawa.eventeksternal.pendaftar.updatestatus', ['id_regis'=>$regis->id_event_eksternal_registration,'status'=>0])}}"><i class="icon-copy dw dw-ban"></i>Buat Belum Tervalidasi</a>
                                                                @endif
                                                                <a class="dropdown-item" href="#" onclick="deletePendaftar({{$regis->id_event_eksternal_registration}})"><i class="dw dw-delete-3"></i> Hapus</a>
                                                                
                                                                <a class="dropdown-item" href="#" onclick="statusJuara({{$regis_json}})"><i class="dw dw-up-chevron-1"></i>Status Juara</a>
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
                                            <th>Tahapan</th>
                                            <th>Tahapan Terakhir</th>
                                            {{-- <th>Sudah Tervalidasi</th> --}}
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
                                                    @if ($regis->tahapanRegisRef->count() > 0)
                                                        @foreach ($regis->tahapanRegisRef as $tahapan_regis)
                                                            <i class="icon-copy dw dw-fire" style="color: #ff0000;font-weight:bold !important"></i>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($regis->tahapanRegisRef->count() > 0)
                                                        {{$regis->tahapanRegisRef[0]->tahapanEventEksternal->nama_tahapan}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($regis->prestasiRef)
                                                    {{$regis->prestasiRef->posisi}}
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        @php
                                                            $regis_json = json_encode($regis);
                                                            $tahapan_json = json_encode($regis->tahapanRegisRef);
                                                        @endphp
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                            href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="{{route('ormawa.team.detail', $regis->tim_event_id)}}"><i class="dw dw-eye"></i>Lihat Tim</a>
                                                            <a class="dropdown-item" href="#" onclick="seeTahapanHistory({{$tahapan_json}})"><i class="dw dw-clipboard1"></i>Riwayat Tahapan</a>
                                                            @if ($regis->status == "0")
                                                                <a class="dropdown-item" href="{{route('ormawa.eventeksternal.pendaftar.updatestatus', ['id_regis'=>$regis->id_event_eksternal_registration,'status'=>1])}}"><i class="icon-copy dw dw-checked"></i>Buat Tervalidasi</a>
                                                            @else
                                                                <a class="dropdown-item" href="{{route('ormawa.eventeksternal.pendaftar.updatestatus', ['id_regis'=>$regis->id_event_eksternal_registration,'status'=>0])}}"><i class="icon-copy dw dw-ban"></i>Buat Belum Tervalidasi</a>
                                                            @endif
                                                            @if (Session::get('is_pembina') == "0")
                                                                <a class="dropdown-item" href="{{route('ormawa.tahapan.eventeksternal.pendaftaran.save',['regisid'=>$regis->id_event_eksternal_registration,'eventid'=>$regis->event_eksternal_id])}}"><i class="icon-copy dw dw-fire"></i>Lolos ke tahapan selanjutnya</a>
                                                            
                                                                <a class="dropdown-item" href="#" onclick="statusJuara({{$regis_json}})"><i class="dw dw-up-chevron-1"></i>Status Juara</a>
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
                    <div class="tab-pane fade" id="tahapan-tab" role="tabpanel">
                        <div class="row mb-3">
                            <div class="col-12">
                                <p class="h5 text-orange"><i class="icon-copy dw dw-up-chevron-1 mr-2"></i>
                                    Tambakan Pendaftaran Ke Tahap Selanjutnya
                                </p>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <form action="{{route('ormawa.tahapan.eventeksternal.pendaftaran.save.multiple')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Tahapan</label>
                                        <select class="form-control" name="tahapan_id" style="width: 100%" >
                                            <option selected>Pilih Tahapan</option>
                                            @foreach ($tahapans as $tahapan)
                                                <option value="{{$tahapan->id_tahapan_event_eksternal}}">{{$tahapan->nama_tahapan}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('tahapan_id'))
                                            <span class="text-danger">{{ $errors->first('tahapan_id') }}</span>
                                        @endif
                                    </div>
                                     <div class="form-group">
                                        <label>Pilih Pendaftar</label>
                                        <select class="custom-select2 form-control" name="regis_id[]" style="width: 100%" multiple="multiple" >
                                            @if ($ee->role == "Individu")
                                                @foreach ($pendaftaran as $regis)
                                                    <option value="{{$regis->id_event_eksternal_registration}}">
                                                        @if ($regis->nim)
                                                            @if ($regis->mahasiswaRef)
                                                                {{$regis->mahasiswaRef->mahasiswa_nama}} 
                                                            @else
                                                                {{$regis->penggunaMshRef->username}}
                                                            @endif
                                                        @else
                                                            {{$regis->participantRef->nama_participant}}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach ($pendaftaran as $regis)
                                                    @foreach ($regis->timRef->timDetailRef as $detail)
                                                        @if ($detail->role == "ketua")
                                                            @if ($detail->nim)
                                                                @if ($detail->mahasiswaRef)
                                                                    <option value="{{$regis->id_event_eksternal_registration}}">{{$detail->mahasiswaRef->mahasiswa_nama}}</option>
                                                                @else
                                                                    <option value="{{$regis->id_event_eksternal_registration}}">{{$detail->penggunaMshRef->username}}</option>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('regis_id'))
                                            <span class="text-danger">{{ $errors->first('regis_id') }}</span>
                                        @endif
                                    </div>
                                    <input type="submit"  class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"  style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important" value="Submit">
                                </form>
                            </div>
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

{{-- modal tahapan history --}}
<div style="border: none !important" class="modal fade" id="tahapan-modal"  role="dialog" aria-labelledby="tahapanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-orange" id="myLargeModalLabel"><i class="icon-copy dw-fire1 mr-2"></i>Riwayat Tahapan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="profile-timeline">
                    <div class="profile-timeline-list">
                        <ul id="tahapan-list">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    let id_event = "{{$ee->id_event_eksternal}}";
    let status = "all";

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


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

    const seeTahapanHistory = (tahapans) => {
        event.preventDefault();
        let html = ``;
        tahapans.forEach(function(tahapan,index) {
            let date = new Date(tahapan.created_at);
            let created_at = date.getFullYear()+'-' + (date.getMonth()+1) + '-'+date.getDate();
            html += `
                <li>
                    <div class="task-name ml-2"><i class="icon-copy dw dw-checked" style="left: -27px;" ></i>${tahapan.tahapan_event_eksternal.nama_tahapan}</div>
                    <div class="task-time ml-2">${created_at}</div>
                </li>
            `;
        });
        $('#tahapan-list').html(html);
        $('#tahapan-modal').modal('show');
    }
</script>
@endpush