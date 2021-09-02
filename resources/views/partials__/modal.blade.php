<!-- Modal Login Mahasiswa -->
<div class="modal fade" id="mahasiswaLoginModal" style=" z-index: 99999; !important" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"  role="document">
    <div class="modal-content" style="border: none; border-top:4px solid #126afe !important; border-radius:20px !important" >
      <div class="modal-header" style="">
        <h5 class="modal-title font-weight-bold" id="exampleModalCenterTitle">Login Peserta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form action="{{route('peserta.login.post')}}" method="post">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="exampleInputEmail1">Username</label>
                  <input type="username" name="username_mhs" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Masukkan Username...">
                    @if ($errors->has('username_mhs'))
                      <span class="text-danger">{{ $errors->first('username_mhs') }}</span>
                    @endif
                </div>
                <div class="form-group mt-4">
                  <label for="exampleInputEmail1">Password</label>
                  <div class="input-group">
                    <input type="password" name="password_mhs" id="password-participant-inp" class="form-control" placeholder="Password...">
                    <div class="input-group-append bg-white" id="btn-pw-participant">
                      <button type="button" onclick="showPasswordParticipant()" style="cursor: pointer"
                          class="input-group-text"><i class="fas fa-eye"></i></button>
                    </div>
                  </div>
                  @if ($errors->has('password_mhs'))
                    <span class="text-danger">{{ $errors->first('password_mhs') }}</span>
                  @endif
                </div>
                <div class="form-check mt-4">
                  <input type="checkbox" class="form-check-input login-mhs__card-checkbox" name="remember" id="exampleCheck1"
                    style="background: #FB8C00">
                  <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                  <a href="{{route('password.reset')}}" style="text-decoration: none; color:#010B1D"
                    class="float-right">Lupa Password?</a>
                </div>
                <div class="form-group mt-4 text-left">
                  <input type="submit" class="btn-login-mhs btn-round mt-3" value="Login">
                </div>
                <div class="form-group">
                  <div class="font-weight-medium">
                      Belum punya akun? Ayo <a href="{{route('peserta.register')}}" class="text-underline" style="color:#010B1D"><strong>Daftar</strong></a>
                  </div>
              </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Login Ormawa-->
<div class="modal fade" id="ormawaLoginModal" style=" z-index: 99999; !important" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border: none; border-top:4px solid #fb8d02 !important; border-radius:20px !important">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalCenterTitle">Login Ormawa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form action="{{route('ormawa.login.post')}}" method="post">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label for="exampleInputEmail1">Login Sebagai</label>
                  <select name="role" id="" class="form-control">
                    <option value="pengurus">Pengurus</option>
                    <option value="pembina">Pembina</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Username</label>
                  <input type="text" name="username" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Masukkan Username...">
                </div>
                <div class="form-group mt-4">
                  <label for="exampleInputEmail1">Password</label>
                  <div class="input-group">
                    <input type="password" name="password" id="password-ormawa-inp" class="form-control"
                      placeholder="Masukan Password...">
                    <div class="input-group-append bg-white" id="btn-pw-ormawa">
                      <button type="button" onclick="showPasswordOrmawa()" style="cursor: pointer"
                        class="input-group-text"><i class="fas fa-eye"></i></button>
                    </div>
                  </div>
                </div>
                <div class="form-check mt-4">
                  <input type="checkbox" class="form-check-input login-mhs__card-checkbox" id="exampleCheck1"
                    style="background: #FB8C00">
                  <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                  <a href="#" style="text-decoration: none; color:#FB8C00" class="float-right">Lupa Password?</a>
                </div>
                <div class="form-group mt-4 text-left">
                  <input type="submit" class="btn-login-mhs mt-3" style="background: #FB8C00; border-color:#FB8C00"
                    value="Login">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>