@if (Request()->route()->getPrefix() === "/mahasiswa" || Request()->route()->getPrefix() === "mahasiswa/kompetisi" || Request()->route()->getPrefix() === "mahasiswa/account" || Request()->route()->getPrefix() === "mahasiswa/team")

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
                <li >
                    <a href="{{route('mahasiswa.kompetisi.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-up-chevron-1"></span><span class="mtext">Kompetisi Saya</span>
                    </a>
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
    @elseif (Request()->route()->getPrefix() === "mahasiswa/kompetisi/detail")
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

    {{-- Ormawa sidebar --}}
    @elseif(Request()->route()->getPrefix() == "ormawa/dashboard" || Request()->route()->getPrefix() == "ormawa/kompetisi")

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
                            <span class="micon dw dw-house-1"></span><span class="mtext">Dashboard</span>
                        </a>
                    </li>
                    <li >
                        <a href="{{route('ormawa.kompetisi.index')}}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-up-chevron-1"></span><span class="mtext">Kompetisi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('mahasiswa.team.index')}}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-group"></span><span class="mtext">Tim</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('mahasiswa.account.index')}}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-settings2"></span><span class="mtext">Profil Ormawa</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>
@endif
