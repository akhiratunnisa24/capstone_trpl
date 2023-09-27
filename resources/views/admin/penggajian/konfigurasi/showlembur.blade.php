<!-- Tampilan modal -->
<div class="modal fade" id="Showlembur{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="Showlembur"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Showlembur">JADWAL ABSENSI KARYAWAN</h4>
            </div>
            <div class="modal-body">
                {{-- <table>
                    <thead>
                        <tr>
                            @foreach ($jadwal as $j)
                                <th>{{ \Carbon\Carbon::parse($j->tanggal)->locale('id_ID')->isoFormat('D/M') }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($jadwal as $j)
                                @php
                                    $matched = false;
                                @endphp

                                @foreach ($absensi as $a)
                                    @if ($a['tanggal'] === $j->tanggal)
                                        @php
                                            $matched = true;
                                        @endphp
                                        <td>
                                            <div class="fa fa-check"></div>
                                        </td>
                                    @break;
                                @endif
                            @endforeach

                            @if (!$matched)
                                <td>absen</td>
                            @endif
                        @endforeach
                    </tr>
                </table> --}}
                @foreach ($jadwal as $j)
                    <div>{{ \Carbon\Carbon::parse($j->tanggal)->locale('id_ID')->isoFormat('D/M') }}</div>
                @endforeach
                @foreach ($jadwal as $j)
                    @php
                        $matched = false;
                    @endphp

                    @foreach ($absensi as $a)
                        @if ($a['tanggal'] === $j->tanggal)
                            @php
                                $matched = true;
                            @endphp
                            <div class="fa fa-check"></div>
                        @break;
                    @endif
                @endforeach

                @if (!$matched)
                    <div class="fa fa-times"></div>
                @endif
            @endforeach

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
</div>
