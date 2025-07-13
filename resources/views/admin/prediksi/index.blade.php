@extends('layouts.default')
@section('content')
    <!-- Header -->
    <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
    <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Resign Prediction</h4>
                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Prediction</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="container" style="background: rgba(255 255 255 / 0.1); border-radius: 16px; padding: 40px 50px; max-width: 600px; width: 100%; box-shadow: 0 12px 30px rgb(0 0 0 / 0.25); backdrop-filter: blur(15px);">
        <h1 style="text-align: center; margin-bottom: 32px; font-weight: 700; font-size: 2.4rem; letter-spacing: 1px; color: #3329a8; text-shadow: 0 2px 5px rgba(0,0,0,0.25);">
            Deteksi Dini Resign Karyawan
        </h1>
        <form action="{{ route('deteksi.store')}}" method="POST" style="display: flex; flex-direction: column;">
            @csrf
            <label for="nama" style="margin-bottom: 15px; font-weight: 600; font-size: 1rem; color: #000003;">Nama Karyawan</label>
            <select name="karyawan_id" id="karyawan_id" class="form-control selectpicker" data-live-search="true" style="width: 100%; padding: 12px 16px; border-radius: 12px; border: none; margin-bottom: 24px; font-size: 1rem; background: rgba(255 255 255 / 0.15); color: rgb(15, 15, 111);">
                <option value="" disabled selected>-- Pilih salah satu --</option>
                <option value="0">Semua</option>
                @foreach($karyawan as $karyawan)
                    <option value="{{ $karyawan->id }}" {{ old('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                        {{ $karyawan->nama }}
                    </option>
                @endforeach
            </select>

            <label for="status_kerja" style="margin-bottom: 15px; margin-top:8px; font-weight: 600; font-size: 1rem; color: #000003;">Status Kerja</label>
            <select name="status_kerja" id="status_kerja" class="form-control selectpicker" data-live-search="true"
                style="width: 100%; padding: 12px 16px; border-radius: 12px; border: none; margin-bottom: 24px; font-size: 1rem; background: rgba(255 255 255 / 0.15); color: rgb(15, 15, 111);">
                <option value="" {{ old('status_kerja') == '' ? 'selected' : '' }}>-- Semua --</option>
                <option value="Aktif" {{ old('status_kerja') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Non-Aktif" {{ old('status_kerja') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
            </select>

            <label for="status_karyawan" style="margin-bottom: 8px; margin-top:8px; font-weight: 600; font-size: 1rem; color: #000003;">Status Karyawan</label>
            <select name="status_karyawan" id="status_karyawan" class="form-control selectpicker" data-live-search="true"
                style="width: 100%; padding: 12px 16px; border-radius: 12px; border: none; margin-bottom: 24px; font-size: 1rem; background: rgba(255 255 255 / 0.15); color: rgb(15, 15, 111);">
                <option value="" {{ old('status_karyawan') == '' ? 'selected' : '' }}>-- Semua --</option>
                <option value="Tetap" {{ old('status_karyawan') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="Kontrak" {{ old('status_karyawan') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                <option value="Percobaan" {{ old('status_karyawan') == 'Percobaan' ? 'selected' : '' }}>Percobaan</option>
            </select>
            <br>
            <br>
            <button type="submit"
                style="background: linear-gradient(135deg, #9f7aea, #667eea); color: white; padding: 16px 24px; font-size: 1.1rem; border: none; border-radius: 14px; cursor: pointer; font-weight: 600; width: 100%; box-shadow: 0 4px 15px rgb(159 122 234 / 0.6); transition: background 0.3s ease, transform 0.2s ease;">
                Proses Prediksi
            </button>
        </form>
    </div>
    <br>
    <br>
    @if(session('prediksi'))
        <div class="container" style="background: rgba(255 255 255 / 0.1); border-radius: 16px; padding: 40px 50px; max-width: 800x; width: 80%; box-shadow: 0 12px 30px rgb(0 0 0 / 0.25); backdrop-filter: blur(15px);">
            <h4 class="mb-4 text-center text-dark">Hasil Prediksi Resign</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Kerja</th>
                            <th>Resign?</th>
                            <th>Risk Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach(session('prediksi') as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item['nama'] }}</td>
                                <td>{{ $item['status_karyawan'] }}</td>
                                <td>{{ $item['status_kerja'] }}</td>
                                <td>
                                    <span class="badge {{ $item['prediksi_resign'] ? 'badge-danger' : 'badge-success' }}">
                                        {{ $item['prediksi_resign'] ? 'Resign' : 'Tidak' }}
                                    </span>
                                </td>
                                <td><strong>{{ $item['risk_score'] }}%</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="container" style="background: rgba(255 255 255 / 0.1); border-radius: 16px; padding: 40px 50px; max-width: 1200px; width: 100%; box-shadow: 0 12px 30px rgb(0 0 0 / 0.25); backdrop-filter: blur(15px);">
            <!-- Grafik Risiko -->
            <div class="row justify-content-end mb-5">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                    <label for="filterNama">Filter Nama Karyawan:</label>
                    <select id="filterNama" class="form-control selectpicker" data-live-search="true">
                        <option value="all">Semua</option>
                        @foreach(session('prediksi') as $item)
                            <option value="{{ $item['nama'] }}">{{ $item['nama'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <canvas id="riskLineChart" height="200" class="mt-5"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="stackChart" height="200" class="mt-5"></canvas>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const rawData = @json(session('prediksi'));
            const filterSelect = document.getElementById('filterNama');

            function filterCharts(selectedName) {
                const filtered = selectedName === 'all' ? rawData : rawData.filter(d => d.nama === selectedName);
                const labels = filtered.map(d => d.nama);
                const riskScores = filtered.map(d => d.risk_score);
                const sakit = filtered.map(d => d.total_hari_sakit);
                const izin = filtered.map(d => d.total_hari_izin);
                const cuti = filtered.map(d => d.jumlah_cuti);

                riskChart.data.labels = labels;
                riskChart.data.datasets[0].data = riskScores;
                riskChart.update();

                stackChart.data.labels = labels;
                stackChart.data.datasets[0].data = sakit;
                stackChart.data.datasets[1].data = izin;
                stackChart.data.datasets[2].data = cuti;
                stackChart.update();
            }

            const riskCtx = document.getElementById('riskLineChart').getContext('2d');
            const stackCtx = document.getElementById('stackChart').getContext('2d');

            const riskChart = new Chart(riskCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Risk Score %',
                        data: [],
                        fill: true,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true },
                        title: {
                            display: true,
                            text: 'Grafik Risiko Resign Karyawan (Area Chart)'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

            const stackChart = new Chart(stackCtx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [
                        { label: 'Hari Sakit', data: [], backgroundColor: 'rgba(54, 162, 235, 0.6)' },
                        { label: 'Hari Izin', data: [], backgroundColor: 'rgba(255, 206, 86, 0.6)' },
                        { label: 'Hari Cuti', data: [], backgroundColor: 'rgba(75, 192, 192, 0.6)' }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Jumlah Hari Sakit, Izin, dan Cuti'
                        }
                    },
                    scales: {
                        x: { stacked: true },
                        y: { beginAtZero: true, stacked: true }
                    }
                }
            });

            filterSelect.addEventListener('change', e => filterCharts(e.target.value));
            filterCharts('all');
        </script>
    @endif

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>

    @if (Session::has('success'))
        <script>
            swal("Selamat", "{{ Session::get('success') }}", 'success', {
                button: true,
                button: "OK",
            });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            swal("Mohon Maaf", "{{ Session::get('error') }}", 'error', {
                button: true,
                button: "OK",
            });
        </script>
    @endif
@endsection
