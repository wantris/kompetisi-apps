@extends('ormawa.app')

@section('title','Settings Profile')

@push('css')
<style>
    .nav-link:hover {
        color: #f5a461 !important;
    }
</style>
@endpush

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="card">
            <div class="tab-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="h5 text-orange" id="title-pembina"><i class="icon-copy dw dw-user-2 mr-2"></i>FORM UPDATE DATA PEMBINA
                                </p>
                            </div>
                            <div class="col-6 text-right">
                                <div id="container-btn">
                                    <a href="{{route('ormawa.settings.index')}}"  class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                        Kembali</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row" id="form-pembina">
                            <div class="col-12">
                                <form action="{{route('ormawa.settings.update.pembina', $pb->id_pembina)}}" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="form-group">
                                        <label for="">Nama Dosen</label>
                                        <select class="js-example-basic-single" style="width: 100%" name="nama_dosen">
                                            <option value="{{$dosen->nidn}}" selected>{{$dosen->nama_dosen}}</option>
                                            @foreach ($dosens as $ds)
                                                <option value="{{$ds->nidn}}">{{$ds->nama_dosen}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('nama_dosen'))
                                            <span class="text-danger">{{ $errors->first('nama_dosen') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Tahun Jabatan</label>
                                        <select name="tahun_jabatan" id="" class="form-control">
                                            <option value="{{$pb->tahun_jabatan}}" selected>{{$pb->tahun_jabatan}}</option>
                                            @for ($i = 2015; $i <= date('Y'); $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                        @if ($errors->has('tahun_jabatan'))
                                            <span class="text-danger">{{ $errors->first('tahun_jabatan') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Status Keaktifan</label>
                                        <select name="status" id="" class="form-control">
                                            @if ($pb->status == 1)
                                                <option selected value="{{$pb->status}}" selected>Aktif</option>
                                                <option value="0">Tidak</option>
                                            @else
                                                <option selected value="{{$pb->status}}" selected>Tidak</option>
                                                <option value="1">Aktif</option>
                                            @endif
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
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
@endsection

