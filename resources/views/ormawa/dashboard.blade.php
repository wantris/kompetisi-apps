@extends('ormawa.app')

@section('title','Dashboard')

@section('content')

<div class="row">
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/competition.svg')}}" width="20" class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Kompetisi Aktif</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2" >0</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Kompetisi</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/trophy-badge.svg')}}" width="20" class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Total Kompetisi</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2" >0</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Kompetisi</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/register.svg')}}" width="20" class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Pendaftar</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2" >0</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Orang</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/badge.svg')}}" width="20" class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Kompetisi Selesai</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2" >0</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Kompetisi</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/checklist.svg')}}" width="20" class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Total Submission</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2" >0</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Submision</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/group.svg')}}" width="20" class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Jumlah Pengikut</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2" >0</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Orang</span>
            </div>
        </div>
    </div>
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
