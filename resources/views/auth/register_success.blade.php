    @extends('template')

    @section('title', 'Beranda')

    @push('cs-css')
    <style>
        h1 {
            color: #88B04B;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }
        p {
            color: #404F5E;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-size:20px;
            margin: 0;
        }
        i.checkmark {
            color: #9ABC66;
            font-size: 100px;
            line-height: 200px;
            margin-left:-15px;
        }
        .card-success {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
        }
      </style>
    @endpush

    @section('content')

        <div class="container password-reset-container">
            <div class="row px-5">
                <div class="col-md-12 col-lg-12 col-12 text-center">
                    <div class="card-success">
                        <div class="text-center" style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                          <i class="checkmark text-center">✓</i>
                        </div>
                          <h1>Success</h1> 
                          <p>Daftar Akun Berhasil!</p>
                    </div>
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

