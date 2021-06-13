@extends('ormawa.app')

@section('title','Event')

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="pd-20 card-box">
            <div class="tab">
                <div class="row clearfix">
                    <div class="col-md-3 col-sm-12">
                        <ul class="nav flex-column vtabs nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-selected="true">Tahapan Pertama</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-selected="false">Tahapan Kedua</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#contact3" role="tab" aria-selected="false">Tahapan ketiga</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-9 col-sm-12">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="home3" role="tabpanel">
                                <div class="pb-20 table-responsive">
                                    <table class="checkbox-datatable table nowrap">
                                        <thead>
                                            <tr>
                                                <th><div class="dt-checkbox">
                                                        <input type="checkbox" name="select_all" value="1" id="example-select-all">
                                                        <span class="dt-checkbox-label"></span>
                                                    </div>
                                                </th>
                                                <th>Nama</th>
                                                <th>Status Peserta</th>
                                                <th>Tanggal Pendaftaran</th>
                                                <th class="datatable-nosort">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td>Tiger Nixon</td>
                                                <td>Eksternal</td>
                                                <td>2008/11/28</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>Lihat</a>
                                                            <a class="dropdown-item" href="{{route('ormawa.event.peserta', 'Seminar-Teknologi')}}"><i class="icon-copy dw dw-user-11"></i>Pendaftar</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Angelica Ramos</td>
                                                <td>Mahasiswa Polindra</td>
                                                <td>2009/10/09</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>Lihat</a>
                                                            <a class="dropdown-item" href="#"><i class="icon-copy dw dw-user-11"></i>Pendaftar</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Ashton Cox</td>
                                                <td>Mahasiswa Polindra</td>
                                                <td>2009/10/09</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>Lihat</a>
                                                            <a class="dropdown-item" href="#"><i class="icon-copy dw dw-user-11"></i>Pendaftar</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Bradley Greer</td>
                                                <td>Eksternal</td>
                                                <td>2009/10/09</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>Lihat</a>
                                                            <a class="dropdown-item" href="#"><i class="icon-copy dw dw-user-11"></i>Pendaftar</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Brenden Wagner</td>
                                                <td>Mahasiswa Polindra</td>
                                                <td>2009/10/09</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>Lihat</a>
                                                            <a class="dropdown-item" href="#"><i class="icon-copy dw dw-user-11"></i>Pendaftar</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Caesar Vance</td>
                                                <td>Mahasiswa Polindra</td>
                                                <td>2009/10/09</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>Lihat</a>
                                                            <a class="dropdown-item" href="#"><i class="icon-copy dw dw-user-11"></i>Pendaftar</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile3" role="tabpanel">
                                <div class="pd-20">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact3" role="tabpanel">
                                <div class="pd-20">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection