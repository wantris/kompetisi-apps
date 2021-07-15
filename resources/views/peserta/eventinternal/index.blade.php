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
        <div class="">
            <div class="tab">
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active  pb-2" data-toggle="tab" href="#home2" role="tab" aria-selected="true">Event Aktif</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pb-2" data-toggle="tab" href="#profile2" role="tab" aria-selected="false">Event Favorit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pb-2" data-toggle="tab" href="#contact2" role="tab" aria-selected="false">Event Lalu</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="home2" role="tabpanel">
                        <div class="pd-20">
                            <div class="row mt-3">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <select class="form-control selectpicker"  name="" id="select-ormawa-active" data-size="5">
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
                                        <div class="card card-box" style="outline: none !important; border:none !important">
                                            <div class='star-div'><i class="icon-copy fa fa-star text-orange fa-lg float-right mr-2 mt-2" aria-hidden="true"></i></div>
                                            <img class="card-img-top" src="{{url('assets/img/kompetisi-thumb/'.$active->eventInternalRef->poster_image)}}" alt="Card image cap">
                                            <div class="card-body">
                                                @php
                                                    $deskripsi = Illuminate\Support\Str::limit($active->eventInternalRef->deskripsi, 100, $end='.......');
                                                    $slug = \Str::slug($active->eventInternalRef->nama_event);
                                                @endphp
                                                <h5 class="card-title weight-500"><a href="{{route('peserta.eventinternal.detail', $slug)}}">{{$active->eventInternalRef->nama_event}}</a></h5>
                                                <div class="text-secondary">
                                                    {!!$deskripsi!!}
                                                </div>
                                                <p class="card-text"><small class="text-muted"  style="color: #ed8512 !important"><i class="icon-copy dw dw-checked text-orange mr-1" aria-hidden="true"></i> Terdaftar {{$active->created_at->diffForHumans()}}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile2" role="tabpanel">
                        <div class="pd-20">
                            <div class="row mt-3">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <select class="form-control selectpicker" name="" id="" data-size="5">
                                        <option selected>Semua Oramawa</option>
                                        @foreach ($ormawas as $ormawa)
                                            <option value="{{$ormawa->id_ormawa}}">{{$ormawa->nama_ormawa}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <select class="form-control selectpicker" name="" id="">
                                        <option selected>Semua Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{$kategori->id_kategori}}">{{$kategori->nama_kategori}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 col-md-6 col-lg-4 mb-30">
                                    <div class="card card-box" style="position: relative">
                                        <div class='star-div'><i class="icon-copy fa fa-star text-orange fa-lg float-right mr-2 mt-2" aria-hidden="true"></i></div>
                                        <img class="card-img-top" src="{{url('assets/img/kompetisi-thumb/thumbnail.jpg')}}" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title weight-500"><a href="{{route('peserta.eventinternal.detail','Design-Competition')}}">Design Competition</a></h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-muted">Terdaftar 3 hari lalu</small></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4 mb-30">
                                    <div class="card card-box" style="position: relative">
                                        <div class='star-div'><i class="icon-copy fa fa-star text-orange fa-lg float-right mr-2 mt-2" aria-hidden="true"></i></div>
                                        <img class="card-img-top" src="{{url('assets/img/kompetisi-thumb/thumbnail.jpg')}}" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title weight-500">Design Competition</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-muted">Terdaftar 3 hari lalu</small></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4 mb-30">
                                    <div class="card card-box" style="position: relative">
                                        <div class='star-div'><i class="icon-copy fa fa-star text-orange fa-lg float-right mr-2 mt-2" aria-hidden="true"></i></div>
                                        <img class="card-img-top" src="{{url('assets/img/kompetisi-thumb/thumbnail.jpg')}}" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title weight-500">Design Competition</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-muted">Terdaftar 3 hari lalu</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact2" role="tabpanel">
                        <div class="pd-20">
                            <div class="row mt-3">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <select class="form-control selectpicker" name="" id="" data-size="5">
                                        <option selected>Semua Oramawa</option>
                                        @foreach ($ormawas as $ormawa)
                                            <option value="{{$ormawa->id_ormawa}}">{{$ormawa->nama_ormawa}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <select class="form-control selectpicker" name="" id="">
                                        <option selected>Semua Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{$kategori->id_kategori}}">{{$kategori->nama_kategori}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-5">
                                @foreach ($inactive_regis as $inactive)
                                    <div class="col-sm-12 col-md-6 col-lg-4 mb-30">
                                        <div class="card card-box" style="position: relative">
                                            <div class='star-div'><i class="icon-copy dw dw-checked text-orange dw-lg font-weight-bold float-right mr-2 mt-2" aria-hidden="true"></i></div>
                                            <img class="card-img-top" src="{{url('assets/img/banner-komp/'.$inactive->eventInternalRef->banner_image)}}" alt="Card image cap">
                                            <div class="card-body">
                                                @php
                                                    $desc_inactive = Illuminate\Support\Str::limit($inactive->eventInternalRef->deskripsi, 100, $end='.......');
                                                @endphp
                                                <h5 class="card-title weight-500">{{$inactive->eventInternalRef->nama_event}}</h5>
                                                <div class="text-secondary">
                                                    {!!$desc_inactive!!}
                                                </div>
                                                <p class="card-text"><small class="text-muted"  style="color: #ed8512 !important"><i class="icon-copy dw dw-checked text-orange mr-1" aria-hidden="true"></i> Terdaftar {{$inactive->created_at->diffForHumans()}}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
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

