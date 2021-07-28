@if ($event->role == "Individu")
    <table style="width: 100%">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Nomor Telepon</th>
                <th>Status Pendaftar</th>
                <th>Status Validasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendaftaran as $regis)
                <tr id="tr_{{$regis->id_event_eksternal_registration}}">
                    <td>
                        @if ($regis->nim)
                            {{$regis->mahasiswaRef->nama}}
                        @else
                            {{$regis->participantRef->nama_participant}}
                        @endif
                    </td>
                    <td>
                        @if ($regis->nim)
                            {{$regis->penggunaMhsRef->email}}
                        @else
                            {{$regis->penggunaParticipantRef->email}}
                        @endif
                        
                    </td>
                    <td>
                        @if ($regis->nim)
                            {{$regis->penggunaMhsRef->phone}}
                        @else
                            {{$regis->penggunaParticipantRef->phone}}
                        @endif
                    </td>
                    <td>
                        Mahasiswa Polindra
                    </td>
                    <td>
                        @if ($regis->status == "0")
                            Belum
                        @else
                            Tervalidasi
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <table style="width: 100%">
        <thead>
            <tr>
                <th>ID Tim</th>
                <th>Pembimbing</th>
                <th>Keanggotaan</th>
                <th>Role</th>
                <th>Email</th>
                <th>Nomor Telepon</th>
                <th>Status Validasi</th>
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
                    $count = $not_done->count();
                @endphp
                <tr id="tr_{{$regis->id_event_eksternal_registration}}">
                    <td rowspan="{{$count}}" valign="center">{{$regis->tim_event_id}}</td>
                    <td rowspan="{{$count}}" valign="center">
                        @if ($regis->timRef->pembimbingRef)
                            {{$regis->timRef->pembimbingRef->nama_dosen}}
                        @endif
                    </td>
                    <td valign="center">
                        @if ($regis->timRef->timDetailRef[0]->nim)
                            {{$regis->timRef->timDetailRef[0]->mahasiswaRef->nama}}
                        @else
                            {{$regis->timRef->timDetailRef[0]->participantRef->nama_participant}}
                        @endif
                    </td>
                    <td valign="center">
                        {{ucfirst($regis->timRef->timDetailRef[0]->role)}} 
                    </td>
                    <td valign="center">
                        @if ($regis->timRef->timDetailRef[0]->nim)
                            {{$regis->timRef->timDetailRef[0]->penggunaMhsRef->email}}
                        @else
                            {{$regis->timRef->timDetailRef[0]->penggunaParticipantRef->email}}
                        @endif
                    </td>
                    <td valign="center">
                        @if ($regis->timRef->timDetailRef[0]->nim)
                            {{$regis->timRef->timDetailRef[0]->penggunaMhsRef->phone}}
                        @else
                            {{$regis->timRef->timDetailRef[0]->penggunaParticipantRef->phone}}
                        @endif
                    </td>
                    <td rowspan="{{$count}}" valign="center">
                        @if ($regis->status == "0")
                            Belum</a> 
                        @else
                            Tervalidasi
                        @endif
                    </td>
                </tr>
                @for($i=1;$i<$count;$i++)
                    @if ($regis->timRef->timDetailRef[$i]->status == "Done")
                        <tr>
                            <td valign="center">
                                @if ($regis->timRef->timDetailRef[$i]->nim)
                                    {{$regis->timRef->timDetailRef[$i]->mahasiswaRef->nama}}
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
                        </tr>
                    @endif
                @endfor
            @endforeach
        </tbody>
    </table> 
@endif

