@extends('ormawa.app')

@section('title','Settings Profile')

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <p class="h5 text-orange"><i class="icon-copy dw dw-settings mr-2"></i>FORM PENGATURAN PROFIL</p>
                        <hr>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 table-responsive">
                        <div class="mx-auto " style="width: 80%;">
                            <div class="ormawa-banner_inp_profil shadow-sm">
                                <img src="{{url('assets/img/banner-ormawa-upload.png')}}" style="width: 100%" alt="" class="img-fluid">
                            </div>
                            <a href="{{route('ormawa.event.add')}}" class="mt-3 dcd-btn dcd-btn-sm dcd-btn-primary mr-2" style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">Banner Profil</a>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-3 col-12">
                        <div class="border mb-3 ormawa-banner_inp_profil shadow-sm" style="width: 200px; height:150px">
                            <img src="{{url('assets/img/no-image.png')}}" style="width: 100%" alt="" class="img-fluid">
                        </div>
                        <a href="{{route('ormawa.event.add')}}" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2" style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">Logo Profil</a>
                    </div>
                    <div class="col-lg-9 col-12">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Nama Ormawa</label>
                            <input type="text" placeholder="HIMATIF" disabled class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Username</label>
                            <input type="text" placeholder="himatif123" disabled class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Email</label>
                            <input type="text"class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi-inp" name="syarat"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Alamat Facebook</label>
                            <input type="text"class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Alamat Instagram</label>
                            <input type="text"class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Alamat Youtube</label>
                            <input type="text"class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Website</label>
                            <input type="text"class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Submit" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2" style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ url('assets/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace( 'deskripsi-inp',{
	customConfig: '/public/assets/ckeditor/ckeditor_ormawa_profil.js'
});
</script>
    
@endpush