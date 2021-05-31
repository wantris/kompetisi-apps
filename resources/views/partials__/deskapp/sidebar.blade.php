
@if (Request()->route()->getPrefix() != "mahasiswa/kompetisi/detail")
    <div class="left-side-bar">
        <div class="brand-logo">
            <a href="index.html" class="text-center">
                <img src="{{url('assets/img/logo/logo.png')}}" style="max-width: 70px" alt="" class="dark-logo">
                <img src="{{url('assets/img/logo/logo.png')}}"style="max-width: 70px" alt="" class="light-logo">
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    <li>
                        <a href="javascript:;" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon dw dw-up-chevron-1"></span><span class="mtext">Kompetisi Saya</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{route('mahasiswa.kompetisi.index')}}">Data Kompetisi</a></li>
                            <li><a href="advanced-components.html">Kompetisi Aktif</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('mahasiswa.team.index')}}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-group"></span><span class="mtext">Tim Saya</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('mahasiswa.account.index')}}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-settings2"></span><span class="mtext">Profil Saya</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>
@else
<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index.html" class="text-center">
            <img src="{{url('assets/img/logo/logo.png')}}" style="max-width: 70px" alt="" class="dark-logo">
            <img src="{{url('assets/img/logo/logo.png')}}"style="max-width: 70px" alt="" class="light-logo">
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="javascript:;" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('mahasiswa.kompetisi.submission','Design-Competition')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-startup"></span><span class="mtext">Submission</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('mahasiswa.kompetisi.notification','Design-Competition')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-speaker-1"></span><span class="mtext">Pengumuman</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('mahasiswa.kompetisi.timeline','Design-Competition')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-calendar-7"></span><span class="mtext">Timeline</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-overlay"></div>
@endif
