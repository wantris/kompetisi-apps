@extends('ormawa.app')

@section('title','Settings Profile')

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
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <p class="h5 text-orange" id="title-pembina"><i class="icon-copy dw dw-user-2 mr-2"></i>{{$title}}
                        </p>
                    </div>
                    <div class="col-6 text-right">
                        <div id="container-btn">
                            <a href="{{route('ormawa.timeline.index')}}" id="tambah-btn" class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"
                                style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important">
                                Kembali</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <form action="{{route('ormawa.timeline.update', $type)}}" method="post">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="id_timeline" value="{{$tl->id_timeline}}">
                            <div class="form-group">
                                <label for="">Nama Dosen</label>
                                <select class="js-example-basic-single" name="event_id" style="width: 100%" >
                                    
                                    @if ($type == "eventinternal")
                                        <option value="{{$tl->event_internal_id}}" selected>{{$tl->eventInternalRef->nama_event}}</option>
                                        @foreach ($eis as $ei)
                                            @if ($ei->id_event_internal != $tl->event_internal_id)
                                               <option value="{{$ei->id_event_internal}}">{{$ei->nama_event}}</option> 
                                            @endif
                                        @endforeach
                                    @elseif($type == "eventeksternal")
                                        <option value="{{$tl->event_eksternal_id}}" selected>{{$tl->eventEksternalRef->nama_event}}</option>
                                        @foreach ($ees as $ee)
                                            @if ($ei->id_event_eksternal != $tl->event_eksternal_id)
                                                <option value="{{$ee->id_event_eksternal}}">{{$ee->nama_event}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('event_id'))
                                    <span class="text-danger">{{ $errors->first('event_id') }}</span>
                                @endif
                            </div>
                             <div class="form-group">
                                <label>Judul</label>
                                <input type="text" name="title" value="{{$tl->title}}" class="form-control" id="">
                                @if ($errors->has('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Tanggal Jadwal</label>
                                <input type="date" name="tgl_jadwal" value="{{$tl->tgl_jadwal}}" class="form-control" id="">
                                @if ($errors->has('tgl_jadwal'))
                                    <span class="text-danger">{{ $errors->first('tgl_jadwal') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi-inp" cols="30" rows="10">{{$tl->deskripsi}}</textarea>
                                @if ($errors->has('status'))
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                            <input type="submit"  class="dcd-btn dcd-btn-sm dcd-btn-primary mr-2"  style="border:none;padding:7px 20px;background: linear-gradient(60deg,#f5a461,#e86b32) !important" value="Submit">
                        </form>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    CKEDITOR.replace( 'deskripsi-inp',{
        customConfig: '/public/assets/ckeditor/ckeditor_ormawa_profil.js'
    });

    $(document).ready( function () {
        $('#pembina-table').DataTable();
        $('#form-pembina').hide();
        $('.js-example-basic-single').select2();
    } );
</script>

@endpush