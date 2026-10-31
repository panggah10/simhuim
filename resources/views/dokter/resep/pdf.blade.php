<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resep Medis - RSP-{{ str_pad($resep->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #1e293b;
            font-size: 11pt;
            line-height: 1.4;
            margin: 0;
            padding: 15px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0f766e;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 16pt;
            color: #0f766e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header h2 {
            margin: 2px 0;
            font-size: 11pt;
            font-weight: normal;
            color: #334155;
        }
        .header p {
            margin: 0;
            font-size: 9pt;
            color: #64748b;
        }
        .badge-title {
            display: inline-block;
            background-color: #f0fdfa;
            border: 1px solid #14b8a6;
            color: #0f766e;
            font-weight: bold;
            padding: 4px 15px;
            border-radius: 4px;
            font-size: 11pt;
            text-transform: uppercase;
            margin-top: 8px;
        }
        .doctor-badge {
            background-color: #f1f5f9;
            color: #334155;
            padding: 3px 10px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 10pt;
            margin-top: 4px;
            display: inline-block;
        }
        .patient-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
            font-size: 10pt;
        }
        .patient-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .rx-container {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
            min-height: 180px;
            background-color: #fafafa;
        }
        .rx-symbol {
            font-family: 'Times New Roman', Times, serif;
            font-size: 24pt;
            font-weight: bold;
            font-style: italic;
            color: #0f766e;
            float: left;
            margin-right: 15px;
            margin-top: -5px;
        }
        .rx-content {
            margin-left: 40px;
            white-space: pre-line;
            font-size: 11pt;
            font-family: 'Courier New', Courier, monospace;
            color: #0f172a;
            line-height: 1.6;
        }
        .signature-section {
            width: 100%;
            margin-top: 25px;
        }
        .signature-box {
            float: right;
            text-align: center;
            width: 220px;
        }
        .clear {
            clear: both;
        }
        .footer-note {
            margin-top: 35px;
            border-top: 1px dashed #cbd5e1;
            padding-top: 8px;
            font-size: 8pt;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Hospital Header -->
    <div class="header">
        <h1>MINI HOSPITAL UIM YOGYAKARTA</h1>
        <h2>Sistem Informasi Pelayanan Kesehatan & Poliklinik</h2>
        <p>Jl. Kaliurang / Kampus UIM Yogyakarta | Telp: (0274) 123456 | Email: minihospital@uim.ac.id</p>
        <div class="badge-title">LEMBAR RESEP DOKTER</div>
        <br>
        <div class="doctor-badge">{{ $resep->dokter->nama_dokter }} (Poli {{ $resep->dokter->departemen }})</div>
    </div>

    <!-- Patient Details -->
    <table class="patient-table">
        <tr>
            <td width="22%"><strong>No. Resep</strong></td>
            <td width="3%">:</td>
            <td width="35%"><strong>RSP-{{ str_pad($resep->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
            <td width="18%"><strong>Tanggal</strong></td>
            <td width="3%">:</td>
            <td width="19%">{{ $resep->tanggal->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>Nama Pasien</strong></td>
            <td>:</td>
            <td>{{ $resep->pasien->nama_pasien }}</td>
            <td><strong>No. RM</strong></td>
            <td>:</td>
            <td>{{ $resep->pasien->no_rekam_medis ?? ('RM-' . $resep->pasien->id) }}</td>
        </tr>
        <tr>
            <td><strong>Usia / Gender</strong></td>
            <td>:</td>
            <td>{{ $resep->pasien->usia ? $resep->pasien->usia . ' Tahun' : '-' }} / {{ $resep->pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
            <td><strong>Alamat</strong></td>
            <td>:</td>
            <td>{{ Str::limit($resep->pasien->alamat, 28) }}</td>
        </tr>
    </table>

    <!-- Recipe Box (Rx) -->
    <div class="rx-container">
        <div class="rx-symbol">R/</div>
        <div class="rx-content">
<strong>{{ $resep->nama_resep }}</strong>

{{ $resep->rincian_resep }}
        </div>
        <div class="clear"></div>
    </div>

    <!-- Signature -->
    <div class="signature-section">
        <div class="signature-box">
            <div>Yogyakarta, {{ $resep->tanggal->translatedFormat('d F Y') }}</div>
            <div style="font-size: 9pt; color: #64748b; margin-top: 2px;">Dokter Pemeriksa,</div>
            <br><br><br><br>
            <div style="font-weight: bold; text-decoration: underline;">{{ $resep->dokter->nama_dokter }}</div>
            <div style="font-size: 8pt; color: #64748b;">SIP: {{ 1000 + $resep->dokter->id }}/UIM/DOK/{{ date('Y') }}</div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="footer-note">
        * Lembar resep ini sah dan diterbitkan secara resmi melalui SIMHUIM (Sistem Informasi Mini Hospital UIM Yogyakarta berbasis Laravel 13). Harap bawa resep ini ke bagian Farmasi/Apotek.
    </div>
</body>
</html>
