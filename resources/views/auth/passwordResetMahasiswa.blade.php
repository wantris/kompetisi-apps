@extends('template')

    @section('title', 'Beranda')

    @section('content')

        <div class="container password-reset-container">
            <div class="row px-5">
                <div class="col-md-6 offset-md-3 white-bg pad-4">
                    <h4 class="">Lupa Password</h4>
                    <hr>
                    <form action="{{route('password.resetProcess')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="font-weight-bold">Email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Email...">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Submit Permintaan" class="reset-pasword-btn px-3 py-1 font-weight-bold">
                        </div>
                    </form>
                    <hr class="mt-4 mb-3">
                    <div class="small mt-2 text-secondary">
                        Masukkan nama pengguna atau alamat email Anda di atas
                    </div>
                </div>
            </div>
        </div>

    @endsection

