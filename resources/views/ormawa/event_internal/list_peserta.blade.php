@extends('ormawa.app')

@section('title','Event')

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="pd-20 card">
            <div class="card-body">
                <table class="checkbox-datatable table nowrap">
                    <thead>
                        <tr>
                            <th>asdasd
                            </th>
                            <th>Nama</th>
                            <th>Status Peserta</th>
                            <th>Tanggal Pendaftaran</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>asdad</td>
                            <td>sadasd</td>
                            <td>asdasd</td>
                            <td>asdasd</td>
                            <td>asdads</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready( function () {
        $('.checkbox-datatable').DataTable();
    } );
</script>
@endpush