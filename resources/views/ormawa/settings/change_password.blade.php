@extends('ormawa.app')

@section('title','Settings Profile')

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <p class="h5 text-orange"><i class="icon-copy dw dw-password mr-2"></i>FORM GANTI PASSWORD</p>
                        <hr>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 col-12">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Password Lama</label>
                            <input type="text"  class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Password Baru</label>
                            <input type="text"  class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Konfirmasi Password Baru</label>
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