@extends('ormawa.app')

@section('title','Timeline Event')

@push('css')
<style>
    .nav-link:hover {
        color: #f5a461 !important;
    }

</style>
@endpush

@section('content')


<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
        <div class="card mb-3">
            <div class="card-body">
                <div class="tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-orange" data-toggle="tab" href="#internal" role="tab"
                                aria-selected="true">Pengumuman Event Internal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-orange" data-toggle="tab" href="#eksternal" role="tab"
                                aria-selected="false">Pengumuman Event Eksternal</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="internal" role="tabpanel">
                <div class="row mt-3">
                    <div class="col-lg-6 col-12">
                        <div class="form-group row">
                            <div class="col-sm-5">
                                <select class="form-control" id="event-internal-select">
                                    <option selected>Pilih Event</option>
                                    @foreach ($eis as $ei)
                                    <option value="{{$ei->id_event_internal}}">{{$ei->nama_event}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 text-right pt-2">
                        @if (Session::get('is_pembina')=="0" )
                        <a data-toggle="modal" data-target="#modal-internal-notif" type="button" id="tambah-btn"
                            class="text-white dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                            style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                            Tambah</a>
                        @endif
                    </div>
                    <div class="product-wrap">
                        <div class="product-list">
                            <ul class="row">
                                @foreach ($plis as $pli)
                                    <li id="list_{{$pli->id_pengumuman}}" class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="product-box shadow" >
                                            <div class="producct-img">
                                                @if ($pli->photo)
                                                    <img src="{{asset('assets/img/notif-event/'. $pli->photo)}}" alt="">
                                                @else
                                                    <img src="{{asset('assets/img/kompetisi-thumb/'. $pli->eventInternalRef->poster_image)}}"
                                                        alt="">
                                                @endif
                                            </div>
                                            <div class="product-caption">
                                                <h4><a href="#">{{$pli->title}}</a></h4>
                                                <div class="text-secondary">
                                                    {!!$pli->deskripsi_excerpt!!}
                                                </div>
                                                <div class="d-block">
                                                    <a href="{{route('ormawa.pengumuman.detail', $pli->id_pengumuman)}}"
                                                        style="font-size: 20px !important"
                                                        class="text-orange d-inline mr-2"><i style="font-size: 20px"
                                                            class="icon-copy dw dw-eye"></i></a>
                                                    @if (Session::get('is_pembina')=="0" )
                                                    <a href="{{route('ormawa.pengumuman.editinternal', $pli->id_pengumuman)}}"
                                                        style="font-size: 20px !important"
                                                        class="text-orange d-inline mr-2"><i
                                                            class="icon-copy dw dw-edit-1"></i></a>
                                                    @php
                                                        $pliJson = json_encode($pli);
                                                    @endphp
                                                    <a href="#" onclick="deletePengumuman({{$pliJson}})"
                                                        style="font-size: 20px !important"
                                                        class="text-orange d-inline"><i
                                                            class="icon-copy dw dw-trash"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Pagination --}}
                        {{ $plis->links('vendor.pagination.ormawa_pagination') }}
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="eksternal" role="tabpanel">
                {{-- Pengumuman EVENT EKSTERNAL --}}
                <div class="row mt-3">
                    <div class="col-lg-6 col-12">
                        <div class="form-group row">
                            <div class="col-sm-5">
                                <select class="form-control" id="event-eksternal-select">
                                    <option selected>Pilih Event</option>
                                    @foreach ($ees as $ee)
                                    <option value="{{$ee->id_event_internal}}">{{$ee->nama_event}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 text-right pt-2">
                        @if (Session::get('is_pembina')=="0" )
                        <a data-toggle="modal" data-target="#modal-eksternal-notif" type="button" id="tambah-btn"
                            class="text-white dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                            style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                            Tambah</a>
                        @endif
                    </div>
                    <div class="product-wrap">
                        <div class="product-list">
                            <ul class="row">
                                @foreach ($ples as $ple)
                                    <li id="list_{{$ple->id_pengumuman}}" class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="product-box shadow" >
                                            <div class="producct-img">
                                                @if ($ple->photo)
                                                    <img src="{{asset('assets/img/notif-event/'. $ple->photo)}}" alt="">
                                                @else
                                                    <img src="{{asset('assets/img/kompetisi-thumb/'. $ple->eventEksternalRef->poster_image)}}"
                                                        alt="">
                                                @endif
                                            </div>
                                            <div class="product-caption">
                                                <h4><a href="#">{{$ple->title}}</a></h4>
                                                <div class="text-secondary">
                                                    {!!$ple->deskripsi_excerpt!!}
                                                </div>
                                                <div class="d-block">
                                                    <a href="{{route('ormawa.pengumuman.detail', $ple->id_pengumuman)}}"
                                                        style="font-size: 20px !important"
                                                        class="text-orange d-inline mr-2"><i style="font-size: 20px"
                                                            class="icon-copy dw dw-eye"></i></a>
                                                    @if (Session::get('is_pembina')=="0" )
                                                    <a href="{{route('ormawa.pengumuman.editeksternal', $ple->id_pengumuman)}}"
                                                        style="font-size: 20px !important"
                                                        class="text-orange d-inline mr-2"><i
                                                            class="icon-copy dw dw-edit-1"></i></a>
                                                    @php
                                                        $pleJson = json_encode($ple);
                                                    @endphp
                                                    <a href="#" onclick="deletePengumuman({{$pleJson}})"
                                                        style="font-size: 20px !important"
                                                        class="text-orange d-inline"><i
                                                            class="icon-copy dw dw-trash"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Pagination --}}
                        {{ $ples->links('vendor.pagination.ormawa_pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Internal --}}
<div style="border: none !important" class="modal fade" id="modal-internal-notif" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-orange" id="myLargeModalLabel"><i class="icon-copy dw dw-bell mr-2"></i>Tambah Pengumuman</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{route('ormawa.pengumuman.save','internal')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Pilih Event</label>
                        <select name="event_id" id="" class="form-control">
                            <option selected>Nama Event</option>
                            @foreach ($eis as $ei)
                            <option value="{{$ei->id_event_internal}}">{{$ei->nama_event}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('event_id'))
                        <span class="text-danger">{{ $errors->first('event_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Judul Pengumuman*</label>
                        <input type="text" name="title" id="" class="form-control">
                        @if ($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi Pengumuman*</label>
                        <textarea name="deskripsi" id="deskripsi-inp-internal"></textarea>
                        @if ($errors->has('deskripsi'))
                        <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Photo Pengumuman</label>
                        <input type="file" name="photo" id="" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Tambah Eksternal --}}
<div style="border: none !important" class="modal fade" id="modal-eksternal-notif" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-orange" id="myLargeModalLabel"><i class="icon-copy dw dw-bell mr-2"></i>Tambah Pengumuman</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{route('ormawa.pengumuman.save','eksternal')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Pilih Event</label>
                        <select name="event_id" id="" class="form-control">
                            <option selected>Nama Event</option>
                            @foreach ($ees as $ee)
                            <option value="{{$ee->id_event_eksternal}}">{{$ee->nama_event}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('event_id'))
                        <span class="text-danger">{{ $errors->first('event_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Judul Pengumuman*</label>
                        <input type="text" name="title" id="" class="form-control">
                        @if ($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi Pengumuman*</label>
                        <textarea name="deskripsi" id="deskripsi-inp-eksternal"></textarea>
                        @if ($errors->has('deskripsi'))
                        <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Photo Pengumuman</label>
                        <input type="file" name="photo" id="" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ url('assets/ckeditor/ckeditor.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready( function () {
        CKEDITOR.replace( 'deskripsi-inp-internal',{
            customConfig: '/public/assets/ckeditor/ckeditor_ormawa_profil.js'
        });

        CKEDITOR.replace( 'deskripsi-inp-eksternal',{
            customConfig: '/public/assets/ckeditor/ckeditor_ormawa_profil.js'
        });
    } );

    const deletePengumuman = (values) => {
        let id_pengumuman = values.id_pengumuman;
        let url = "/ormawa/pengumuman/delete/"+id_pengumuman;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            values.title,
            'Apakah anda yakin ingin menghapus?',
            'Yes',
            'No',
        function(){ 
            $.ajax(
                {
                    url: url,
                    type: 'delete', 
                    dataType: "JSON",
                    data: {
                        "id_pengumuman": id_pengumuman
                    },
                    success: function (response){
                        console.log(response.status); 
                        if(response.status == 1){
                            Notiflix.Notify.Success(response.message);
                            $('#list_' + id_pengumuman).remove();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Notiflix.Notify.Failure('Ooopss');
                    }
            });
        }, function(){
                // No button callback alert('If you say so...'); 
        } ); 
    }
</script>

@endpush