@extends('template')

@section('title', $slug)


@section('content')

<div class="container my-5">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3 white-bg pad-4">
            <div class="card shadow">
                @php
                    $event_json = json_encode($event);
                @endphp
                <form action="{{route('event.registration.team.save', $slug)}}" id="regis-form" data-event="{{$event_json}}" method="post">
                    @csrf
                    <div class="card-body" id="">
                        <div class="row">
                            <div class="col-12 text-center">
                                <img src="{{url('assets/img/banner-komp/'.$event->banner_image)}}" class="img-fluid registration-komp-banner" alt="Responsive image">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h1 class="registration-komp-title float-left">Pendaftaran Tim</h1>
                                <a href="#" id="add-button" onclick="addAnggota({{$event_json}})" class="btn-add-person float-right"><i class="fas fa-plus"></i></a>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="" class="registration-komp-label">Ketua Tim</label>
                                @if ($user_logged->nim)
                                    <input type="text" disabled value="{{$user_logged->nama_mhs}}" class="form-control">
                                @else
                                    <input type="text" disabled value="{{$user_logged->participantRef->nama_participant}}" class="form-control">
                                @endif
                                <input type="hidden" name="ketua" value="{{$user_logged->id_pengguna}}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="" class="registration-komp-label">Anggota 1</label>
                                <div class="form-group">
                                    <select name="anggota[]" class="select-single" id="select_anggota_1" style="width: 100%">
                                        <option selected>Pilih Anggota</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="add-anggota">

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mt-4 text-center">
                                    <input type="submit" class="btn-login-mhs mt-3" style="background-color: #fb8c00 !important; border-color:#fb8c00 " value="Daftarkan Tim">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('cs-script')
    <script>
        let id = 1;



        const renderInviteSelect = (id, id_event) => {
            $.ajax({
                url: "/event/users/search/"+id_event,
                type:"GET",
                dataType: "json",
                success: function(values){
                    console.log(values);
                    $.each(values, function (i, item) {
                        if(item.is_mahasiswa){
                            $('#select_anggota_'+id).append($('<option>', { 
                                value: item.id_pengguna,
                                text : item.nama_mhs + " ("+item.username+")"
                            }));
                        }else if(item.is_participant){
                            $('#select_anggota_'+id).append($('<option>', { 
                                value: item.id_pengguna,
                                text : item.participant_ref.nama_participant + " ("+item.username+")"
                            }));
                        }
                    });
                },
                error:function(err){
                    console.log(err);
                },
            });
        }

        // add row func
        const addAnggota = (values) => {
            event.preventDefault();
            id = id +1;
            var html = '';
            html = ` <div class="row mt-3" id="inputFormRow">
                        <div class="col-12">
                            <label for="" class="registration-komp-label">Anggota ${id}</label>
                            <a href="#" id="remove-button" class="btn-add-person float-right" style="padding: 4px 4px; background-color:red !important; border-color:red"><i class="fas fa-trash"></i></a>
                            <select id="select_anggota_${id}" name="anggota[]" class="select-single" style="width: 100%">
                                <option selected>Pilih Anggota</option>
                   
                            </select>
                        </div>
                    </div>`;

            $('#add-anggota').append(html);

            renderInviteSelect(id, values.id_event_internal);
            
            $('.select-single').each(function () {
                $('.select-single').select2();
            });
        };

        $( document ).ready(function() {
            let values = $('#regis-form').data('event');
            renderInviteSelect(1, values.id_event_internal);
        });

         // remove row
         $(document).on('click', '#remove-button', function () {
            event.preventDefault();
            
            $(this).closest('#inputFormRow').remove();
        });
    </script>
@endpush