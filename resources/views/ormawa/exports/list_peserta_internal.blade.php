@if ($event->role == "Individu")
    <table style="width: 100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Nomor Telepon</th>
                <th>Status Pendaftar</th>
                <th>Status Validasi</th>
                <th>Tahapan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendaftaran as $regis)
                @php
                    $tahapan_count = $regis->tahapanRegisRef->count();
                @endphp
                <tr id="tr_{{$regis->id_event_eksternal_registration}}">
                    <td rowspan="{{$tahapan_count}}">{{$loop->iteration}}</td>
                    <td rowspan="{{$tahapan_count}}">
                        @if ($regis->nim)
                            @if ($regis->mahasiswaRef)
                                {{$regis->mahasiswaRef->mahasiswa_nama}}
                            @else
                                {{$regis->nim}}
                            @endif
                        @else
                            {{$regis->participantRef->nama_participant}}
                        @endif
                    </td>
                    <td rowspan="{{$tahapan_count}}">
                        @if ($regis->nim)
                            {{$regis->penggunaMhsRef->email}}
                        @else
                            {{$regis->penggunaParticipantRef->email}}
                        @endif
                        
                    </td>
                    <td rowspan="{{$tahapan_count}}">
                        @if ($regis->nim)
                            {{$regis->penggunaMhsRef->phone}}
                        @else
                            {{$regis->penggunaParticipantRef->phone}}
                        @endif
                    </td >
                    <td rowspan="{{$tahapan_count}}">
                        Mahasiswa Polindra
                    </td>
                    <td rowspan="{{$tahapan_count}}">
                        @if ($regis->status == "0")
                            Belum
                        @else
                            Tervalidasi
                        @endif
                    </td>
                    <td>
                        @if ($regis->tahapanRegisRef->count() > 0)
                            {{$regis->tahapanRegisRef[0]->tahapanEventInternal->nama_tahapan}}
                        @endif
                    </td>
                </tr>
                @for($i=1;$i<$tahapan_count;$i++)
                    <tr>
                        <td>
                            @if ($regis->tahapanRegisRef->count() > 0)
                                {{$regis->tahapanRegisRef[$i]->tahapanEventInternal->nama_tahapan}}
                            @endif
                        </td>
                    </tr>
                @endfor
            @endforeach
        </tbody>
    </table>
@else
    <table style="width: 100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID Tim</th>
                <th>Pembimbing</th>
                <th>Keanggotaan</th>
                <th>Role</th>
                <th>Email</th>
                <th>Nomor Telepon</th>
                <th>Status Validasi</th>
                <th>Tahapan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendaftaran as $regis)
                @php
                    $not_done = collect();
                    foreach ($regis->timRef->timDetailRef as $item) {
                        if ($item->status == "Done") {
                            $not_done->push($item);
                        }
                    }
                    $total_count = 0;
                    $detail_count = $not_done->count();
                    $tahapan_count = $regis->tahapanRegisRef->count();
                    if($detail_count > $tahapan_count){
                        $total_count = $detail_count;
                    }else{
                        $total_count =$tahapan_count;
                    }
                @endphp
                <tr id="tr_{{$regis->id_event_eksternal_registration}}">
                    <td rowspan="{{$total_count}}">{{$loop->iteration}}</td>
                    <td rowspan="{{$total_count}}" valign="center">{{$regis->tim_event_id}}</td>
                    <td rowspan="{{$total_count}}" valign="center">
                        @if ($regis->timRef->pembimbingRef)
                            {{$regis->timRef->pembimbingRef->dosen_lengkap_nama}}
                        @else
                            {{$regis->timRef->nidn}}
                        @endif
                    </td>
                    <td valign="center">
                        @if ($regis->timRef->timDetailRef[0]->nim)
                            @if ($regis->timRef->timDetailRef[0]->mahasiswaRef)
                                {{$regis->timRef->timDetailRef[0]->mahasiswaRef->mahasiswa_nama}}
                            @else
                                {{$regis->timRef->timDetailRef[0]->nim}}
                            @endif
                        @else
                            {{$regis->timRef->timDetailRef[0]->participantRef->nama_participant}}
                        @endif
                    </td>
                    <td  valign="center">
                        {{ucfirst($regis->timRef->timDetailRef[0]->role)}} 
                    </td>
                    <td  valign="center">
                        @if ($regis->timRef->timDetailRef[0]->nim)
                            {{$regis->timRef->timDetailRef[0]->penggunaMhsRef->email}}
                        @else
                            {{$regis->timRef->timDetailRef[0]->penggunaParticipantRef->email}}
                        @endif
                    </td>
                    <td  valign="center">
                        @if ($regis->timRef->timDetailRef[0]->nim)
                            {{$regis->timRef->timDetailRef[0]->penggunaMhsRef->phone}}
                        @else
                            {{$regis->timRef->timDetailRef[0]->penggunaParticipantRef->phone}}
                        @endif
                    </td>
                    <td rowspan="{{$total_count}}" valign="center">
                        @if ($regis->status == "0")
                            Belum 
                        @else
                            Tervalidasi
                        @endif
                    </td>
                    <td>
                        @if ($regis->tahapanRegisRef->count() > 0)
                            {{$regis->tahapanRegisRef[0]->tahapanEventInternal->nama_tahapan}}
                        @endif
                    </td>
                </tr>
                @for($i=1;$i<$total_count;$i++)
                    <tr>
                        @if (!empty($regis->timRef->timDetailRef[$i]))
                            @if ($regis->timRef->timDetailRef[$i]->status == "Done")
                                <td valign="center">
                                    @if ($regis->timRef->timDetailRef[$i]->nim)
                                        @if ($regis->timRef->timDetailRef[$i]->mahasiswaRef)
                                            {{$regis->timRef->timDetailRef[$i]->mahasiswaRef->mahasiswa_nama}}
                                        @else
                                            {{$regis->timRef->timDetailRef[$i]->nim}}
                                        @endif
                                    @else
                                        {{$regis->timRef->timDetailRef[$i]->participantRef->nama_participant}}
                                    @endif
                                </td>
                                <td valign="center">
                                    {{ucfirst($regis->timRef->timDetailRef[$i]->role)}}
                                </td>
                                <td valign="center">
                                    @if ($regis->timRef->timDetailRef[$i]->nim)
                                        {{$regis->timRef->timDetailRef[$i]->penggunaMhsRef->email}}
                                    @else
                                        {{$regis->timRef->timDetailRef[$i]->penggunaParticipantRef->email}}
                                    @endif
                                </td>
                                <td valign="center">
                                    @if ($regis->timRef->timDetailRef[$i]->nim)
                                        {{$regis->timRef->timDetailRef[$i]->penggunaMhsRef->phone}}
                                    @else
                                        {{$regis->timRef->timDetailRef[$i]->penggunaParticipantRef->phone}}
                                    @endif
                                </td>
                            @else
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @endif
                        @else
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        @endif
                        
                        @if (!empty($regis->tahapanRegisRef[$i]))
                        <td>
                            @if ($regis->tahapanRegisRef->count() > 0)
                                {{$regis->tahapanRegisRef[$i]->tahapanEventInternal->nama_tahapan}}
                            @endif
                        </td>
                        @else
                            <td></td>
                        @endif
                    </tr>
                @endfor
            @endforeach
        </tbody>
    </table> 
@endif

