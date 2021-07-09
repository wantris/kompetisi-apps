@if (Request()->route()->getPrefix() === "/peserta" || Request()->route()->getPrefix() === "peserta/event" || Request()->route()->getPrefix() === "peserta/account" || Request()->route()->getPrefix() === "peserta/team")

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
                    <a href="{{route('peserta.event.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-up-chevron-1"></span><span class="mtext">Event Saya</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('peserta.team.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-group"></span><span class="mtext">Tim Saya</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('peserta.account.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-settings2"></span><span class="mtext">Profil Saya</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-overlay"></div>
    @elseif (Request()->route()->getPrefix() === "peserta/event/detail")
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
                        <a href="{{route('peserta.event.submission','Design-Competition')}}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-startup"></span><span class="mtext">Submission</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('peserta.event.notification','Design-Competition')}}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-speaker-1"></span><span class="mtext">Pengumuman</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('peserta.event.timeline','Design-Competition')}}" class="dropdown-toggle no-arrow">
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
							<li><a href="ui-cards.html">Event Eksternal</a></li>
						</ul>
					</li>
                    {{-- <li>
                        <a href="{{route('ormawa.step.index')}}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-startup-2"></span><span class="mtext">Tahapan</span>
                        </a>
                    </li> --}}
                    <li>
                        <a href="{{route('ormawa.timeline.index')}}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-time-management"></span><span class="mtext">Timeline</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('ormawa.step.index')}}" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-notification1"></span><span class="mtext">Pengumuman</span>
                        </a>
                    </li>
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
                </ul>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>
@endif
