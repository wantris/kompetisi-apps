@extends('peserta.app')

@section('title', $slug)

@section('content')

    <div class="row my-5">
       <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box" style="border-radius: 20px">
                    <div class="">
                        <img src="{{url('assets/img/banner-komp/'.$event->banner_image)}}" style="border-radius: 20px" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30 mt-5">
                <div class="tab">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item mx-3 mb-3">
                            <a class="nav-link active text-blue" data-toggle="tab" href="#home5" role="tab" aria-selected="true">Deskripsi</a>
                        </li>
                        <li class="nav-item mx-3 mb-3">
                            <a class="nav-link text-blue" data-toggle="tab" href="#profile5" role="tab" aria-selected="false">Ketentuan</a>
                        </li>
                        <li class="nav-item mx-3 mb-3">
                            <a class="nav-link text-blue" data-toggle="tab" href="#contact5" role="tab" aria-selected="false">Pendaftar</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="home5" role="tabpanel">
                            <div class="pd-20">
                                {!!$event->deskripsi!!}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile5" role="tabpanel">
                            <div class="pd-20">
                                {!!$event->ketentuan!!}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact5" role="tabpanel">
                            <div class="mt-4">
                                @if ($event->role == "Individu")
                                    <table class="data-table table stripe hover nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th class="table-plus datatable-nosort">Nama</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($registrations as $item)
                                                <tr>
                                                    @if ($item->nim)
                                                        <td class="table-plus">{{$item->nama_mhs}}</td>
                                                        <td>Mahasiswa Polindra</td>
                                                    @else
                                                        <td class="table-plus">{{$item->participantRef->nama_participant}}</td>
                                                        <td>Partisipan Eksternal</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <table class="data-table table stripe hover nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th class="table-plus datatable-nosort">ID Tim</th>
                                                <th>Ketua Tim</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($registrations as $item)
                                                <tr>
                                                    <td>{{$item->tim_event_id}}</td>
                                                    <td>
                                                        @foreach ($item->timRef->timDetailRef as $detail)
                                                            @if ($detail->role == "ketua")
                                                                @if ($detail->nim)
                                                                    {{$detail->nama_mhs}}
                                                                @else
                                                                    {{$detail->participantRef->nama_participant}}
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div>
       <div class="col-lg-4 col-md-12 col-sm-12 mb-30">
            <div class="row clearfix progress-box">
                <div class="col-lg-12 col-md-4">
                    <div class="card-box pd-30 height-100-p">
                        <div class="progress-box text-center">
                            <input type="text" class="knob dial1" value="40" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#1b00ff" data-angleOffset="180" readonly>
                            <h5 class="text-blue padding-top-10 h5">Pendaftar</h5>
                            <span class="d-block">{{$registrations->count()}}/{{$event->maks_participant}} Pendaftar</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-4 mt-3">
                    <div class="card-box pd-30 height-100-p text-center">
                        <img src="{{url('assets/img/ormawa-logo/'.$event->ormawaRef->photo)}}" style="max-width: 100px" alt="" class="img-fluid">
                        <h5 class="text-blue padding-top-10 h5">HIMATIF</h5>
                    </div>
                </div>
                <div class="col-lg-12 col-md-4 mt-3">
                    <div class="card-box text-center " style="padding: 0 !important">
                        <img src="{{url('assets/img/kompetisi-thumb/'.$event->poster_image)}}" style="border-radius: 10px" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
<script>
    $(".dial1").knob();
    $({ animatedVal: 0 }).animate(
        { animatedVal: "{{$registrations->count()}}" },
        {
            duration: 3000,
            easing: "swing",
            step: function () {
                $(".dial1").val(Math.ceil(this.animatedVal)).trigger("change");
            },
        }
    );
</script>
@endpush

