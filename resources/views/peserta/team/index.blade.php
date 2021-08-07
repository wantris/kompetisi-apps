@extends('peserta.app')

@section('title','Tim')

@section('content')

<div class="container-fluid" style="margin-bottom:50px">
    <div class="row">
        <div class="col-12 mb-2">
            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active  pb-2" data-toggle="tab" href="#internal" role="tab" aria-selected="true">Event Internal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pb-2" data-toggle="tab" href="#eksternal" role="tab" aria-selected="false">Event Eksternal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pb-2" data-toggle="tab" href="#invite" role="tab" aria-selected="false">Undangan Tim</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="internal" role="tabpanel">
                    <div class="pd-20">
                        <div class="product-wrap">
                            <div class="product-list">
                                <ul class="row">
                                    @foreach ($tims as $tim)
                                        @if ($tim->eventInternalRegisRef)
                                            <li class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="product-box">
                                                    <div class="producct-img"><img src="{{url('assets/img/kompetisi-thumb/'.$tim->eventInternalRegisRef->eventInternalRef->poster_image)}}" alt=""></div>
                                                    <div class="product-caption">
                                                        <h4><a href="{{route('peserta.team.detail', $tim->id_tim_event)}}">{{$tim->eventInternalRegisRef->eventInternalRef->nama_event}}</a></h4>
                                                        <small class="text-muted">Oleh: <a href="#" class="text-orange" target="_blank" rel="noopener noreferrer">
                                                            {{$tim->eventInternalRegisRef->eventInternalRef->ormawaRef->nama_ormawa}}
                                                        </a></small>
                                                        <div class="mb-3">
                                                            @php
                                                                $jlm_tim = collect();
                                                                foreach ($tim->timDetailRef as $key => $anggota) {
                                                                   if($anggota->status == "Done"){
                                                                       $jlm_tim->push($anggota);
                                                                   }
                                                                }
                                                            @endphp
                                                            <small class="text-muted">{{$jlm_tim->count()}} Orang</small>
                                                        </div>
                                                        <span class="my-3 d-block" style="font-size: 12px">Terdaftar: {{$tim->eventInternalRegisRef->created_at->isoFormat('D MMM Y')}}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade " id="eksternal" role="tabpanel">
                    <div class="pd-20">
                        <div class="product-wrap">
                            <div class="product-list">
                                <ul class="row">
                                    @foreach ($tims as $tim)
                                        @if ($tim->eventEksternalRegisRef)
                                            <li class="col-lg-4 col-md-6 col-sm-12" style="list-style-type: none">
                                                <div class="product-box">
                                                    <div class="producct-img"><img src="{{url('assets/img/kompetisi-thumb/'.$tim->eventEksternalRegisRef->eventEksternalRef->poster_image)}}" alt=""></div>
                                                    <div class="product-caption">
                                                        <h4><a href="{{route('peserta.team.detail', $tim->id_tim_event)}}">{{$tim->eventEksternalRegisRef->eventEksternalRef->nama_event}}</a></h4>
                                                        <small class="text-muted">Oleh: <a href="#" class="text-orange" target="_blank" rel="noopener noreferrer">
                                                            {{$tim->eventEksternalRegisRef->eventEksternalRef->cakupanOrmawaRef->role}}
                                                        </a></small>
                                                        <div class="mb-3">
                                                            @php
                                                                $jlm_tim = collect();
                                                                foreach ($tim->timDetailRef as $key => $anggota) {
                                                                    if($anggota->status == "Done"){
                                                                        $jlm_tim->push($anggota);
                                                                    }
                                                                }
                                                            @endphp
                                                            <small class="text-muted">{{$jlm_tim->count()}} Orang</small>
                                                        </div>
                                                        <span class="my-3 d-block" style="font-size: 12px">Terdaftar: {{$tim->eventEksternalRegisRef->created_at->isoFormat('D MMM Y')}}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" style="margin-bottom: 40px !important" id="invite" role="tabpanel">
                    <div class="card-box mb-5 mt-3">
                        <div class="card-body">
                            <table class="stripe table nowrap" id="tim-undangan-table">
                                <thead>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($tim_pendings as $item)
                                        @foreach ($item->timDetailRef as $invite)
                                            @if ($invite->role == "anggota")
                                            @if ($pengguna->nim == $invite->nim || $pengguna->participant_id == $invite->participant_id)
                                            <tr id="tr_{{$invite->id_tim_event_detail}}">
                                                <td >
                                                    <div class="d-flex flex-items-center">
                                                        <div class="mx-3">
                                                            @if ($invite->invited_by->photo)
                                                                <img  src="{{asset('assets/img/photo-pengguna/'.$invite->photo)}}" style="width: 30px ;height:30px; border-radius:50%"  id="profil-image" alt="">
                                                            @else
                                                                <img  src="{{asset('assets/img/icon/pengguna_icon2.png')}}" style="width: 30px ;height:30px; border-radius:50%" id="profil-image" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="d-flex flex-column flex-auto">
                                                            @if ($invite->invited_by->nim)
                                                                <a href="#" class="text-orange"><strong>{{$invite->invited_by->mahasiswaRef->mahasiswa_nama}}</strong></a>
                                                                <small class="text-secondary">{{$invite->invited_by->role}}</small>
                                                            @else
                                                                <a href="#" class="text-orange"><strong>{{$invite->invited_by->participantRef->nama_participant}}</strong></a>
                                                                <small class="text-secondary">{{$invite->invited_by->role}}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td> 
                                                    @if ($invite->timEventRef->eventInternalRegisRef)
                                                        {{$invite->timEventRef->eventInternalRegisRef->eventInternalRef->nama_event}}
                                                    @else
                                                        {{$invite->timEventRef->eventEksternalRegisRef->eventEksternalRef->nama_event}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $json = json_encode($invite);
                                                    @endphp
                                                    <a href="#" onclick="terimaUndangan({{$json}})" class="btn btn-primary d-inline mr-2" style="font-size: 13px" title="Terima"><i class="icon-copy dw dw-checked"></i></a>
                                                    <a href="#" onclick="tolakUndangan({{$json}})" class="btn btn-danger d-inline" style="font-size: 13px" title="Tolak"><i class="icon-copy dw dw-ban"></i></a>
                                                </td>
                                            </tr>
                                            @endif
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
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

         $(document).ready( function () {
            $('#tim-undangan-table').DataTable({
                "bLengthChange": false,
                "fnDrawCallback": function ( oSettings ) {
                    $(oSettings.nTHead).hide();
                },
                "language": {
                    "emptyTable": "Tidak ada undangan"
                }
            });
        } );

        const terimaUndangan = (values) => {
            let id_tim = values.tim_event_id;
            let id_detail = values.id_tim_event_detail;
            let url = "/peserta/team/users/invite/accept/"+id_tim;
            event.preventDefault();
            Notiflix.Confirm.Show( 
                'Undangan Tim',
                'Anda yakin ingin menerima undangan?',
                'Yes',
                'No',
            function(){ 
                $.ajax(
                    {
                        url: url,
                        type: 'patch', 
                        dataType: "JSON",
                        data: {
                            "id_detail": id_detail
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                location.reload();
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

        const tolakUndangan = (values) => {
            let id_tim = values.tim_event_id;
            let id_detail = values.id_tim_event_detail;
            let url = "/peserta/team/users/invite/denied/"+id_tim;
            event.preventDefault();
            Notiflix.Confirm.Show( 
                'Undangan Tim',
                'Anda yakin ingin menolak undangan?',
                'Yes',
                'No',
            function(){ 
                $.ajax(
                    {
                        url: url,
                        type: 'delete', 
                        dataType: "JSON",
                        data: {
                            "id_detail": id_detail
                        },
                        success: function (response){
                            console.log(response.status); 
                            if(response.status == 1){
                                Notiflix.Notify.Success(response.message);
                                location.reload();
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