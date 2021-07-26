@extends('peserta.app')

@section('title','Dashboard')


@section('content')



<div class="row">
    
    <div class="col-lg-4 col-12 mt-3">
        <div class="input-group input-underline">
            <div class="input-group-prepend">
                <button id="button-addon2" type="submit" class="btn btn-link"><i class="fa fa-search fa-lg"></i></button>
            </div>
            <input id="exampleFormControlInput1" type="email" placeholder="Cari Event" class="form-control form-control-underlined">
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="tab">
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active  pb-2" data-toggle="tab" href="#daftar-event" role="tab" aria-selected="true">Daftar Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pb-2" data-toggle="tab" href="#active" role="tab" aria-selected="false">Event Aktif</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pb-2" data-toggle="tab" href="#inactive" role="tab" aria-selected="false">Event Lalu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pb-2" data-toggle="tab" href="#favourite" role="tab" aria-selected="false">Event Favorit</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="daftar-event" role="tabpanel">
                        <div class="pd-20">
                            <div class="row mt-3">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <select class="form-control selectpicker" name="" id="select-ormawa-active" data-size="5">
                                        <option selected value="all">Semua Oramawa</option>
                                        @foreach ($ormawas as $ormawa)
                                            <option value="{{$ormawa->id_ormawa}}">{{$ormawa->nama_ormawa}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <select class="form-control selectpicker" name="" id="select-kategori-active">
                                        <option selected value="all">Semua Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{$kategori->id_kategori}}">{{$kategori->nama_kategori}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-5" id="container-event-active">
                                @foreach ($event_eksternals as $event)
                                    <div class="col-sm-12 col-md-6 col-lg-4 mb-30">
                                        <div class="komp-card2 mx-auto">
                                            <div class="komp-thumbnail" data-background="{{asset('assets/img/kompetisi-thumb/'.$event->poster_image)}}">
                                            </div>
                                            <div class="komp-banner">
                                                <div class="komp-banner__date text-left pl-2 pt-1" >  
                                                    @php
                                                        $tgl_buka = Carbon\Carbon::parse($event->tgl_buka)->toDatetime()->format('M, d Y');
                                                    @endphp
                                                    {{$tgl_buka}}
                                                </div>
                                                <div class="komp-banner__date text-right pr-2 pt-1" data-toggle="tooltip" data-placement="top" title="{{$event->cakupanOrmawaRef->ormawaRef->nama_ormawa}}">
                                                    @php
                                                        $count = str_word_count($event->cakupanOrmawaRef->ormawaRef->nama_ormawa);
                                                        $nama_ormawa = $event->cakupanOrmawaRef->ormawaRef->nama_ormawa;
                                                        if($count > 3){
                                                            $nama_ormawa = $event->cakupanOrmawaRef->ormawaRef->nama_akronim;
                                                        }
                                                    @endphp
                                                    {{$nama_ormawa}}
                                                </div>
                                            </div>
                                            <div class="komp-title pl-3">
                                                @php
                                                        $slug = \Str::slug($event->nama_event);
                                                @endphp
                                                <a href="{{route('peserta.eventeksternal.detail', $slug)}}"><h1 class="mt-3">
                                                    {{$event->nama_event}} 
                                                </h1></a>
                                            </div>
                                            <div class="komp-description pl-3 pr-3 mt-2">
                                                {!!$event->deskripsi_excerpt!!}
                                            </div>
                                            <div class="komp-created pl-3 pr-3 mt-3">
                                                <i class="icon-copy dw dw-wall-clock text-secondary mr-1 d-inline"></i>
                                                <p class="text-secondary d-inline">
                                                    {{$event->created_at->isoFormat('MMM, d Y')}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="active" role="tabpanel">
                        <div class="pd-20">
                            <div class="row mt-3">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <select class="form-control selectpicker" name="" id="select-ormawa-active" data-size="5">
                                        <option selected value="all">Semua Oramawa</option>
                                        @foreach ($ormawas as $ormawa)
                                            <option value="{{$ormawa->id_ormawa}}">{{$ormawa->nama_ormawa}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <select class="form-control selectpicker" name="" id="select-kategori-active">
                                        <option selected value="all">Semua Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{$kategori->id_kategori}}">{{$kategori->nama_kategori}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-5" id="container-event-active">
                                @foreach ($active_regis as $active)
                                    <div class="col-sm-12 col-md-6 col-lg-4 mb-30">
                                        <div class="komp-card2 mx-auto">
                                            <div class="komp-thumbnail" data-background="{{asset('assets/img/kompetisi-thumb/'.$active->eventEksternalRef->poster_image)}}">
                                            </div>
                                            <div class="komp-banner">
                                                <div class="komp-banner__date text-left pl-2 pt-1" >  
                                                    @php
                                                        $tgl_buka = Carbon\Carbon::parse($active->eventEksternalRef->tgl_buka)->toDatetime()->format('M, d Y');
                                                    @endphp
                                                    {{$tgl_buka}}
                                                </div>
                                                <div class="komp-banner__date text-right pr-2 pt-1" data-toggle="tooltip" data-placement="top" title="{{$active->eventEksternalRef->cakupanOrmawaRef->ormawaRef->nama_ormawa}}">
                                                    @php
                                                        $count = str_word_count($active->eventEksternalRef->cakupanOrmawaRef->ormawaRef->nama_ormawa);
                                                        $nama_ormawa = $active->eventEksternalRef->cakupanOrmawaRef->ormawaRef->nama_ormawa;
                                                        if($count > 3){
                                                            $nama_ormawa = $active->eventEksternalRef->cakupanOrmawaRef->ormawaRef->nama_akronim;
                                                        }
                                                    @endphp
                                                    {{$nama_ormawa}}
                                                </div>
                                            </div>
                                            <div class="komp-title pl-3">
                                                @php
                                                     $slug = \Str::slug($active->eventEksternalRef->nama_event);
                                                @endphp
                                                <a href="{{route('peserta.eventeksternal.detail', $slug)}}"><h1 class="mt-3">
                                                    {{$active->eventEksternalRef->nama_event}} 
                                                </h1></a>
                                            </div>
                                            <div class="komp-description pl-3 pr-3 mt-2">
                                                {!!$active->eventEksternalRef->deskripsi_excerpt!!}
                                            </div>
                                            <div class="komp-created pl-3 pr-3 mt-3">
                                                <p class="text-secondary d-inline">
                                                    Terdaftar {{$active->created_at->isoFormat('MMM, d Y')}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="inactive" role="tabpanel">
                        <div class="pd-20">
                            <div class="row mt-3">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <select class="form-control selectpicker" name="" id="select-ormawa-active" data-size="5">
                                        <option selected value="all">Semua Oramawa</option>
                                        @foreach ($ormawas as $ormawa)
                                            <option value="{{$ormawa->id_ormawa}}">{{$ormawa->nama_ormawa}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <select class="form-control selectpicker" name="" id="select-kategori-active">
                                        <option selected value="all">Semua Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{$kategori->id_kategori}}">{{$kategori->nama_kategori}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-5" id="container-event-active">
                                @foreach ($inactive_regis as $inactive)
                                    <div class="col-sm-12 col-md-6 col-lg-4 mb-30">
                                        <div class="komp-card2 mx-auto">
                                            <div class="komp-thumbnail" data-background="{{asset('assets/img/kompetisi-thumb/'.$inactive->eventEksternalRef->poster_image)}}">
                                            </div>
                                            <div class="komp-banner">
                                                <div class="komp-banner__date text-left pl-2 pt-1" >  
                                                    @php
                                                        $tgl_buka = Carbon\Carbon::parse($inactive->eventEksternalRef->tgl_buka)->toDatetime()->format('M, d Y');
                                                    @endphp
                                                    {{$tgl_buka}}
                                                </div>
                                                <div class="komp-banner__date text-right pr-2 pt-1" data-toggle="tooltip" data-placement="top" title="{{$inactive->eventEksternalRef->cakupanOrmawaRef->ormawaRef->nama_ormawa}}">
                                                    @php
                                                        $count = str_word_count($inactive->eventEksternalRef->cakupanOrmawaRef->ormawaRef->nama_ormawa);
                                                        $nama_ormawa = $inactive->eventEksternalRef->cakupanOrmawaRef->ormawaRef->nama_ormawa;
                                                        if($count > 3){
                                                            $nama_ormawa = $inactive->eventEksternalRef->cakupanOrmawaRef->ormawaRef->nama_akronim;
                                                        }
                                                    @endphp
                                                    {{$nama_ormawa}}
                                                </div>
                                            </div>
                                            <div class="komp-title pl-3">
                                                @php
                                                     $slug = \Str::slug($inactive->eventEksternalRef->nama_event);
                                                @endphp
                                                <a href="{{route('peserta.eventeksternal.detail', $slug)}}"><h1 class="mt-3">
                                                    {{$inactive->eventEksternalRef->nama_event}} 
                                                </h1></a>
                                            </div>
                                            <div class="komp-description pl-3 pr-3 mt-2">
                                                {!!$inactive->eventEksternalRef->deskripsi_excerpt!!}
                                            </div>
                                            <div class="komp-created pl-3 pr-3 mt-3">
                                                <p class="text-secondary d-inline">
                                                    Terdaftar {{$inactive->created_at->isoFormat('MMM, d Y')}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="favourite" role="tabpanel">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
         $("[data-background]").each(function () {
            $(this).css("background-image", "url(" + $(this).attr("data-background") + ")")
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const filterActive = (id_kategori, id_ormawa) =>{
            let url = "/peserta/eventinternal/filter/active";
            $.ajax(
                {
                    url: url,
                    type: 'POST',
                    data:{
                        'id_kategori':id_kategori,
                        'id_ormawa':id_ormawa
                    },
                    success: function (response){
                        $('#container-event-active').html(response);
                       
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Notiflix.Notify.Failure('Ooopss');
                    }
            });
        }

        $('#select-ormawa-active').on('change', function(){
            let id_ormawa = $(this).val();
            let id_kategori = $('#select-kategori-active').val();

            filterActive(id_kategori, id_ormawa);

        });

        $('#select-kategori-active').on('change', function(){
            let id_kategori = $(this).val();
            let id_ormawa = $('#select-ormawa-active').val();

            filterActive(id_kategori, id_ormawa);
            
        });
    </script>
@endpush

