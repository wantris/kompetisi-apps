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
        <div class="card mb-3">
            <div class="card-body">
                <div class="tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-orange" data-toggle="tab" href="#internal" role="tab"
                                aria-selected="true">Timline Event Internal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-orange" data-toggle="tab" href="#eksternal" role="tab"
                                aria-selected="false">Timeline Event Eksternal</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="internal" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <p class="h5 text-orange"><i class="icon-copy dw dw-time-management mr-2"></i>TIMLINE
                                    EVENT INTERNAL
                                </p>
                            </div>
                            <div class="col-lg-6 col-12 text-right">
                                @if (Session::get('is_pembina')=="0" )
                                <div id="container-btn">
                                    <a href="{{route('ormawa.timeline.add','eventinternal')}}" id="tambah-btn"
                                        class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                        Tambah</a>
                                </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 ">
                                <table id="timeline-internal-table" class="stripe" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Event</th>
                                            <th>Tanggal jadwal</th>
                                            <th>Title</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tlis as $tli)
                                        <tr class="spacer" id="tr_{{$tli->id_timeline}}">
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$tli->eventInternalRef->nama_event}}</td>
                                            <td>
                                                @php
                                                $tgljadwal =
                                                Carbon\Carbon::parse($tli->tgl_jadwal)->toDatetime()->format('d M
                                                Y');
                                                @endphp
                                                {{$tgljadwal}}
                                            </td>
                                            <td>
                                                {{$tli->title}}
                                            </td>
                                            <td class="py-2">
                                                @php
                                                    $tliJson = json_encode($tli);
                                                @endphp
                                                @if (Session::get('is_pembina')=="0" )
                                                <a href="{{route('ormawa.timeline.editinternal', $tli->id_timeline)}}"
                                                    class="btn btn-info btn-sm d-inline"><i
                                                        class="icofont-ui-edit"></i></a>
                                                <a href="#" onclick="deleteTimeline({{$tliJson}})"
                                                    class="btn btn-danger btn-sm d-inline"><i
                                                        class="icofont-trash"></i></a>
                                                @else
                                                <a href="{{route('ormawa.timeline.editinternal', $tli->id_timeline)}}"
                                                    class="btn btn-info btn-sm d-inline"><i
                                                        class="icofont-eye-alt"></i></a>
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
                <div class="tab-pane fade" id="eksternal" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <p class="h5 text-orange"><i class="icon-copy dw dw-time-management mr-2"></i>TIMELINE
                                    EVENT EKSTERNAL
                                </p>
                            </div>
                            <div class="col-lg-6 col-12 text-right">
                                @if (Session::get('is_pembina')=="0" )
                                <div id="container-btn">
                                    <a href="{{route('ormawa.timeline.add','eventeksternal')}}" id="tambah-btn"
                                        class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                        Tambah</a>
                                </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table id="timeline-eksternal-table" class="stripe" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Event</th>
                                            <th>Tanggal jadwal</th>
                                            <th>Title</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tles as $tle)
                                        <tr class="spacer" id="tr_{{$tle->id_timeline}}">
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$tle->eventEksternalRef->nama_event}}</td>
                                            <td>
                                                @php
                                                $tgljadwal =
                                                Carbon\Carbon::parse($tle->tgl_jadwal)->toDatetime()->format('d M
                                                Y');
                                                @endphp
                                                {{$tgljadwal}}
                                            </td>
                                            <td>
                                                {{$tle->title}}
                                            </td>
                                            <td class="py-2">
                                                @php
                                                    $tleJson = json_encode($tle);
                                                @endphp
                                                @if (Session::get('is_pembina')=="0" )
                                                    <a href="{{route('ormawa.timeline.editeksternal', $tle->id_timeline)}}"
                                                        class="btn btn-info btn-sm d-inline"><i
                                                            class="icofont-ui-edit"></i></a>
                                                    <a href="#" onclick="deleteTimeline({{$tleJson}})"
                                                        class="btn btn-danger btn-sm d-inline"><i
                                                            class="icofont-trash"></i></a>
                                                @else
                                                    <a href="{{route('ormawa.timeline.editeksternal', $tle->id_timeline)}}"
                                                        class="btn btn-info btn-sm d-inline"><i
                                                            class="icofont-eye-alt"></i></a>
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
        $('#timeline-internal-table, #timeline-eksternal-table').DataTable();
    } );

    const deleteTimeline = (values) => {
        let id_timeline = values.id_timeline;
        let url = "/ormawa/timeline/delete/"+id_timeline;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            values.title,
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