@extends('ormawa.app')

@section('title','Dashboard')

@section('content')

<div class="row">
    @if (Session::get('is_dosen') == "1")
        <div class="col-xl-8 col-lg-8 col-md-12 col-12 mb-30">
            <div class="card-box height-100-p widget-style1">
                <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                    <div class="row mt-2">
                        <div class="col-8">
                            <img src="{{url('assets/deskapp/vendors/images/icon/harddisk.svg')}}" width="20"
                                class="img-fluid ml-2 d-inline" alt="">
                            <span class="d-inline ml-2 text-secondary mt-2">Jumlah Ormawa yang Pernah Dibina</span>
                        </div>
                        <div class="col-4 text-right ">
                            <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-dash-body mt-4">
                    <span class="d-inline card-body-number ml-2">{{$pembinas->count()}}</span>
                    <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Ormawa</span>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12 col-12 mb-30">
            <div class="card-box height-100-p widget-style1">
                <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                    <div class="row mt-2">
                        <div class="col-8">
                            <span class="d-inline ml-2 text-secondary mt-2">Selamat Datang</span>
                        </div>
                        <div class="col-4 text-right ">
                            <a href="#" class="card-dash-link">Profil <i class="icofont-caret-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-dash-body mt-4 text-center">
                    <img src="https://image.flaticon.com/icons/png/512/1177/1177568.png" style="max-width: 90px; height:90px" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    @endif
    @if (Session::get('is_ormawa') == "1")
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/competition.svg')}}" width="20"
                            class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Event Aktif</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                @php
                $total = (int)$eia->count() + (int)$eea->count();
                @endphp
                <span class="d-inline card-body-number ml-2">{{$total}}</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Event</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/trophy-badge.svg')}}" width="20"
                            class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Total Event</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                @php
                $totalEvent = (int)$ei->count() + (int)$ee->count();
                @endphp
                <span class="d-inline card-body-number ml-2">{{$totalEvent}}</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Event</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/register.svg')}}" width="20"
                            class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Pendaftar</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2">0</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Orang</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/badge.svg')}}" width="20"
                            class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Event Selesai</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                @php
                $totalSelesai = (int)$eis->count() + (int)$ees->count();
                @endphp
                <span class="d-inline card-body-number ml-2">{{$totalSelesai}}</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Event</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/school.svg')}}" width="20"
                            class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Event Internal</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2">{{$ei->count()}}</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Event</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/harddisk.svg')}}" width="20"
                            class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Event Eksternal</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2">{{$ee->count()}}</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Event Eksternal</span>
            </div>
        </div>
    </div>
    @endif
    
</div>

@endsection

@push('script')

<script>
    $(function() {

        $(".progress").each(function() {

        var value = $(this).attr('data-value');
        var left = $(this).find('.progress-left .progress-bar');
        var right = $(this).find('.progress-right .progress-bar');

        if (value > 0) {
            if (value <= 50) {
            right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
            } else {
            right.css('transform', 'rotate(180deg)')
            left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
            }
        }

        })

        function percentageToDegrees(percentage) {

        return percentage / 100 * 360

        }

        });
</script>