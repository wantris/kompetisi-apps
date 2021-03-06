@extends('peserta.app')

@section('title','Dashboard')

@section('content')
<div class="row">
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/competition.svg')}}" width="20" class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Event Aktif</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2" id="event-active-text">0</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Event</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/trophy.svg')}}" width="20" class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Total Event</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2" id="event-total-text">0</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Event</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/user.svg')}}" width="20" class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Profil</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body">
                <div class="progress mx-auto my-2" id="profil-count-value" data-value="">
                    <span class="progress-left">
                        <span class="progress-bar border-primary"></span>
                    </span>
                    <span class="progress-right">
                        <span class="progress-bar border-primary"></span>
                    </span>
                    <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                        <div class="h2 font-weight-bold" id="profil-count-text">0<sup class="small">%</sup></div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/win.svg')}}" width="20" class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Prestasi Event</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2" id="event-prestasi-text" >0</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Event</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/medal.svg')}}" width="20" class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Event Favorit</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2" id="event-favourite-text">0</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Event</span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-dash-title pb-3" style="border-bottom: 1px solid #d8d8d8">
                <div class="row mt-2">
                    <div class="col-8">
                        <img src="{{url('assets/deskapp/vendors/images/icon/group.svg')}}" width="20" class="img-fluid ml-2 d-inline" alt="">
                        <span class="d-inline ml-2 text-secondary mt-2">Total Tim</span>
                    </div>
                    <div class="col-4 text-right ">
                        <a href="#" class="card-dash-link">Detail <i class="icofont-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-dash-body mt-4">
                <span class="d-inline card-body-number ml-2" id="tim-event-text">0</span>
                <span class="d-inline ml-1 text-secondary" style="font-size: 20px">Tim</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    
<script>
    const profilePrecentage = () => {
        $(".progress").each(function() {
            var value = $(this).data('value');
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
    }

    const profilePrecentageAfter = (value) => {
        $(".progress").each(function() {
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
    }

    $(document).ready( function () {
        getAllData();
        profilePrecentage();
    });

    const getAllData = () => {
        $.ajax({
            url: "/peserta/dashboard/getalldata",
            type:"GET",
            dataType: "json",
            success: function(values){
                console.log(values);
                let profile_html = `${values.profil_has_filled}<sup class="small">%</sup>`;

                $('#event-active-text').text(values.event_active_count);
                $('#event-total-text').text(values.event_active_count + values.event_inactive_count);
                $('#event-prestasi-text').text(values.prestasi_count);
                $('#event-favourite-text').text(values.event_favourites);
                // $('#profil-count-value').data("value", values.profil_has_filled);
                $('#profil-count-text').html(profile_html);
                profilePrecentageAfter(values.profil_has_filled);
                $('#tim-event-text').text(values.tim_count);
                
            },
            error:function(err){
                console.log(err);
            },
        });
    }

   
</script>

@endpush
