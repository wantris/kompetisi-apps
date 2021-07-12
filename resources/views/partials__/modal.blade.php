<!-- Modal Login Mahasiswa -->
<div class="modal fade" id="mahasiswaLoginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalCenterTitle">Login Mahasiswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="exampleInputEmail1">NIM</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                  placeholder="Masukkan NIM...">
              </div>
              <div class="form-group mt-4">
                <label for="exampleInputEmail1">Password</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Password...">
                  <div class="input-group-append bg-white">
                    <span class="input-group-text"><i class="fas fa-eye-slash"></i></span>
                  </div>
                </div>
              </div>
              <div class="form-check mt-4">
                <input type="checkbox" class="form-check-input login-mhs__card-checkbox" id="exampleCheck1"
                  style="background: #FB8C00">
                <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                <a href="{{route('password.reset')}}" style="text-decoration: none; color:#010B1D"
                  class="float-right">Lupa Password?</a>
              </div>
              <div class="form-group mt-4 text-left">
                <input type="submit" class="btn-login-mhs mt-3" value="Login">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Login Ormawa-->
<div class="modal fade" id="ormawaLoginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
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
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label for="exampleInputEmail1">Username</label>
                  <input type="text" name="username" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Masukkan Username...">
                </div>
                <div class="form-group mt-4">
                  <label for="exampleInputEmail1">Password</label>
                  <div class="input-group">
                    <input type="password" name="password" id="password-ormawa-inp" class="form-control" placeholder="Masukan Password...">
                    <div class="input-group-append bg-white" id="btn-pw-ormawa">
                      <button type="button" onclick="showPasswordOrmawa()" style="cursor: pointer" class="input-group-text"><i class="fas fa-eye"></i></button>
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
