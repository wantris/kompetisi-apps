@if (Session::get('id_pengguna') != null && Request()->route()->getPrefix() != "peserta/eventinternal/detail" && Request()->route()->getPrefix() != "peserta/eventeksternal/detail")

<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index.html" class="text-center">
            <img src="{{url('assets/img/logo/logo.png')}}" style="max-width: 70px" alt="" class="dark-logo">
            <img src="{{url('assets/img/logo/logo.png')}}" style="max-width: 70px" alt="" class="light-logo">
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{route('peserta.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-rocket"></span><span class="mtext"> Event Saya </span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{route('peserta.eventinternal.index')}}">Event Internal</a></li>
                        @if (Session::get('is_mahasiswa') == 1)
                            <li><a href="{{route('peserta.eventeksternal.index')}}">Event Eksternal</a></li>
                        @endif
                    </ul>
                </li>
                <li>
                    <a href="{{route('peserta.team.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-group"></span><span class="mtext">Tim Saya</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-overlay"></div>
@elseif (Request()->route()->getPrefix() == "peserta/eventinternal/detail")
<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index.html" class="text-center">
            <img src="{{url('assets/img/logo/logo.png')}}" style="max-width: 70px" alt="" class="dark-logo">
            <img src="{{url('assets/img/logo/logo.png')}}" style="max-width: 70px" alt="" class="light-logo">
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{route('peserta.eventinternal.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('peserta.event.submission','Design-Competition')}}"
                        class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-startup"></span><span class="mtext">Submission</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('peserta.eventinternal.notification', $slug)}}"
                        class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-speaker-1"></span><span class="mtext">Pengumuman</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('peserta.eventinternal.timeline',$slug)}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-calendar-7"></span><span class="mtext">Timeline</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-overlay"></div>

@elseif(Request()->route()->getPrefix() == "peserta/eventeksternal/detail")

<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index.html" class="text-center">
            <img src="{{url('assets/img/logo/logo.png')}}" style="max-width: 70px" alt="" class="dark-logo">
            <img src="{{url('assets/img/logo/logo.png')}}" style="max-width: 70px" alt="" class="light-logo">
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{route('peserta.eventeksternal.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('peserta.event.submission','Design-Competition')}}"
                        class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-startup"></span><span class="mtext">Submission</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('peserta.eventeksternal.notification', $slug)}}"
                        class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-speaker-1"></span><span class="mtext">Pengumuman</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('peserta.eventeksternal.timeline',$slug)}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-calendar-7"></span><span class="mtext">Timeline</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-overlay"></div>


{{-- Ormawa sidebar --}}
@elseif(Session::get('is_ormawa') == 1)

<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index.html" class="text-center">
            <img src="{{url('assets/img/logo/logo.png')}}" style="max-width: 70px" alt="" class="dark-logo">
            <img src="{{url('assets/img/logo/logo.png')}}" style="max-width: 70px" alt="" class="light-logo">
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{route('ormawa.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-house-1"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-rocket"></span><span class="mtext"> Event </span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{route('ormawa.eventinternal.index')}}">Event Internal</a></li>
                        <li><a href="{{route('ormawa.eventeksternal.index')}}">Event Eksternal</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-notebook"></span><span class="mtext"> Pendaftaran </span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{route('ormawa.eventinternal.index')}}">Event Internal</a></li>
                        <li><a href="{{route('ormawa.eventeksternal.index')}}">Event Eksternal</a></li>
                    </ul>
                </li>
                @if (Session::get('is_dosen') == "0")
                <li>
                    <a href="{{route('ormawa.timeline.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-time-management"></span><span class="mtext">Timeline</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('ormawa.pengumuman.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-notification1"></span><span class="mtext">Pengumuman</span>
                    </a>
                </li>
                @endif
                
                <li>
                    <a href="{{route('peserta.team.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-group"></span><span class="mtext">Tim</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('ormawa.settings.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-settings2"></span><span class="mtext">Profil Ormawa</span>
                    </a>
                </li>
                @if (Session::get('is_dosen') == "1")
                <li>
                    <a href="{{route('riwayat.dosen.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-center-align"></span><span class="mtext">Riwayat Membina</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-overlay"></div>
@endif

@if (Session::get('is_dosen') == "1" && Session::get('is_ormawa') == "0")
<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index.html" class="text-center">
            <img src="{{url('assets/img/logo/logo.png')}}" style="max-width: 70px" alt="" class="dark-logo">
            <img src="{{url('assets/img/logo/logo.png')}}" style="max-width: 70px" alt="" class="light-logo">
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{route('riwayat.dosen.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-center-align"></span><span class="mtext">Riwayat Membina</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-overlay"></div>
@endif