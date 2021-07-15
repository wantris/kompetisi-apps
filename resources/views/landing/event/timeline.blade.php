@extends('template')

@section('title', $slug)

@push('cs-css')
<style>
    .circle {
  padding: 13px 20px;
  border-radius: 50%;
  background-color: #126AFE;
  color: #fff;
  max-height: 50px;
  z-index: 2;
}

.how-it-works.row .col-2 {
  align-self: stretch;
}
.how-it-works.row .col-2::after {
  content: "";
  position: absolute;
  border-left: 3px solid #126AFE;
  z-index: 1;
}
.how-it-works.row .col-2.bottom::after {
  height: 50%;
  left: 50%;
  top: 50%;
}
.how-it-works.row .col-2.full::after {
  height: 100%;
  left: calc(50% - 3px);
}
.how-it-works.row .col-2.top::after {
  height: 50%;
  left: 50%;
  top: 0;
}


.timeline div {
  padding: 0;
  height: 40px;
}
.timeline hr {
  border-top: 3px solid #126AFE;
  margin: 0;
  top: 17px;
  position: relative;
}
.timeline .col-2 {
  display: flex;
  overflow: hidden;
}
.timeline .corner {
  border: 3px solid #126AFE;
  width: 100%;
  position: relative;
  border-radius: 15px;
}
.timeline .top-right {
  left: 50%;
  top: -50%;
}
.timeline .left-bottom {
  left: -50%;
  top: calc(50% - 3px);
}
.timeline .top-left {
  left: -50%;
  top: -50%;
}
.timeline .right-bottom {
  left: 50%;
  top: calc(50% - 3px);
}

</style>
@endpush


@section('content')
<div class="container my-5">
    <h3 class="pb-3 pt-2 mb-5" style="border-bottom: 1px solid #126AFE">Seminar {{$event->nama_event}}</h3>
    <!--first section-->
    @foreach ($tls as $tl)
        @if($loop->iteration % 2 != 0)
          <div class="row align-items-center how-it-works d-flex">
            <div class="col-2 text-center bottom d-inline-flex justify-content-center align-items-center">
              <div class="circle font-weight-bold">{{$loop->iteration}}</div>
            </div>
            <div class="col-6">
              <h5>{{$tl->title}}</h5>

              {!!$tl->deskripsi!!}
              @php
                $target = Carbon\Carbon::parse($tl->tgl_jadwal)->toDatetime()->format('d
                M
                Y');
              @endphp
              <small class="text-primary">Mulai {{$target}}</small>
            </div>
          </div>
          <!--path between 1-2-->
          <div class="row timeline">
            <div class="col-2">
              <div class="corner top-right"></div>
            </div>
            <div class="col-8">
              <hr/>
            </div>
            <div class="col-2">
              <div class="corner left-bottom"></div>
            </div>
          </div>
        @else
          <!--second section-->
            <div class="row align-items-center justify-content-end how-it-works d-flex">
              <div class="col-6 text-right">
                <h5>{{$tl->title}}</h5>

                {!!$tl->deskripsi!!}
              </div>
              <div class="col-2 text-center full d-inline-flex justify-content-center align-items-center">
                <div class="circle font-weight-bold">{{$loop->iteration}}</div>
              </div>
            </div>
            <!--path between 2-3-->
            <div class="row timeline">
              <div class="col-2">
                <div class="corner right-bottom"></div>
              </div>
              <div class="col-8">
                <hr/>
              </div>
              <div class="col-2">
                <div class="corner top-left"></div>
              </div>
            </div>
        @endif
    @endforeach


    {{-- <!--third section-->
    <div class="row align-items-center how-it-works d-flex">
      <div class="col-2 text-center top d-inline-flex justify-content-center align-items-center">
        <div class="circle font-weight-bold">3</div>
      </div>
      <div class="col-6">
        <h5>Lorem Ipsum</h5>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed porttitor gravida aliquam. Morbi orci urna, iaculis in ligula et, posuere interdum lectus.</p>
      </div>
    </div> --}}
  </div>
@endsection