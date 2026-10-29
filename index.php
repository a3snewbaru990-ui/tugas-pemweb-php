<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan Individu - Pemrograman Web PHP</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
            background: #f8f9fa;
        }
        h1 {
            text-align: center;
            color: #1a237e;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background: #1a237e;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
        }
        tr:nth-child(even) {
            background: #f5f5f5;
        }
        tr.mengulang {
            background: #ffebee !important;
        }
        .status-lulus {
            color: #2e7d32;
            font-weight: 600;
        }
        .status-mengulang {
            color: #c62828;
            font-weight: 600;
        }
        .ringkasan {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .ringkasan h2 {
            color: #1a237e;
            margin-top: 0;
        }
        .ips {
            font-size: 28px;
            font-weight: 700;
            color: #1a237e;
        }
        .maks-sks {
            font-size: 18px;
            margin-top: 10px;
            color: #333;
        }
        .note {
            font-size: 13px;
            color: #666;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Latihan Individu - Kartu Hasil Studi</h1>

<?php
// ============================================================
// 1. Array multidimensi $matkul (minimal 5 mata kuliah)
// Keys: nama, sks, nilai (skala 0-100)
// ============================================================
$matkul = [
    ['nama' => 'Pemrograman Web', 'sks' => 3, 'nilai' => 88],
    ['nama' => 'Basis Data',      'sks' => 3, 'nilai' => 72],
    ['nama' => 'Jaringan Komputer','sks' => 2, 'nilai' => 65],
    ['nama' => 'Sistem Operasi',  'sks' => 3, 'nilai' => 55],
    ['nama' => 'Pemrograman Mobile','sks' => 4, 'nilai' => 40],
    ['nama' => 'Kecerdasan Buatan','sks' => 3, 'nilai' => 30],
];

// ============================================================
// 2. Fungsi helper hitungBobot($nilai)
// Mengembalikan array: huruf (A,B,C,D,E) dan bobot (4.0,3.0,2.0,1.0,0.0)
// ============================================================
function hitungBobot($nilai)
{
    if ($nilai >= 85) {
        return ['huruf' => 'A', 'bobot' => 4.0];
    } elseif ($nilai >= 70) {
        return ['huruf' => 'B', 'bobot' => 3.0];
    } elseif ($nilai >= 55) {
        return ['huruf' => 'C', 'bobot' => 2.0];
    } elseif ($nilai >= 40) {
        return ['huruf' => 'D', 'bobot' => 1.0];
    } else {
        return ['huruf' => 'E', 'bobot' => 0.0];
    }
}

// Hitung total SKS dan total bobot untuk IPS
$totalSKS   = 0;
$totalBobot = 0;

foreach ($matkul as &$mk) {
    $bobot   = hitungBobot($mk['nilai']);
    $mk['huruf']  = $bobot['huruf'];
    $mk['bobot']  = $bobot['bobot'];
    $mk['status'] = ($bobot['bobot'] >= 2.0) ? 'LULUS' : 'MENGULANG';

    $totalSKS   += $mk['sks'];
    $totalBobot += $bobot['bobot'] * $mk['sks'];
}
unset($mk);

$ips = ($totalSKS > 0) ? $totalBobot / $totalSKS : 0;

// Batas maksimal SKS berdasarkan IPS
$maksSKS = ($ips >= 3.00) ? 24 : 20;
?>

<table>
    <thead>
        <tr>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
            <th>Nilai Angka</th>
            <th>Nilai Huruf</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($matkul as $mk): ?>
            <tr class="<?= $mk['status'] === 'MENGULANG' ? 'mengulang' : '' ?>">
                <td><?= htmlspecialchars($mk['nama']) ?></td>
                <td><?= $mk['sks'] ?></td>
                <td><?= $mk['nilai'] ?></td>
                <td><?= $mk['huruf'] ?></td>
                <td class="<?= $mk['status'] === 'LULUS' ? 'status-lulus' : 'status-mengulang' ?>">
                    <?= $mk['status'] ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- 5. Batas maksimal SKS semester -->
<!-- 4. Ringkasan IPS di bawah tabel -->
<div class="ringkasan">
    <h2>Ringkasan IPS</h2>
    <p>Total SKS diambil: <strong><?= $totalSKS ?></strong> SKS</p>
    <p class="ips">IPS Anda: <?= number_format($ips, 2) ?></p>
    <p class="maks-sks">
        Berdasarkan IPS <?= number_format($ips, 2) ?>, batas maksimal SKS semester ini adalah:
        <strong><?= $maksSKS ?> SKS</strong>
        (<?= $ips >= 3.00 ? 'IPS >= 3.00 boleh ambil 24 SKS' : 'IPS < 3.00 maksimal 20 SKS' ?>).
    </p>
</div>

<p class="note">Output ditampilkan melalui localhost (XAMPP/Laragon). File: index.php</p>

</body>
</html>