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


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <p class="h5 text-orange" id="title-pembina"><i class="icon-copy dw dw-user-2 mr-2"></i>Update Pengumuman
                        </p>
                    </div>
                    <div class="col-6 text-right">
                        <div id="container-btn">
                            <a href="{{route('ormawa.pengumuman.index')}}" id="tambah-btn" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                Kembali</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <form action="{{route('ormawa.pengumuman.update', $pn->id_pengumuman)}}" enctype="multipart/form-data" method="post">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="type" value="{{$type}}">
                            <div class="form-group">
                                <label for="">Pilih Event</label>
                                <select name="event_id" id="" class="form-control">
                                    @if ($type == "internal")
                                        <option value="{{$pn->event_internal_id}}" selected>{{$pn->eventInternalRef->nama_event}}</option>
                                        @foreach ($eis as $ei)
                                            <option value="{{$ei->id_event_internal}}">{{$ei->nama_event}}</option>
                                        @endforeach
                                    @else
                                        <option value="{{$pn->event_eksternal_id}}" selected>{{$pn->eventEksternalRef->nama_event}}</option>
                                        @foreach ($ees as $ee)
                                            <option value="{{$ee->id_event_internal}}">{{$ee->nama_event}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('event_id'))
                                    <span class="text-danger">{{ $errors->first('event_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Judul Pengumuman*</label>
                                <input type="text" name="title" value="{{$pn->title}}" id="" class="form-control">
                                @if ($errors->has('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Deskripsi Pengumuman*</label>
                                <textarea name="deskripsi" id="deskripsi-inp" >{{$pn->deskripsi}}</textarea>
                                @if ($errors->has('deskripsi'))
                                    <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Photo Pengumuman</label>
                                <input type="file" onchange="previewPhotoImage()" name="photo" id="photo-inp" class="form-control">
                                <input type="hidden" name="oldPhoto" value="{{$pn->photo}}">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Submit"  class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                    style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-12">
                         @if ($pn->photo)
                            <img id="photo-image" data-check="true" data-filename="{{$pn->photo}}" src="{{asset('assets/img/notif-event/'. $pn->photo)}}" alt="" class="img-fluid">
                        @else
                            <img id="photo-image" data-check="false" data-filename="{{$pn->eventInternalRef->poster_image}}" src="{{asset('assets/img/kompetisi-thumb/'. $pn->eventInternalRef->poster_image)}}" alt="" class="img-fluid">
                        @endif
                        <div id="btn-hapus-container_photo" class="mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ url('assets/ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready( function () {
         CKEDITOR.replace( 'deskripsi-inp',{
            customConfig: '/public/assets/ckeditor/ckeditor_ormawa_profil.js'
        });
    });

    const previewPhotoImage = () => {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("photo-inp").files[0]);
        oFReader.onload = (oFREvent) =>  {
                document.getElementById("photo-image").src = oFREvent.target.result;
        };

        let html = `
            <a id="hapus-photo" onclick="hapusPhoto()" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2 text-white"
                style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                <i class="icon-copy dw dw-trash1"></i></a>
        `;
        $('#btn-hapus-container_photo').html(html);
    };

    const hapusPhoto = () => {
        let fileName= $('#photo-image').data('filename');
        let check = $('#photo-image').data('check');
        let url = "";
        console.log(check);
        if(check == true){
            url = "/assets/img/notif-event/"+fileName;
        }else{
            url = "/assets/img/kompetisi-thumb/"+fileName;
        }
        
        $("#photo-image").attr("src", url);
        $('#photo-inp').val('');
        $('#btn-hapus-container_photo').html(''); 
    }
</script>

@endpush