@if ($event->role == "Individu")
    <table style="width: 100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Email</th>
                <th>Nomor Telepon</th>
                <th>Status Pendaftar</th>
                <th>Status Validasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendaftaran as $regis)
                <tr id="tr_{{$regis->id_event_eksternal_registration}}">
                    <td>{{$loop->iteration}}</td>
                    <td>
                        @if ($regis->mahasiswaRef)
                            {{$regis->mahasiswaRef->mahasiswa_nama}}
                        @else
                            {{$regis->nim}}
                        @endif
                    </td>
                    <td>
                        @if ($regis->mahasiswaRef)
                            {{$regis->mahasiswaRef->kelas_kode}}
                        @endif
                    </td>
                    <td>
                        {{$regis->penggunaMhsRef->email}}
                    </td>
                    <td>
                        {{$regis->penggunaMhsRef->phone}}
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
                <th>No.</th>
                <th>ID Tim</th>
                <th>Pembimbing</th>
                <th>Keanggotaan</th>
                <th>Kelas</th>
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
                    <td rowspan="{{$count}}" valign="center">{{$loop->iteration}}</td>
                    <td rowspan="{{$count}}" valign="center">{{$regis->tim_event_id}}</td>
                    <td rowspan="{{$count}}" valign="center">
                        @if ($regis->timRef->pembimbingRef)
                            {{$regis->timRef->pembimbingRef->dosen_lengkap_nama}}
                        @else
                            {{$regis->timRef->nidn}}
                        @endif
                    </td>
                    <td valign="center">
                        @if ($regis->timRef->timDetailRef[0]->mahasiswaRef)
                            {{$regis->timRef->timDetailRef[0]->mahasiswaRef->mahasiswa_nama}}
                        @else
                            {{$regis->timRef->timDetailRef[0]->nim}}
                        @endif
                    </td>
                    <td valign="center">
                        @if ($regis->timRef->timDetailRef[0]->mahasiswaRef)
                            {{$regis->timRef->timDetailRef[0]->mahasiswaRef->kelas_kode}}
                        @endif
                    </td>
                    <td valign="center">
                        {{ucfirst($regis->timRef->timDetailRef[0]->role)}} 
                    </td>
                    <td valign="center">
                        {{$regis->timRef->timDetailRef[0]->penggunaMhsRef->email}} 
                    </td>
                    <td valign="center">
                        {{$regis->timRef->timDetailRef[0]->penggunaMhsRef->phone}} 
                    </td>
                    <td rowspan="{{$count}}" valign="center">
                        @if ($regis->status == "0")
                            Belum
                        @else
                            Tervalidasi
                        @endif
                    </td>
                </tr>
                @for($i=1;$i<$count;$i++)
                    @if ($regis->timRef->timDetailRef[$i]->status == "Done")
                        <tr>
                            <td valign="center">
                                @if ($regis->timRef->timDetailRef[$i]->mahasiswaRef)
                                    {{$regis->timRef->timDetailRef[$i]->mahasiswaRef->mahasiswa_nama}}
                                @else
                                    {{$regis->timRef->timDetailRef[$i]->nim}}
                                @endif
                            </td>
                            <td valign="center">
                                @if ($regis->timRef->timDetailRef[$i]->mahasiswaRef)
                                    {{$regis->timRef->timDetailRef[$i]->mahasiswaRef->kelas_kode}}
                                @endif
                            </td>
                            <td valign="center">
                                {{ucfirst($regis->timRef->timDetailRef[$i]->role)}}
                            </td>
                            <td valign="center">
                                {{$regis->timRef->timDetailRef[$i]->penggunaMhsRef->email}}
                            </td>
                            <td valign="center">
                                {{$regis->timRef->timDetailRef[$i]->penggunaMhsRef->phone}}
                            </td>
                        </tr>
                    @endif
                @endfor
            @endforeach
        </tbody>
    </table> 
@endif

