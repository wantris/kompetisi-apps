@extends('ormawa.app')

@section('title','Timeline Event')

@push('css')
<style>
    .nav-link:hover {
        color: #f5a461 !important;
    }

    .dataTables_paginate {
        margin-top: 20px !important;
    }

    .dataTables_length,
    #timeline-table_filter {
        margin-bottom: 20px !important;
    }
</style>
@endpush

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        @if ($dosen)
                            <p class="h5 text-orange"><i class="icon-copy dw dw-time-management mr-2"></i>Riwayat Pembina {{$dosen->nama_dosen}}
                            </p>
                        @else
                            <p class="h5 text-orange"><i class="icon-copy dw dw-time-management mr-2"></i>Riwayat Pembina
                            </p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-12 text-right">
                        <div id="container-btn">
                            <a href="{{ url()->previous() }}" id="tambah-btn"
                                class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                Kembali</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 table-responsive">
                        <table id="timeline-table" class="stripe" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>
                                        @if ($dosen)
                                            Nama
                                        @else
                                            NIDN
                                        @endif
                                    </th>
                                    <th>Nama Ormawa</th>
                                    <th>Tahun Jabatan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembinas as $pembina)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            @if ($dosen)
                                                {{$dosen->nama_dosen}}
                                            @else
                                                {{Session::get('nidn')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pembina->ormawaRef)
                                                {{$pembina->ormawaRef->nama_ormawa}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$pembina->tahun_jabatan}}
                                        </td>
                                        <td class="py-2">
                                            @if ($pembina->status == "1")
                                                <a href="#" style="font-size: 12px" class="btn btn-success btn-sm">Aktif</a>
                                            @else
                                                <a href="#" style="font-size: 12px" class="btn btn-danger btn-sm">Tidak Aktif</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
        $('#timeline-table').DataTable();
    } );

    const deleteTimeline = (id_timeline) => {
        let url = "/ormawa/timeline/delete/"+id_timeline;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Timeline',
            'Apakah anda yakin ingin menghapus?',
            'Yes',
            'No',
        function(){ 
            $.ajax(
                {
                    url: url,
                    type: 'delete', 
                    dataType: "JSON",
                    data: {
                        "id_timeline": id_timeline
                    },
                    success: function (response){
                        console.log(response.status); 
                        if(response.status == 1){
                            Notiflix.Notify.Success(response.message);
                            $('#tr_' + id_timeline).remove();
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