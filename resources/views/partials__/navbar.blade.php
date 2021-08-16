<header>
    <!-- Header Start -->
    <div class="header-area header-transparrent">
        <div class="headder-top header-sticky">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-2 ">
                        <!-- Logo -->
                        <div class="logo">
                            <a href="{{url('/')}}">
                                <img src="{{url('assets/img/logo/polindra.png')}}" style="width: 100%;
                              height: auto;
                              /* Recommended - Limit maximum width */
                              max-width: 100px;" class="mt-2" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9">
                        @if(\Route::current()->getName() != 'ormawa.eventinternal.add' && \Route::current()->getName() != 'ormawa.eventeksternal.add')
                        <div class="menu-wrapper">
                            <!-- Main-menu -->
                            <div class="main-menu ">
                                <nav class="d-none d-lg-block">
                                    <ul id="navigation">
                                        <li><a class="cool-link" href="{{url('/')}}">Beranda</a></li>
                                        <li><a class="cool-link" href="{{route('event.index')}}">Event</a></li>
                                        <li><a class="cool-link" href="{{route('blog.index')}}">Blog</a>
                                        </li>
                                        <li><a class="cool-link" href="{{route('contact.index')}}">Kontak</a></li>
                                        @if (Session::get('id_pengguna'))
                                            @php
                                                $pengguna = App\Pengguna::find(Session::get('id_pengguna'));
                                            @endphp
                                            <li class="d-lg-none ">
                                                <a href="#">
                                                    @if ($pengguna->photo)
                                                        <img src="{{asset('assets/img/photo-pengguna/'.$pengguna->photo)}}" style="width: 50px; height:50px; border-radius:20px">
                                                    @else
                                                        <img src="{{asset('assets/img/user.svg')}}" style="width: 50px; height:50px; border-radius:20px">
                                                    @endif
                                                </a>
                                                <ul class="submenu">
                                                    <li><a href="{{route('peserta.index')}}">Dashboard</a></li>
                                                    <li><a href="single-blog.html">Ganti Password</a></li>
                                                    <li><a href="elements.html">Profil Publik</a></li>
                                                    <li><a href="job_details.html">Sign out</a></li>
                                                </ul>
                                            </li>
                                        @elseif(Session::get('id_ormawa'))
                                            <li class="d-lg-none "><a href="#"><img src="" style="width: 50px; height:50px; border-radius:20px" alt=""></a>
                                                <ul class="submenu">
                                                    <li><a href="{{route('ormawa.index')}}">Dashboard</a></li>
                                                    <li><a href="single-blog.html">Ganti Password</a></li>
                                                    <li><a href="elements.html">Profil Publik</a></li>
                                                    <li><a href="{{route('ormawa.logout')}}">Sign out</a></li>
                                                </ul>
                                            </li>
                                        @else
                                            <li class="d-block d-sm-none"><a href="#" data-toggle="modal" data-target="#mahasiswaLoginModal" class="btn-login-mobile bg-app btn-round text-white mb-2">Peserta</a></li>
                                            <li class="d-block d-sm-none"><a href="#" data-toggle="modal" data-target="#ormawaLoginModal" class="btn-login-mobile bg-app-secondary btn-round text-white">Ormawa</a></li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                            @if(Session::get('id_pengguna') != null)
                            <div class="header-btn d-none f-right d-lg-block">
                                <div class="dropdown show ml-4">
                                    <a class="dropdown-toggle" href="#" role="button" id="navbar-menu-login"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{asset('assets/img/icon/user.svg')}}" class="d-inline mr-1" style="width: 30px; height:30px; border-radius:20px" alt="">
                                        <i class="icofont-rounded-down d-inline mt-2 text-secondary" id="arrow-icon"></i>
                                    </a>
                                    <div class="dropdown-menu mt-4 mr-4" aria-labelledby="navbar-menu-login">
                                        <a class="dropdown-item" href="{{route('peserta.index')}}">Dashboard</a>
                                        <a class="dropdown-item" href="{{url('user/pw/'.Auth::id())}}">Ganti
                                            Password</a>
                                        <a class="dropdown-item" href="{{route('peserta.logout')}}">Sign out</a>
                                    </div>
                                </div>
                            </div>
                            @elseif(Session::get('id_ormawa'))
                                <div class="header-btn d-none f-right d-lg-block">
                                    <div class="dropdown show ml-4">
                                        <a class="dropdown-toggle" href="#" role="button" id="navbar-menu-login"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @php
                                            $ormawa = \App\Ormawa::select('photo')->where('id_ormawa',Session::get('id_ormawa'))->first();
                                        @endphp
                                        @if ($ormawa->photo)
                                            <img src="{{url('assets/img/ormawa-logo/'.$ormawa->photo)}}" class="d-inline mr-1" style="width: 30px; height:30px; border-radius:20px" alt="">
                                        @else
                                            <img src="{{asset('assets/img/icon/user.svg')}}" class="d-inline mr-1" style="width: 30px; height:30px; border-radius:20px" alt="">
                                        @endif
                                        <i class="icofont-rounded-down d-inline mt-2 text-secondary" id="arrow-icon"></i>
                                    </a>
                                    <div class="dropdown-menu mt-4 mr-4" aria-labelledby="navbar-menu-login">
                                        <a class="dropdown-item" href="{{route('ormawa.index')}}">Dashboard</a>
                                        <a class="dropdown-item" href="{{url('user/pw/'.Auth::id())}}">Ganti
                                            Password</a>
                                        <a class="dropdown-item" href="{{route('ormawa.logout')}}">Sign out</a>
                                    </div>
                                    </div>
                                </div>
                            @else
                                <!-- Header-btn -->
                                <div class="header-btn d-none f-right d-lg-block">
                                    <a href="#" data-toggle="modal" data-target="#mahasiswaLoginModal"
                                        class="btn head-btn1">Peserta</a>
                                    <a href="#" data-toggle="modal" data-target="#ormawaLoginModal"
                                        class="btn head-btn2">Ormawa</a>
                                </div>
                            @endif
                        </div>
                        @endif
                    </div>
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>