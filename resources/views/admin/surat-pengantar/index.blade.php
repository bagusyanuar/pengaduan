<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pengantar</title>
    <style>
        .mb-0 {
            margin-bottom: 0 !important;
        }

        .f12 {
            font-size: 12px;
        }
    </style>
</head>
<body>
<img src="{{ public_path('assets/icons/kop.jpeg') }}" alt="kop" height="85" style="width: 100%">
<hr>
<table style="width: 100%; margin-bottom: 0; border: 0">
    <tr>
        <td style="width: 50%" class="f12">
            <div class="mb-0" style="margin-bottom: 0; margin-top: 0; ">Nomor : {{ $data->ticket_id }}</div>
        </td>
        <td style="width: 50%" class="f12">
            <div style="text-align: right">Sidoarjo, {{ \Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}</div>
        </td>
    </tr>
</table>

<div class="mb-0" class="f12">Sifat : Biasa</div>
<div class="mb-0" class="f12">Lampiran : 1 (satu) berkas</div>
<div class="mb-0" class="f12">Hal : Penyampaian Jawaban Saran / Pengaduan</div>
<br>
<div class="f12">Yth. {{ $data->name }}</div>
<div class="f12">di {{ $data->address }}</div>
<br>
<div style="text-align:  justify; font-size: 12px; text-indent: 50px; line-height: 2;">Menindaklanjuti Nota Dinas dari {{ $data->name }} nomor {{ $data->ticket_id }}
    tanggal {{ \Carbon\Carbon::parse($data->date)->formatLocalized('%d %B %Y') }}, perihal saran / pengaduan
    atas {{ $data->complain }}, bersama ini kami sampaikan data dukung dan kronologis atas saran / pengaduan dimaksud
    (terlampir)
</div>
<br>
<div style="text-align: justify; text-indent: 50px;" class="f12">Demikian disampaikan atas perhatiannya kami ucapkan terima kasih.</div>
<br>
<table style="width: 100%">
    <tr>
        <td style="width: 70%"></td>
        <td style="width: 30%">
            <div style="text-align: center" class="f12">
                Kepala Bagian Umum dan Tata Usaha
            </div>
            <div style="height: 50px;"></div>
            <div style="text-align: center; text-decoration: underline;" class="f12">Prabandityo Triwibowo, ST., M.Eng.</div>
            <div style="text-align: center;" class="f12">NIP 19820428200912100</div>
        </td>
    </tr>
</table>
<div class="f12">Tembusan</div>
<div class="f12">1. Direktur Jendral Bina Marga.</div>
<div class="f12">2. Sekertaris Direktorat Jendral Bina Marga.</div>
<div class="f12">3. Kepala Balai Besar Pelaksanaan Jalan Nasional Jawa Timur - Bali.</div>
</body>
</html>
