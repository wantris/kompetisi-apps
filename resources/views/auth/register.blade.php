@extends('template')

    @section('title', 'Beranda')

    @section('content')

        <div class="container password-reset-container">
            <div class="row px-5">
                <div class="col-md-6 col-lg-6 col-12">
                    <div class="card shadow-sm" style="border-radius: 20px; border:none; border-top:3px solid #126AFE">
                        <div class="card-body">
                            <h4 class="font-weight-bold" style="color: #126AFE">Daftar Akun Baru</h4>
                            <form action="{{route('peserta.register.save')}}" method="post" class="mt-3">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="control-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" value="{{old('nama')}}" name="nama" id="exampleInputEmail1" placeholder="Nama Lengkap">
                                    @if ($errors->has('nama'))
                                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                                    @endif
                                    <small class="text-muted d-block">Masukkan Nama Lengkap yang sesuai</small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="control-label">Username</label>
                                    <input type="text" class="form-control" value="{{old('username')}}" name="username" id="exampleInputEmail1" placeholder="Username">
                                    @if ($errors->has('username'))
                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                    @endif
                                    <small class="text-muted d-block">Username digunakan untuk identitas profil</small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="control-label">Email</label>
                                    <input type="email" class="form-control" value="{{old('email')}}" name="email" id="exampleInputEmail1" placeholder="Email">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                    <small class="text-muted d-block">Gunakan email aktif</small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="control-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password-inp" class="form-control" placeholder="Password...">
                                        <div class="input-group-append bg-white" id="btn-pw">
                                        <button type="button" onclick="showPassword()" style="cursor: pointer"
                                            class="input-group-text"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                    <small class="text-muted d-block">Gunakan minimal 8 karakter dengan kombinasi huruf dan angka</small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="control-label">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" name="confirmPassword" id="password-confirm-inp" class="form-control" placeholder="Password...">
                                        <div class="input-group-append bg-white" id="btn-pw-confirm">
                                        <button type="button" onclick="showConfirmPassword()" style="cursor: pointer"
                                            class="input-group-text"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </div>
                                    @if ($errors->has('confirmPassword'))
                                        <span class="text-danger">{{ $errors->first('confirmPassword') }}</span>
                                    @endif
                                    <small class="text-muted d-block">Ulangi password di atas sekali lagi</small>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Submit" class="reset-pasword-btn px-3 py-1 font-weight-bold">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <img src="{{asset('assets/img/service/register-image.svg')}}" class="img-fluid" alt="Register">
                </div>
            </div>
        </div>

    @endsection

    @push('cs-script')
        <script>
            const showPassword = () => {
                let html = `
                    <button type="button" onclick="hidePassword()" style="cursor: pointer" class="input-group-text"><i class="fas fa-eye-slash"></i></button>
                `;
                if(!$('#btn-pw').hasClass('show')){
                    $('#password-inp').attr('type','text');
                    $('#btn-pw').addClass('show');
                    $('#btn-pw').html(html);
                }
            } 

            const hidePassword = () => {
                let html = `
                    <button type="button" onclick="showPassword()" style="cursor: pointer" class="input-group-text"><i class="fas fa-eye"></i></button>
                `;
                if($('#btn-pw').hasClass('show')){
                    $('#password-inp').attr('type','password');
                    $('#btn-pw').removeClass('show');
                    $('#btn-pw').html(html);
                }
            }

            const showConfirmPassword = () => {
                let html = `
                    <button type="button" onclick="hideConfirmPassword()" style="cursor: pointer" class="input-group-text"><i class="fas fa-eye-slash"></i></button>
                `;
                if(!$('#btn-pw-confirm').hasClass('show')){
                    $('#password-confirm-inp').attr('type','text');
                    $('#btn-pw-confirm').addClass('show');
                    $('#btn-pw-confirm').html(html);
                }
            } 

            const hideConfirmPassword = () => {
                let html = `
                    <button type="button" onclick="showConfirmPassword()" style="cursor: pointer" class="input-group-text"><i class="fas fa-eye"></i></button>
                `;
                if($('#btn-pw-confirm').hasClass('show')){
                    $('#password-confirm-inp').attr('type','password');
                    $('#btn-pw-confirm').removeClass('show');
                    $('#btn-pw-confirm').html(html);
                }
            }
        </script>
    @endpush

