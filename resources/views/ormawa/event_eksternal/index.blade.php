@extends('ormawa.app')

@section('title','Event eksternal')

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

    .buttons-excel {
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
                        <a class="nav-link active text-orange" data-toggle="tab" href="#active" role="tab"
                            aria-selected="true">Event Aktif</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-orange" data-toggle="tab" href="#all" role="tab"
                            aria-selected="false">Semua Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-orange" data-toggle="tab" href="#draft" role="tab"
                            aria-selected="false">Event Tidak Aktif</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-orange" data-toggle="tab" href="#cakupan" role="tab"
                            aria-selected="false">Event Semua Cakupan</a>
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
                            <div class="row">
                                <div class="col-3">
                                    <select id="status_validasi" class="select-status form-control mb-2">
                                        <option selected value="">Status Validasi</option>
                                        <option value="Sudah">Tervalidasi</option>
                                        <option value="Belum">Belum</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <select id="validasi-pembina" class="select-pembina form-control mb-2">
                                        <option selected value="">Tervalidasi Pembina</option>
                                        <option value="Tervalidasi Pembina">Tervalidasi</option>
                                        <option value="Tidak Tervalidasi">Belum</option>
                                    </select>
                                </div>
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
                                            <th>Validasi Pembina</th>
                                            <th>Status Validasi</th>
                                            <th>Status Validasi</th>
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($eeas as $eea)
                                        <tr class="tr_{{$eea->nama_event}}">
                                            <td>{{$eea->nama_event}}</td>
                                            <td>{{$eea->kategoriRef->nama_kategori}}</td>
                                            <td>{{$eea->tipePesertaRef->nama_tipe}}</td>
                                            <td>{{$eea->maks_participant}}</td>
                                            <td>{{$eea->role}}</td>
                                            <td>
                                                @php
                                                $tglbuka = Carbon\Carbon::parse($eea->tgl_buka)->toDatetime()->format('d
                                                M
                                                Y');
                                                @endphp
                                                {{$tglbuka}}
                                            </td>
                                            <td>
                                                @php
                                                $tgltutup =
                                                Carbon\Carbon::parse($eea->tgl_tutup)->toDatetime()->format('d M
                                                Y');
                                                @endphp
                                                {{$tgltutup}}
                                            </td>
                                            <td>
                                                @if ($eea->pengajuanRef->is_validated_pembina)
                                                Tervalidasi Pembina
                                                @else
                                                Tidak Tervalidasi
                                                @endif
                                            </td>
                                            <td>
                                                @if ($eea->status_validasi)
                                                Sudah
                                                @else
                                                Belum
                                                @endif
                                            </td>
                                            <td class="px-2">
                                                @if ($eea->status_validasi)
                                                <a href="#" style="font-size: 11px;"
                                                    class="btn btn-success">Tervalidasi</a>
                                                @else
                                                <a href="#" style="font-size: 11px;" class="btn btn-danger">Belum</a>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                        href="#" role="button" data-toggle="dropdown">
                                                        <i class="dw dw-more"></i>
                                                    </a>
                                                    @php
                                                    $eeaJson = json_encode($eea);
                                                    @endphp
                                                    <div
                                                        class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                        @if (Session::get('is_pembina') == "0")
                                                      
                                                        <a class="dropdown-item"
                                                            href="{{route('ormawa.eventeksternal.edit', $eea->id_event_eksternal)}}"><i
                                                                class="dw dw-edit2"></i> Edit</a>
                                                        <a class="dropdown-item" onclick="lihatDetail({{$eeaJson}})"
                                                            href="#"><i class="dw dw-polaroids"></i>Detail</a>
                                                        @if ($eea->status_validasi== 1)
                                                        <a class="dropdown-item" onclick="changeStatus({{$eeaJson}})"
                                                            href="#"><i class="dw dw-checked"></i>Ubah Status</a>
                                                        @endif
                                                        <a class="dropdown-item" onclick="deleteEvent({{$eeaJson}})"
                                                            href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        @endif
                                                        <a class="dropdown-item"
                                                            href="{{route('ormawa.eventeksternal.peserta', 'Seminar-Teknologi')}}"><i
                                                                class="icon-copy dw dw-user-11"></i>Pendaftar</a>

                                                        @if (Session::get('is_pembina') == "1")
                                                        <a class="dropdown-item"
                                                            href="{{route('ormawa.eventeksternal.edit', $eea->id_event_eksternal)}}"><i
                                                                class="dw dw-edit2"></i>Detail</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            <!-- Checkbox select Datatable End -->
                            {{-- End data Event draft --}}
                        </div>

                        <div class="tab-pane fade" id="all" role="tabpanel">
                            {{-- Data semua Event --}}
                            <div class="row">
                                <div class="col-3">
                                    <select id="status_validasi" class="select-status form-control mb-2">
                                        <option selected value="">Status Validasi</option>
                                        <option value="Sudah">Tervalidasi</option>
                                        <option value="Belum">Belum</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <select id="validasi-pembina" class="select-pembina form-control mb-2">
                                        <option selected value="">Tervalidasi Pembina</option>
                                        <option value="Tervalidasi Pembina">Tervalidasi</option>
                                        <option value="Tidak Tervalidasi">Belum</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
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
                                            <th>Validasi Pembina</th>
                                            <th>Status Validasi</th>
                                            <th>Status Validasi</th>
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ees as $ee)
                                        <tr class="tr_{{$ee->nama_event}}">
                                            <td>{{$ee->nama_event}}</td>
                                            <td>{{$ee->kategoriRef->nama_kategori}}</td>
                                            <td>{{$ee->tipePesertaRef->nama_tipe}}</td>
                                            <td>{{$ee->maks_participant}}</td>
                                            <td>{{$ee->role}}</td>
                                            <td>
                                                @php
                                                $tglbuka = Carbon\Carbon::parse($ee->tgl_buka)->toDatetime()->format('d
                                                M
                                                Y');
                                                @endphp
                                                {{$tglbuka}}
                                            </td>
                                            <td>
                                                @php
                                                $tgltutup =
                                                Carbon\Carbon::parse($ee->tgl_tutup)->toDatetime()->format('d M
                                                Y');
                                                @endphp
                                                {{$tgltutup}}
                                            </td>
                                            <td>
                                                @if ($ee->pengajuanRef->is_validated_pembina)
                                                Tervalidasi Pembina
                                                @else
                                                Tidak Tervalidasi
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ee->status_validasi)
                                                Sudah
                                                @else
                                                Belum
                                                @endif
                                            </td>
                                            <td class="px-2">
                                                @if ($ee->status_validasi)
                                                <a href="#" style="font-size: 11px;"
                                                    class="btn btn-success">Tervalidasi</a>
                                                @else
                                                <a href="#" style="font-size: 11px;" class="btn btn-danger">Belum</a>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                        href="#" role="button" data-toggle="dropdown">
                                                        <i class="dw dw-more"></i>
                                                    </a>
                                                    @php
                                                    $eeJson = json_encode($ee);
                                                    @endphp
                                                    <div
                                                        class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                        @if (Session::get('is_pembina') == "0")
                                                        <a class="dropdown-item"
                                                            href="{{route('ormawa.eventeksternal.edit', $ee->id_event_eksternal)}}"><i
                                                                class="dw dw-edit2"></i> Edit</a>
                                                        <a class="dropdown-item" onclick="lihatDetail({{$eeJson}})"
                                                            href="#"><i class="dw dw-polaroids"></i>Detail</a>
                                                        @if ($ee->status_validasi== 1)
                                                        <a class="dropdown-item" onclick="changeStatus({{$eeJson}})"
                                                            href="#"><i class="dw dw-checked"></i>Ubah Status</a>
                                                        @endif
                                                        <a class="dropdown-item" onclick="deleteEvent({{$eeJson}})"
                                                            href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        @endif
                                                        <a class="dropdown-item"
                                                            href="{{route('ormawa.eventeksternal.peserta', 'Seminar-Teknologi')}}"><i
                                                                class="icon-copy dw dw-user-11"></i>Pendaftar</a>

                                                        @if (Session::get('is_pembina') == "1")
                                                        <a class="dropdown-item"
                                                            href="{{route('ormawa.eventeksternal.edit', $ee->id_event_eksternal)}}"><i
                                                                class="dw dw-edit2"></i>Detail</a>
                                                        @endif
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
                            <div class="row">
                                <div class="col-3">
                                    <select id="status_validasi" class="select-status form-control mb-2">
                                        <option selected value="">Status Validasi</option>
                                        <option value="Sudah">Tervalidasi</option>
                                        <option value="Belum">Belum</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <select id="validasi-pembina" class="select-pembina form-control mb-2">
                                        <option selected value="">Status Validasi Pembina</option>
                                        <option value="Sudah Tervalidasi Pembina">Tervalidasi</option>
                                        <option value="Tidak Tervalidasi Pembina">Belum</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
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
                                            <th>Validasi Pembina</th>
                                            <th>Status Validasi</th>
                                            <th>Status Validasi</th>
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($eess as $ees)
                                        <tr class="tr_{{$ees->nama_event}}">
                                            <td>{{$ees->nama_event}}</td>
                                            <td>{{$ees->kategoriRef->nama_kategori}}</td>
                                            <td>{{$ees->tipePesertaRef->nama_tipe}}</td>
                                            <td>{{$ees->maks_participant}}</td>
                                            <td>{{$ees->role}}</td>
                                            <td>
                                                @php
                                                $tglbuka = Carbon\Carbon::parse($ees->tgl_buka)->toDatetime()->format('d
                                                M
                                                Y');
                                                @endphp
                                                {{$tglbuka}}
                                            </td>
                                            <td>
                                                @php
                                                $tgltutup =
                                                Carbon\Carbon::parse($ees->tgl_tutup)->toDatetime()->format('d M
                                                Y');
                                                @endphp
                                                {{$tgltutup}}
                                            </td>
                                            <td>
                                                @if ($ees->pengajuanRef->is_validated_pembina)
                                                Sudah Tervalidasi Pembina
                                                @else
                                                Tidak Tervalidasi Pembina
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ees->status_validasi)
                                                Sudah
                                                @else
                                                Belum
                                                @endif
                                            </td>
                                            <td class="px-2">
                                                @if ($ees->status_validasi)
                                                <a href="#" style="font-size: 11px;"
                                                    class="btn btn-success">Tervalidasi</a>
                                                @else
                                                <a href="#" style="font-size: 11px;" class="btn btn-danger">Belum</a>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                        href="#" role="button" data-toggle="dropdown">
                                                        <i class="dw dw-more"></i>
                                                    </a>
                                                    @php
                                                    $eesJson = json_encode($ees);
                                                    @endphp
                                                    <div
                                                        class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                        @if (Session::get('is_pembina') == "0")
                                                        <a class="dropdown-item"
                                                            href="{{route('ormawa.eventeksternal.edit', $ees->id_event_eksternal)}}"><i
                                                                class="dw dw-edit2"></i> Edit</a>
                                                        <a class="dropdown-item" onclick="lihatDetail({{$eesJson}})"
                                                            href="#"><i class="dw dw-polaroids"></i>Detail</a>
                                                        @if ($ees->status_validasi== 1)
                                                        <a class="dropdown-item" onclick="changeStatus({{$eesJson}})"
                                                            href="#"><i class="dw dw-checked"></i>Ubah Status</a>
                                                        @endif
                                                        <a class="dropdown-item" onclick="deleteEvent({{$eesJson}})"
                                                            href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        @endif
                                                        <a class="dropdown-item"
                                                            href="{{route('ormawa.eventeksternal.peserta', 'Seminar-Teknologi')}}"><i
                                                                class="icon-copy dw dw-user-11"></i>Pendaftar</a>

                                                        @if (Session::get('is_pembina') == "1")
                                                        <a class="dropdown-item"
                                                            href="{{route('ormawa.eventeksternal.edit', $ees->id_event_eksternal)}}"><i
                                                                class="dw dw-edit2"></i>Detail</a>
                                                        @endif
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
                        <div class="tab-pane fade" id="cakupan" role="tabpanel">
                            {{-- Data Event semua cakupan --}}
                            <div class="table-responsive">
                                <table class="stripe table nowrap" style="width: 100% !important" id="event-semua-cakupan">
                                    <thead>
                                        <tr>
                                            <th>Nama Event</th>
                                            <th>Kategori</th>
                                            <th>Tipe Peserta</th>
                                            <th>Kuota Maks</th>
                                            <th>Role Event</th>
                                            <th>Tanggal Pembukaan</th>
                                            <th>Tanggal Tutup</th>
                                            <th class="datatable-nosort">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($eescs as $eesc)
                                        <tr class="tr_{{$eesc->nama_event}}">
                                            <td>{{$eesc->nama_event}}</td>
                                            <td>{{$eesc->kategoriRef->nama_kategori}}</td>
                                            <td>{{$eesc->tipePesertaRef->nama_tipe}}</td>
                                            <td>{{$eesc->maks_participant}}</td>
                                            <td>{{$eesc->role}}</td>
                                            <td>
                                                @php
                                                $tglbuka = Carbon\Carbon::parse($eesc->tgl_buka)->toDatetime()->format('d
                                                M
                                                Y');
                                                @endphp
                                                {{$tglbuka}}
                                            </td>
                                            <td>
                                                @php
                                                $tgltutup =
                                                Carbon\Carbon::parse($eesc->tgl_tutup)->toDatetime()->format('d M
                                                Y');
                                                @endphp
                                                {{$tgltutup}}
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                        href="#" role="button" data-toggle="dropdown">
                                                        <i class="dw dw-more"></i>
                                                    </a>
                                                    @php
                                                    $eescJson = json_encode($eesc);
                                                    @endphp
                                                    <div
                                                        class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                        @if (Session::get('is_pembina') == "0")
                                                        <a class="dropdown-item" onclick="lihatDetail({{$eescJson}})"
                                                            href="#"><i class="dw dw-polaroids"></i>Detail</a>
                                                        @endif
                                                        <a class="dropdown-item"
                                                            href="{{route('ormawa.eventeksternal.peserta', 'Seminar-Teknologi')}}"><i
                                                                class="icon-copy dw dw-user-11"></i>Pendaftar</a>
                                                        @if (Session::get('is_pembina') == "1")
                                                        <a class="dropdown-item"
                                                            href="{{route('ormawa.eventeksternal.edit', $eesc->id_event_eksternal)}}"><i
                                                                class="dw dw-edit2"></i>Detail</a>
                                                        @endif
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
    <div class="modal fade" id="status-event-modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="status-title-det"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('ormawa.eventeksternal.statusupdate')}}" method="post">
                    @csrf
                    @method('patch')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Status Event</label>
                            <input type="hidden" name="id_eventeksternal" id="id-event-inp">
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

    <div class="modal fade" id="detail-event-modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                "targets": [3, 4, 6, 8],
                                "visible": false,
                                "searchable": false
                            },
                            {
                                "targets": [7],
                                "visible": false,
                                "searchable": true
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
                                title: 'Data Event eksternal',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6,  8],
                                },
                            },
                        ],
                });

                $('.select-status').each(function(){
                    $(this).on('change', function(){
                        table.search(this.value).draw();   
                    });
                });

                $('.select-pembina').each(function(){
                    $(this).on('change', function(){
                        console.log('hiyaa');
                        table.search(this.value).draw();   
                    });
                });

                $('#event-semua-cakupan').DataTable();

                
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
            $('#id-event-inp').val(values.id_event_eksternal);
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
        let url = "/ormawa/eventeksternal/delete/"+values.id_event_eksternal;
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
                        "id_eventeksternal": values.id_event_eksternal
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