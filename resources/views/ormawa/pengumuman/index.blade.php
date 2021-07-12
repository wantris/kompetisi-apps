@extends('ormawa.app')

@section('title','Timeline Event')

@push('css')
<style>
    .nav-link:hover {
        color: #f5a461 !important;
    }
    .dataTables_paginate {margin-top: 20px !important;}
    .dataTables_length, #timeline-table_filter{margin-bottom: 20px !important;}
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
                        <a data-toggle="modal" data-target="#modal-internal-notif" type="button" id="tambah-btn" class="text-white dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                        style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                        Tambah</a>
                    </div>
                    <div class="col-12">
                        <div class="blog-list">
                            <ul>
                                @foreach ($plis as $pli)
                                    <li id="list_{{$pli->id_pengumuman}}">
                                        <div class="row no-gutters">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <div class="blog-img">
                                                    @if ($pli->photo)
                                                        <img src="{{asset('assets/img/notif-event/'. $pli->photo)}}" alt="" class="bg_img">
                                                    @else
                                                        <img src="{{asset('assets/img/kompetisi-thumb/'. $pli->eventInternalRef->poster)}}" alt="" class="bg_img">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                <div class="blog-caption">
                                                    <h4><a href="#">{{$pli->title}}</a></h4>
                                                    <p style="margin-top: -10px; font-size:11px" class="text-secondary">{{$pli->eventInternalRef->nama_event}}</p>
                                                    <div class="blog-by">
                                                        {!!$pli->deskripsi_excerpt!!}
                                                        <div class="pt-10">
                                                            <a href="{{route('ormawa.pengumuman.detail', $pli->id_pengumuman)}}" style="font-size: 20px !important"  class="text-orange d-inline mr-2"><i style="font-size: 20px" class="icon-copy dw dw-eye"></i></a>
                                                            <a href="{{route('ormawa.pengumuman.editinternal', $pli->id_pengumuman)}}" style="font-size: 20px !important" class="text-orange d-inline mr-2"><i class="icon-copy dw dw-edit-1"></i></a>
                                                            <a href="#" onclick="deletePengumuman({{$pli->id_pengumuman}})" style="font-size: 20px !important" class="text-orange d-inline"><i class="icon-copy dw dw-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        {{ $plis->links('vendor.pagination.ormawa_pagination') }}
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="eksternal" role="tabpanel">
                
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Internal --}}
	<div style="border: none !important" class="modal fade" id="modal-internal-notif" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Tambah Pengumuman</h4>
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
                            <textarea name="deskripsi" id="deskripsi-inp" ></textarea>
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
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
         CKEDITOR.replace( 'deskripsi-inp',{
            customConfig: '/public/assets/ckeditor/ckeditor_ormawa_profil.js'
        });
    } );

    const deletePengumuman = (id_pengumuman) => {
        let url = "/ormawa/pengumuman/delete/"+id_pengumuman;
        event.preventDefault();
        Notiflix.Confirm.Show( 
            'Pengumuman',
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