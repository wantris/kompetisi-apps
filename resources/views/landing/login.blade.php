<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Peserta</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Playfair+Display:400,900|Poppins:400,500');
	* {
	  margin: 0;
	  padding: 0;
	  text-decoration: none;
	  box-sizing: border-box;
	}
	body {
	  margin: 0;
	  padding: 0;
	  background: #f6f6f6;
	  font-family: 'Poppins', sans-serif;
	  overflow-x: hidden;
	  height: 100vh;
	  margin: auto;
	  display: flex;
	}

	img {
		max-width: 100%;
	}

	.app {
	  background-color: #fff;
	  width: 330px;
	  height: 470px;
	  margin: 2em auto;
	  border-radius: 5px;
	  padding: 1em;
	  position: relative;
	  overflow: hidden;
	  box-shadow: 0 6px 31px -2px rgba(0, 0, 0, .3);
	}

	a {
		text-decoration: none;
		color: #257aa6;
	}

	p {
		font-size: 13px;
		color: #333;
		line-height: 2;
	}
    .light {
        text-align: right;
        color: #fff;
    }
        .light a {
            color: #fff;
        }

	.bg {
		width: 400px;
		height: 450px;
		background: #126afe;
		position: absolute;
		top: -5em;
		left: 0;
		right: 0;
		margin: auto;
		background-image: url("background.jpg");
		background-position: center;
		background-size: cover;
		background-repeat: no-repeat;
		clip-path: ellipse(69% 46% at 48% 46%);
	}

	form {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		width: 100%;
		text-align: center;
		padding: 2em;
	}

	header {
	    width: 110px;
	    height: 110px;
	    margin: 1em auto;
	  }

	form input {
	    width: 100%;
	    padding: 13px 15px;
	    margin: 0.7em auto;
	    border-radius: 100px;
	    border: none;
	    background: rgb(255,255,255,0.3);
	    font-family: 'Poppins', sans-serif;
	    outline: none;
	    color: #fff;
	}

    .error-msg {
        font-size: 11px !important;
        margin-top: -8px !important;
        margin-left: 17px;
        text-align: left;
        color: #fff;
    }
    .error-msg a {
        color: #fff;
    }

	input::placeholder {
	    color: #fff;
	    font-size: 13px;
	}

	.inputs {
		margin-top: -4em;
	}

	footer {
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		padding: 2em;
		text-align: center;
	}

	button {
		width: 100%;
	    padding: 13px 15px;
	    border-radius: 100px;
	    border: none;
	    background: #126afe;
	    font-family: 'Poppins', sans-serif;
	    outline: none;
	    color: #fff;
	}
	
	@media screen and (max-width: 640px) {
			.app {
				width: 100%;
				height: 100vh;
				border-radius: 0;
			}

			.bg {
				top: -7em;
				width: 450px;
				height: 95vh;
			}
			header {
				width: 90%;
				height: 250px;
			}
			.inputs {
				margin: 0;
			}
			input, button {
				padding: 18px 15px;
			}
		}
    </style>
</head>
<body>
    <div class="app">

		<div class="bg"></div>
		<form id="form-login" action="{{route('project.login.post')}}" method="POST">
			@csrf
            <header>
                <h2 style="color: #fff">Login</h2>
			</header>
			<div class="inputs">
				<input type="text" name="username" placeholder="Username">
                @if ($errors->has('username'))
                    <p class="error-msg"><a href="#">{{ $errors->first('username') }}</a></p>
                @endif
				<input type="password" name="password" placeholder="Password">
                @if ($errors->has('password'))
                    <p class="error-msg"><a href="#">{{ $errors->first('password') }}</a></p>
                @endif
				<p class="light"><a href="#">Lupa Password?</a></p>
			</div>
            <input type="hidden" name="id_detail" value="{{$id_detail}}">   
		</form>
		<footer>
			<button onclick="submitLogin()">Lanjutkan</button>
			<p>Belum punya akun? <a href="#">Daftar Sekarang</a></p>
		</footer>
	</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    
    {{-- Notiflix --}}
    <script src="{{url('assets/notiflix/dist/notiflix-2.7.0.min.js')}}"></script>
    <script src="{{url('assets/notiflix/dist/notiflix-aio-2.7.0.min.js')}}"></script>

    <script>
        const submitLogin = () =>{
            $('#form-login').trigger('submit');
        }
    </script>

    @if (session()->has('failed'))
    <script>
        Notiflix.Notify.Failure("{{ Session::get('failed') }}");
    </script>
    @endif

    @if (session()->has('success'))
    <script>
        Notiflix.Notify.Success("{{ Session::get('success') }}");
    </script>
    @endif
</body>
</html>