@extends('peserta.app')

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
                        <form action="{{route('peserta.account.changepassword.save')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Password Lama</label>
                                <input type="text" name="password" class="form-control">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Password Baru</label>
                                <input type="text"  name="new_password" class="form-control">
                                @if ($errors->has('new_password'))
                                    <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Konfirmasi Password Baru</label>
                                <input type="text" name="confirm_new_password" class="form-control">
                                @if ($errors->has('confirm_new_password'))
                                    <span class="text-danger">{{ $errors->first('confirm_new_password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Submit" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2" style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
