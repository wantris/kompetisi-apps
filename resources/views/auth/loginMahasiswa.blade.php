<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Mahasiswa</title>
    {{-- css --}}
    @include('partials__.head')
</head>
<body>
    
    <div class="container login-mhs__container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="login-mhs__title">
                    Login Mahasiswa
                </h1>
            </div>
        </div>
        <div class="row login-mhs__card-cont">
            <div class="col-lg-12">
                <div class="card login-mhs__card border">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-12">
                                {{-- <img src="{{url('assets/img/elements/example-login.jpg')}}" class="img-fluid login-mhs__card-image" alt="Responsive image"> --}}
                            </div>
                            <div class="col-lg-6 col-md-12 col-12 " style="height: 200px">
                                {{-- <div class="form-group mt-5">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                </div>
                                <div class="form-group mt-4">
                                    <label for="exampleInputEmail1">Password</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                </div>
                                <div class="form-check mt-3">
                                    <input type="checkbox" class="form-check-input login-mhs__card-checkbox" id="exampleCheck1" style="background: #FB8C00">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                    <a href="#" style="text-decoration: none; color:#FB8C00" class="float-right">Lupa Password?</a>
                                </div>
                                <div class="form-group mt-3 text-center">
                                    <input type="submit" class="btn-search mt-3" style="padding: 8px 40px !important; background:#FB8C00" value="Cari">
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JS --}}
    @include('partials__.js')
</body>
</html>