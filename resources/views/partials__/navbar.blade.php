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
                                <img src="{{url('assets/img/logo/logo.png')}}" style="width: 100%;
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
                                        <li><a href="{{url('/')}}">Beranda</a></li>
                                        <li><a href="{{route('event.index')}}">Event</a></li>
                                        <li><a href="{{route('blog.index')}}">Blog</a>
                                        </li>
                                        <li><a href="{{route('contact.index')}}">Kontak</a></li>
                                        <li class="d-lg-none "><a href="#"><img src=""
                                                    style="width: 50px; height:50px; border-radius:20px" alt=""></a>
                                            <ul class="submenu">
                                                <li><a href="blog.html">Profil</a></li>
                                                <li><a href="single-blog.html">Ganti Password</a></li>
                                                <li><a href="elements.html">Profil Publik</a></li>
                                                <li><a href="job_details.html">Sign out</a></li>
                                            </ul>
                                        </li>
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