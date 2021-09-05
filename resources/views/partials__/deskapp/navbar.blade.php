<div class="header">
    <div class="header-left">
        <div class="menu-icon dw dw-menu"></div>
        <div class="search-toggle-icon dw dw-tag-1" data-toggle="header_search"></div>
        <div class="header-search">
            @if (Request()->route()->getPrefix() === "mahasiswa/event/detail")
            <h5 class="h4 text-secondary mt-2 ml-4" style="">{{$slug}}</h5>
            @elseif(Request()->route()->getPrefix() === "mahasiswa/account")
            <h5 class="h4 text-secondary mt-2 ml-4" style="">Profil Jhon Doe</h5>
            @elseif(Request()->route()->getPrefix() === "mahasiswa/team")
            <h5 class="h4 text-secondary mt-2 ml-4" style="">Team Saya</h5>
            @else
            <h5 class="h4 text-secondary mt-2 ml-4" style="">
                @if (Session::get('is_ormawa') == "1" && Request()->route()->getPrefix() == "ormawa/dashboard" )
                @php
                $ormawa = \App\Ormawa::where('id_ormawa', Session::get('id_ormawa'))->first();
                @endphp
                <span class="micon dw dw-home mr-2"></span>{{$ormawa->nama_ormawa}}
                @else
                {!!$navTitle!!}
                @endif
            </h5>
            @endif

        </div>
    </div>
    <div class="header-right">
        @if (Session::get('is_pembina') == "0")
        <div class="pt-3">
            <a href="#" data-toggle="modal" type="button" data-target="#event-add-modal"
                class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                style="border:none;padding:10px 25px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">Buat
                Event</a>
        </div>
        @endif
        {{-- <div class="user-notification">
            <div class="dropdown">
                <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
                    <i class="icon-copy dw dw-notification"></i>
                    <span class="badge notification-active"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="notification-list mx-h-350 customscroll">
                        <ul>
                            <li>
                                <a href="#">
                                    <img src="{{url('assets/deskapp/vendors/images/img.jpg')}}" alt="">
                                    <h3>John Doe</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="{{url('assets/deskapp/vendors/images/photo1.jpg')}}" alt="">
                                    <h3>Lea R. Frith</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="{{url('assets/deskapp/vendors/images/photo2.jpg')}}" alt="">
                                    <h3>Erik L. Richards</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="{{url('assets/deskapp/vendors/images/photo3.jpg')}}" alt="">
                                    <h3>John Doe</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="{{url('assets/deskapp/vendors/images/photo4.jpg')}}" alt="">
                                    <h3>Renee I. Hansen</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="{{url('assets/deskapp/vendors/images/img.jpg')}}" alt="">
                                    <h3>Vicki M. Coleman</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="user-info-dropdown mr-3">
            <div class="dropdown">
                <a class="dropdown-toggle" style="margin-top: 13px" href="#" role="button" data-toggle="dropdown">
                    <span class="user-name"><i class="icon-copy dw dw-user" style="font-size: 21px"></i></span>
                </a>
                @if (Session::get('id_pengguna'))
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        <a class="dropdown-item" href="{{route('peserta.account.index')}}"><i class="dw dw-user1"></i>Profil</a>
                        <a class="dropdown-item" href="{{route('peserta.account.changepassword')}}"><i
                                class="dw dw-settings2"></i>Ganti Password</a>
                        <a class="dropdown-item" href="{{route('peserta.logout')}}"><i class="dw dw-logout"></i> Log Out</a>
                    </div>
                @else
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                        @if (Session::get('is_pembina'))
                            <a class="dropdown-item" href="{{route('profile.dosen.index')}}"><i class="dw dw-user1"></i>Profil</a>
                            <a class="dropdown-item" href="{{route('ormawa.settings.changepassword')}}"><i
                                    class="dw dw-settings2"></i>Ganti Password</a>
                        @else
                            <a class="dropdown-item" href="{{route('ormawa.settings.index')}}"><i class="dw dw-user1"></i>Profil</a>
                            <a class="dropdown-item" href="{{route('ormawa.settings.changepassword')}}"><i
                                    class="dw dw-settings2"></i>Ganti Password</a>
                        @endif
                        <a class="dropdown-item" href="{{route('ormawa.logout')}}"><i class="dw dw-logout"></i> Log Out</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>