@extends('ormawa.app')

@section('title','Kompetisi')

@push('css')
<style>
    .nav-link:hover {
        color: #f5a461 !important;
    }
    .dataTables_paginate {margin-top: 20px !important;}
    .dataTables_length, #timeline-table_filter{margin-bottom: 20px !important;}
    .buttons-excel{
        font-size: 11px;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
@endpush

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="card">
            <div class="card-body">
                 <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-blue" data-toggle="tab" href="#active" role="tab" aria-selected="true">Event Aktif</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-blue" data-toggle="tab" href="#all" role="tab" aria-selected="false">Semua Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-blue" data-toggle="tab" href="#draft" role="tab" aria-selected="false">Event Tidak Aktif</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pd-20 card mt-3">
            <div class="card-body">
                <div class="tab">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="active" role="tabpanel">
                         {{-- Data Event aktif --}}
                                <div class="">
                                    <div class="col-3">
                                        <select id="status_validasi" class="select-status form-control mb-2">
                                            <option selected>Status Validasi</option>
                                            <option value="Tervalidasi">Tervalidasi</option>
                                            <option value="Belum">Belum</option>
                                        </select>
                                    </div>
                                    <table class="table nowrap stripe" style="width: 100%" id="event-active">
                                        <thead>
                                            <tr>
                                                <th>Nama Event</th>
                                                <th>Kategori</th>
                                                <th>Tipe Peserta</th>
                                                <th>Kuota Maks</th>
                                                <th>Role Event</th>
                                                <th>Tanggal Pembukaan</th>
                                                <th>Tanggal Tutup</th>
                                                <th>Status Validasi</th>
                                                <th>Status Validasi</th>
                                                <th class="datatable-nosort">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($eias as $eia)
                                                <tr class="tr_{{$eia->nama_event}}">
                                                    <td>{{$eia->nama_event}}</td>
                                                    <td>{{$eia->kategoriRef->nama_kategori}}</td>
                                                    <td>{{$eia->tipePesertaRef->nama_tipe}}</td>
                                                    <td>{{$eia->maks_participant}}</td>
                                                    <td>{{$eia->role}}</td>
                                                    <td>
                                                        @php
                                                        $tglbuka = Carbon\Carbon::parse($eia->tgl_buka)->toDatetime()->format('d M
                                                        Y');
                                                        @endphp
                                                        {{$tglbuka}}
                                                    </td>
                                                    <td>
                                                        @php
                                                        $tgltutup = Carbon\Carbon::parse($eia->tgl_tutup)->toDatetime()->format('d M
                                                        Y');
                                                        @endphp
                                                        {{$tgltutup}}
                                                    </td>
                                                    <td>
                                                        @if ($eia->status_validasi)
                                                           Tervalidasi
                                                        @else
                                                            Belum
                                                        @endif
                                                    </td>
                                                    <td class="px-2">
                                                        @if ($eia->status_validasi)
                                                            <a href="#" style="font-size: 11px;" class="btn btn-success">Tervalidasi</a>
                                                        @else
                                                            <a href="#" style="font-size: 11px;" class="btn btn-danger">Belum</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                                <i class="dw dw-more"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                <a class="dropdown-item" target="_blank" href="{{route('ormawa.eventinternal.publik', $eia->id_event_internal)}}"><i class="dw dw-eye"></i>Lihat Publik</a>
                                                                <a class="dropdown-item" href="{{route('ormawa.eventinternal.peserta', 'Seminar-Teknologi')}}"><i class="icon-copy dw dw-user-11"></i>Pendaftar</a>
                                                                @php
                                                                    $eiaJson = json_encode($eia);
                                                                @endphp
                                                                <a class="dropdown-item" onclick="lihatDetail({{$eiaJson}})" href="#"><i class="dw dw-polaroids"></i>Detail</a>
                                                                @if ($eia->status_validasi== 1)
                                                                    <a class="dropdown-item" onclick="changeStatus({{$eiaJson}})" href="#"><i class="dw dw-checked"></i>Ubah Status</a>
                                                                @endif
                                                                <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                                <a class="dropdown-item" onclick="deleteEvent({{$eiaJson}})" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            <!-- Checkbox select Datatable End -->
                    {{-- End data Event draft --}}
                    </div>

                    <div class="tab-pane fade" id="all" role="tabpanel">
                        {{-- Data semua Event --}}
                                <div class="table-responsive">
                                    <div class="col-3">
                                        <select id="status_validasi" class="select-status form-control mb-2">
                                            <option selected>Status Validasi</option>
                                            <option value="Tervalidasi">Tervalidasi</option>
                                            <option value="Belum">Belum</option>
                                        </select>
                                    </div>
                                    <table class="table nowrap stripe" style="width: 100%" id="event-all">
                                        <thead>
                                            <tr>
                                                <th>Nama Event</th>
                                                <th>Kategori</th>
                                                <th>Tipe Peserta</th>
                                                <th>Kuota Maks</th>
                                                <th>Role Event</th>
                                                <th>Tanggal Pembukaan</th>
                                                <th>Tanggal Tutup</th>
                                                <th>Status Validasi</th>
                                                <th>Status Validasi</th>
                                                <th class="datatable-nosort">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($eis as $ei)
                                                <tr class="tr_{{$ei->nama_event}}">
                                                    <td>{{$ei->nama_event}}</td>
                                                    <td>{{$ei->kategoriRef->nama_kategori}}</td>
                                                    <td>{{$ei->tipePesertaRef->nama_tipe}}</td>
                                                    <td>{{$ei->maks_participant}}</td>
                                                    <td>{{$ei->role}}</td>
                                                    <td>
                                                        @php
                                                        $tglbuka = Carbon\Carbon::parse($ei->tgl_buka)->toDatetime()->format('d M
                                                        Y');
                                                        @endphp
                                                        {{$tglbuka}}
                                                    </td>
                                                    <td>
                                                        @php
                                                        $tgltutup = Carbon\Carbon::parse($ei->tgl_tutup)->toDatetime()->format('d M
                                                        Y');
                                                        @endphp
                                                        {{$tgltutup}}
                                                    </td>
                                                    <td>
                                                        @if ($ei->status_validasi)
                                                           Tervalidasi
                                                        @else
                                                            Belum
                                                        @endif
                                                    </td>
                                                    <td class="px-2">
                                                        @if ($ei->status_validasi)
                                                            <a href="#" style="font-size: 11px;" class="btn btn-success">Tervalidasi</a>
                                                        @else
                                                            <a href="#" style="font-size: 11px;" class="btn btn-danger">Belum</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                                <i class="dw dw-more"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                <a class="dropdown-item" target="_blank" href="{{route('ormawa.eventinternal.publik', $ei->id_event_internal)}}"><i class="dw dw-eye"></i>Lihat Publik</a>
                                                                <a class="dropdown-item" href="{{route('ormawa.eventinternal.peserta', 'Seminar-Teknologi')}}"><i class="icon-copy dw dw-user-11"></i>Pendaftar</a>
                                                                @php
                                                                    $eiJson = json_encode($ei);
                                                                @endphp
                                                                <a class="dropdown-item" onclick="lihatDetail({{$eiJson}})" href="#"><i class="dw dw-polaroids"></i>Detail</a>
                                                                @if ($ei->status_validasi== 1)
                                                                    <a class="dropdown-item" onclick="changeStatus({{$eiJson}})" href="#"><i class="dw dw-checked"></i>Ubah Status</a>
                                                                @endif
                                                                <a class="dropdown-item" href="{{route('ormawa.eventinternal.edit', $ei->id_event_internal)}}"><i class="dw dw-edit2"></i> Edit</a>
                                                                <a class="dropdown-item" onclick="deleteEvent({{$eiJson}})" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            <!-- Checkbox select Datatable End -->
                        {{-- end data semua Event  --}}
                    </div>
                    <div class="tab-pane fade" id="draft" role="tabpanel">
                        {{-- Data Event draft --}}
                                <div class="table-responsive">
                                    <div class="col-3">
                                        <select id="status_validasi" class="select-status form-control mb-2">
                                            <option selected>Status Validasi</option>
                                            <option value="Tervalidasi">Tervalidasi</option>
                                            <option value="Belum">Belum</option>
                                        </select>
                                    </div>
                                    <table class="stripe table nowrap" style="width: 100% !important" id="event-inactive">
                                        <thead>
                                            <tr>
                                                <th>Nama Event</th>
                                                <th>Kategori</th>
                                                <th>Tipe Peserta</th>
                                                <th>Kuota Maks</th>
                                                <th>Role Event</th>
                                                <th>Tanggal Pembukaan</th>
                                                <th>Tanggal Tutup</th>
                                                <th>Status Validasi</th>
                                                <th>Status Validasi</th>
                                                <th class="datatable-nosort">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($eiss as $eis)
                                                 <tr class="tr_{{$eis->nama_event}}">
                                                    <td>{{$eis->nama_event}}</td>
                                                    <td>{{$eis->kategoriRef->nama_kategori}}</td>
                                                    <td>{{$eis->tipePesertaRef->nama_tipe}}</td>
                                                    <td>{{$eis->maks_participant}}</td>
                                                    <td>{{$eis->role}}</td>
                                                    <td>
                                                        @php
                                                        $tglbuka = Carbon\Carbon::parse($eis->tgl_buka)->toDatetime()->format('d M
                                                        Y');
                                                        @endphp
                                                        {{$tglbuka}}
                                                    </td>
                                                    <td>
                                                        @php
                                                        $tgltutup = Carbon\Carbon::parse($eis->tgl_tutup)->toDatetime()->format('d M
                                                        Y');
                                                        @endphp
                                                        {{$tgltutup}}
                                                    </td>
                                                    <td>
                                                        @if ($eis->status_validasi)
                                                           Tervalidasi
                                                        @else
                                                            Belum
                                                        @endif
                                                    </td>
                                                    <td class="px-2">
                                                        @if ($eis->status_validasi)
                                                            <a href="#" style="font-size: 11px;" class="btn btn-success">Tervalidasi</a>
                                                        @else
                                                            <a href="#" style="font-size: 11px;" class="btn btn-danger">Belum</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                                <i class="dw dw-more"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                <a class="dropdown-item" target="_blank" href="{{route('ormawa.eventinternal.publik', $eis->id_event_internal)}}"><i class="dw dw-eye"></i>Lihat Publik</a>
                                                                <a class="dropdown-item" href="{{route('ormawa.eventinternal.peserta', 'Seminar-Teknologi')}}"><i class="icon-copy dw dw-user-11"></i>Pendaftar</a>
                                                                @php
                                                                    $eisJson = json_encode($eis);
                                                                @endphp
                                                                <a class="dropdown-item" onclick="lihatDetail({{$eisJson}})" href="#"><i class="dw dw-polaroids"></i>Detail</a>
                                                                @if ($eis->status_validasi== 1)
                                                                    <a class="dropdown-item" onclick="changeStatus({{$eisJson}})" href="#"><i class="dw dw-checked"></i>Ubah Status</a>
                                                                @endif
                                                                <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                                <a class="dropdown-item" onclick="deleteEvent({{$eisJson}})" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            <!-- Checkbox select Datatable End -->
                        {{-- End data kompetisi draft --}}
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="status-event-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="status-title-det"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('ormawa.eventinternal.statusupdate')}}" method="post">
                @csrf
                @method('patch')
                <div class="modal-body">
                        <div class="form-group">
                            <label for="">Status Event</label>
                            <input type="hidden" name="id_eventinternal" id="id-event-inp">
                            <select name="status" class="form-control" id="status-inp-modal">
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </form>
            </div>
        </div>
    </div>

       <div class="modal fade" id="detail-event-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="event-title-det"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Tipe Peserta</label>
                    <input type="text" disabled class="form-control" id="tipe-det">
                </div>
                <div class="form-group">
                    <label for="">Kuota Maks</label>
                    <input type="text" disabled class="form-control" id="kuota-det">
                </div>
                <div class="form-group">
                    <label for="">Deskripsi</label>
                    <div id="deskripsi-det"></div>
                </div>
                <div class="form-group">
                    <label for="">Ketentuan</label>
                    <div id="ketentuan-det"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

    <!--DateRangePicker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready( function () {
              var table =  $("#event-inactive, #event-all, #event-active").DataTable({
                        columnDefs: [
                            {
                                targets: "datatable-nosort",
                                orderable: false,
                            },
                            {
                                "targets": [  3, 4, 6, 7],
                                "visible": false,
                                "searchable": false
                            },
                        ],
                        scrollCollapse: true,
                        autoWidth: false,
                        responsive: true,
                        
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"],
                        ],
                        language: {
                            info: "_START_-_END_ of _TOTAL_ entries",
                            searchPlaceholder: "Search",
                            paginate: {
                                next: '<i class="ion-chevron-right"></i>',
                                previous: '<i class="ion-chevron-left"></i>',
                            },
                        },
                        dom: "Bfrtp",
                        buttons: [
                            {
                                extend: "excelHtml5",
                                title: 'Data Event Internal',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                                },
                            },
                        ],
                });

                $('.select-status').each(function(){
                    $(this).on('change', function(){
                        table.search(this.value).draw();   
                    });
                });
        });

        

        const lihatDetail = (value) => {
            event.preventDefault();
            $('#detail-event-modal').modal('show');
            $('#event-title-det').text(value.nama_event);
            $('#tipe-det').val(value.tipe_peserta_ref.nama_tipe);
            $('#kuota-det').val(value.maks_participant);
            $('#deskripsi-det').html(value.deskripsi);
            $('#ketentuan-det').html(value.ketentuan);
        }

        const changeStatus = (values) => {
            event.preventDefault();
            $('#status-event-modal').modal('show');
            $('#id-event-inp').val(values.id_event_internal);
            $('#status-title-det').text("Status "+values.nama_event);
            
            if(values.status == 1){
                let html = `
                    <option selected value="${values.status}">
                        Aktif
                    </option>
                    <option value="0">
                        Tidak Aktif
                    </option>
                `;
                $('#status-inp-modal').html(html);
            }else{
                let html = `
                    <option selected value="${values.status}">
                        Tidak Aktif
                    </option>
                    <option value="1">
                        Aktif
                    </option>
                `;
                $('#status-inp-modal').html(html);
            }
        }

    const deleteEvent = (values) => {
        let url = "/ormawa/eventinternal/delete/"+values.id_event_internal;
        console.log(url);
        event.preventDefault();
        Notiflix.Confirm.Show( 
            values.nama_event,
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
                        "id_eventinternal": values.id_event_internal
                    },
                    success: function (response){
                        console.log(response.status); 
                        if(response.status == 1){
                            Notiflix.Notify.Success(response.message);
                            $('.tr_' + values.nama_event).remove();
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