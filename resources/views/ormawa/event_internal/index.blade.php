@extends('ormawa.app')

@section('title','Kompetisi')

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="pd-20 card-box">
            <div class="tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-blue" data-toggle="tab" href="#active" role="tab" aria-selected="true">Event Aktif</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-blue" data-toggle="tab" href="#all" role="tab" aria-selected="false">Semua Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-blue" data-toggle="tab" href="#draft" role="tab" aria-selected="false">Draft Event</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="active" role="tabpanel">
                         {{-- Data Event aktif --}}
                            <div class="card-box mb-30 mt-4">
                                <div class="pd-20">
                                    <h4 class="text-blue h4">Data Event Aktif</h4>
                                </div>
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
                                                <th>Kategori</th>
                                                <th>Tanggal penutupan</th>
                                                <th>Maks. pendatfar</th>
                                                <th class="datatable-nosort">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td>Tiger Nixon</td>
                                                <td>System Architect</td>
                                                <td>Tokyo</td>
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
                                                <td>Chief Executive Officer (CEO)</td>
                                                <td>London</td>
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
                                                <td>Junior Technical Author</td>
                                                <td>San Francisco</td>
                                                <td>2009/01/12</td>
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
                                                <td>Software Engineer</td>
                                                <td>London</td>
                                                <td>2012/10/13</td>
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
                                                <td>Software Engineer</td>
                                                <td>San Francisco</td>
                                                <td>2011/06/07</td>
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
                                                <td>Pre-Sales Support</td>
                                                <td>New York</td>
                                                <td>2011/12/12	</td>
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
                            <!-- Checkbox select Datatable End -->
                    {{-- End data Event draft --}}
                    </div>

                    <div class="tab-pane fade" id="all" role="tabpanel">
                        {{-- Data semua Event --}}
                            <div class="card-box mb-30 mt-4">
                                <div class="pd-20">
                                    <h4 class="text-blue h4">Data Semua Event</h4>
                                </div>
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
                                                <th>Kategori</th>
                                                <th>Tanggal penutupan</th>
                                                <th>Maks. pendatfar</th>
                                                <th class="datatable-nosort">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td>Tiger Nixon</td>
                                                <td>System Architect</td>
                                                <td>Tokyo</td>
                                                <td>2008/11/28</td>
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
                                                <td>Angelica Ramos</td>
                                                <td>Chief Executive Officer (CEO)</td>
                                                <td>London</td>
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
                                                <td>Junior Technical Author</td>
                                                <td>San Francisco</td>
                                                <td>2009/01/12</td>
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
                                                <td>Software Engineer</td>
                                                <td>London</td>
                                                <td>2012/10/13</td>
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
                                                <td>Software Engineer</td>
                                                <td>San Francisco</td>
                                                <td>2011/06/07</td>
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
                                                <td>Pre-Sales Support</td>
                                                <td>New York</td>
                                                <td>2011/12/12	</td>
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
                            <!-- Checkbox select Datatable End -->
                        {{-- end data semua Event  --}}
                    </div>
                    <div class="tab-pane fade" id="draft" role="tabpanel">
                        {{-- Data Event draft --}}
                            <div class="card-box mb-30 mt-4">
                                <div class="pd-20">
                                    <h4 class="text-blue h4">Data Event Draft</h4>
                                </div>
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
                                                <th>Kategori</th>
                                                <th>Tanggal penutupan</th>
                                                <th>Maks. pendatfar</th>
                                                <th class="datatable-nosort">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td>Tiger Nixon</td>
                                                <td>System Architect</td>
                                                <td>Tokyo</td>
                                                <td>2008/11/28</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>Lihat</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                            <a class="dropdown-item" href="#"><i class="icon-copy dw dw-checked"></i>Buat Aktif</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Angelica Ramos</td>
                                                <td>Chief Executive Officer (CEO)</td>
                                                <td>London</td>
                                                <td>2009/10/09</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>Lihat</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                            <a class="dropdown-item" href="#"><i class="icon-copy dw dw-checked"></i>Buat Aktif</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Ashton Cox</td>
                                                <td>Junior Technical Author</td>
                                                <td>San Francisco</td>
                                                <td>2009/01/12</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>Lihat</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                            <a class="dropdown-item" href="#"><i class="icon-copy dw dw-checked"></i>Buat Aktif</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Bradley Greer</td>
                                                <td>Software Engineer</td>
                                                <td>London</td>
                                                <td>2012/10/13</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>Lihat</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                            <a class="dropdown-item" href="#"><i class="icon-copy dw dw-checked"></i>Buat Aktif</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Brenden Wagner</td>
                                                <td>Software Engineer</td>
                                                <td>San Francisco</td>
                                                <td>2011/06/07</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>Lihat</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                            <a class="dropdown-item" href="#"><i class="icon-copy dw dw-checked"></i>Buat Aktif</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Caesar Vance</td>
                                                <td>Pre-Sales Support</td>
                                                <td>New York</td>
                                                <td>2011/12/12	</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>Lihat</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                                            <a class="dropdown-item" href="#"><i class="icon-copy dw dw-checked"></i>Buat Aktif</a>
                                                            <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Checkbox select Datatable End -->
                        {{-- End data kompetisi draft --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection