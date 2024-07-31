<!DOCTYPE html>
<html>

<head>
    <title>Rekap Bulanan Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    @php
        // Array nama bulan dalam bahasa Indonesia
        $namaBulanArray = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
        // Mengambil nama bulan sesuai dengan indeks
        $namaBulan = $namaBulanArray[(int) $month - 1];
    @endphp

    <h2>Rekap Bulanan Keuangan</h2>
    <p>Bulan: {{ $namaBulan }} / Tahun: {{ $year }}</p>
    <table>
        <thead>
            <tr>
                <th>Tanggal Transaksi</th>
                <th>Omset</th>
                <th>Purchasing</th>
                <th>Tenaga Kerja</th>
                <th>PLN/Listrik</th>
                <th>Akomodasi</th>
                <th>Sewa Alat</th>
                <th>Profit</th>
            </tr>
        </thead>
        @php
            function formatRupiah($number)
            {
                return 'Rp ' . number_format($number, 0, ',', '.');
            }

            // Hitung total untuk setiap kolom
            $totalOmset = $dataKeuangan->sum('omset');
            $totalPurchasing = $dataKeuangan->sum('purchasing');
            $totalTenagaKerja = $dataKeuangan->sum('tenaga_kerja');
            $totalPLN = $dataKeuangan->sum('pln');
            $totalAkomodasi = $dataKeuangan->sum('akomodasi');
            $totalSewaAlat = $dataKeuangan->sum('sewa_alat');
            $totalProfit = $dataKeuangan->sum('profit');
        @endphp
        <tbody>
            @foreach ($dataKeuangan as $data)
                <tr>
                    <td>{{ $data->transaction_date }}</td>
                    <td>{{ formatRupiah($data->omset) }}</td>
                    <td>{{ formatRupiah($data->purchasing) }}</td>
                    <td>{{ formatRupiah($data->tenaga_kerja) }}</td>
                    <td>{{ formatRupiah($data->pln) }}</td>
                    <td>{{ formatRupiah($data->akomodasi) }}</td>
                    <td>{{ formatRupiah($data->sewa_alat) }}</td>
                    <td>{{ formatRupiah($data->profit) }}</td>
                </tr>
            @endforeach
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{ formatRupiah($totalOmset) }}</strong></td>
                <td><strong>{{ formatRupiah($totalPurchasing) }}</strong></td>
                <td><strong>{{ formatRupiah($totalTenagaKerja) }}</strong></td>
                <td><strong>{{ formatRupiah($totalPLN) }}</strong></td>
                <td><strong>{{ formatRupiah($totalAkomodasi) }}</strong></td>
                <td><strong>{{ formatRupiah($totalSewaAlat) }}</strong></td>
                <td><strong>{{ formatRupiah($totalProfit) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <h3>Ringkasan Omset dan Profit</h3>
    <table>
        <tr>
            <th>Total Omset</th>
            <td>{{ formatRupiah($totalOmset) }}</td>
        </tr>
        <tr>
            <th>Total Profit</th>
            <td>{{ formatRupiah($totalProfit) }}</td>
        </tr>
    </table>
</body>

</html>
