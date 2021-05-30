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
                        <div class="menu-wrapper">
                            <!-- Main-menu -->
                            <div class="main-menu ">
                                <nav class="d-none d-lg-block">
                                    <ul id="navigation">
                                        <li><a href="{{url('/')}}">Beranda</a></li>
                                        <li><a href="{{route('kompetisi.index')}}">Kompetisi</a></li>
                                        <li><a href="{{route('blog.index')}}">Blog</a>
                                        </li>
                                        <li><a href="{{route('contact.index')}}">Kontak</a></li>
                                        <li class="d-lg-none "><a href="#"><img src="" style="width: 50px; height:50px; border-radius:20px" alt=""></a>
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
                            @if(Auth::check())
                                <div class="header-btn d-none f-right d-lg-block">
                                    <div class="dropdown show">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="" style="width: 50px; height:50px; border-radius:20px" alt="">
                                            <i class="fa fa-sort-desc float-right text-dark" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu mt-4 mr-4" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="{{url('user/profil/'.Auth::id())}}">Profil</a>
                                            <a class="dropdown-item" href="{{route('user.daftar.lamaran')}}">Lamaran</a>
                                            @php
                                                $user = App\User::where('id', Auth::id())->first();
                                            @endphp
                                            @if ($user->google_id === null)
                                                <a class="dropdown-item" href="{{url('user/pw/'.Auth::id())}}">Ganti Password</a>
                                            @endif
                                            <a class="dropdown-item" href="{{url('user/logout')}}">Sign out</a>
                                        </div>
                                    </div>
                                </div>
                            @else         
                            <!-- Header-btn -->
                            <div class="header-btn d-none f-right d-lg-block">
                                <a href="#" data-toggle="modal" data-target="#mahasiswaLoginModal" class="btn head-btn1">Mahasiswa</a>
                                <a href="#" data-toggle="modal" data-target="#ormawaLoginModal" class="btn head-btn2">Ormawa</a>
                            </div>
                            @endif
                        </div>
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