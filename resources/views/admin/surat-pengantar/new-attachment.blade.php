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

        .text-center {
            text-align: center;
        }

        .border-collapse {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
<img src="{{ public_path('assets/icons/kop.jpeg') }}" alt="kop" height="85" style="width: 100%">
<hr>
<div class="f12 text-center" style="margin-bottom: 10px;">
    Berdasarkan permohonan informasi pada tanggal {{ \Carbon\Carbon::parse($data->date)->formatLocalized('%d %B %Y') }} dengan nomor
    register {{ $data->ticket_id }} kami sampaikan kepada Saudara/i:
</div>
<table class="border-collapse" style="width: 100%; margin-bottom: 10px;">
    <tr>
        <td style="width: 25%; padding-left: 5px; min-height: 30px;" class="border-collapse f12" valign="top">Nama</td>
        <td style="width: 3%; min-height: 30px;" class="border-collapse text-center f12" valign="top">:</td>
        <td style="width: 72%; padding-left: 5px; min-height: 30px;" class="border-collapse f12">{{ $data->name }}</td>
    </tr>
    <tr>
        <td style="width: 25%; padding-left: 5px; min-height: 20px;" class="border-collapse f12" valign="top">Alamat</td>
        <td style="width: 3%; min-height: 20px;" class="border-collapse text-center f12" valign="top">:</td>
        <td style="width: 72%; padding-left: 5px; min-height: 20px;" class="border-collapse f12">{{ $data->address }}</td>
    </tr>
    <tr>
        <td style="width: 25%; padding-left: 5px; min-height: 20px;" class="border-collapse f12">No. Telp / Email</td>
        <td style="width: 3%; min-height: 20px;" class="border-collapse text-center f12">:</td>
        <td style="width: 72%; padding-left: 5px; min-height: 20px;" class="border-collapse f12">{{ $data->phone }} / {{ $data->email }}</td>
    </tr>
    <tr>
        <td colspan="3" style="padding-left: 5px; height: 25px;" class="border-collapse f12">Pemberitahuan sebagai berikut :</td>
    </tr>
</table>
<table class="border-collapse" style="width: 100%">
    <tr>
        <td style="padding-left: 5px; height: 25px;" class="border-collapse f12" colspan="4">A. Informasi Dapat diberikan</td>
    </tr>
    <tr style="">
        <td style="width: 5%; height: 35px;" class="border-collapse font-bold f12 text-center">No.</td>
        <td style="width: 25%; height: 35px;" class="border-collapse font-bold f12 text-center">Hal-hal terkait Informasi Publik</td>
        <td style="padding-left: 5px; height: 35px;" class="border-collapse f12 font-bold" colspan="2">Keterangan</td>
    </tr>
    <tr>
        <td style="width: 5%; height: 20px;" class="border-collapse f12 text-center">1</td>
        <td style="width: 25%; padding-left: 5px; height: 20px;" class="border-collapse f12">Penugasan Informasi Publik</td>
        <td style="padding-left: 5px; height: 20px;" class="border-collapse f12" colspan="2">( V )</td>
    </tr>
    <tr>
        <td style="width: 5%; height: 20px;" class="border-collapse f12 text-center">2</td>
        <td style="width: 25%; padding-left: 5px; height: 20px;" class="border-collapse f12">Format Informasi yang tersedia</td>
        <td style="padding-left: 5px; height: 20px;" class="border-collapse f12" colspan="2">Hardcopy</td>
    </tr>
    <tr>
        <td style="width: 5%; height: 20px;" class="border-collapse f12 text-center">3</td>
        <td style="width: 25%; padding-left: 5px; height: 20px;" class="border-collapse f12">Biaya yang dibutuhkan</td>
        <td style="padding-left: 5px; height: 20px; width: 20%" class="border-collapse f12">( X )</td>
        <td style="padding-left: 5px; height: 20px; width: 50%" class="border-collapse f12">Rp...........x.......(jumlah lembar) = Rp (Nihil)</td>
    </tr>
    <tr>
        <td style="width: 5%; height: 20px;" class="border-collapse f12 text-center">4</td>
        <td style="width: 25%; padding-left: 5px; height: 20px;" class="border-collapse f12">Waktu penyediaan</td>
        <td style="padding-left: 5px; height: 20px;" class="border-collapse f12" colspan="2">-</td>
    </tr>
    <tr>
        <td style="width: 5%; height: 20px;" class="border-collapse f12 text-center">5</td>
        <td style="width: 25%; padding-left: 5px; height: 20px;" class="border-collapse f12" colspan="3">Penjelasan penghitaman / pengaburan informasi yang diminta</td>
    </tr>
    <tr>
        <td style="padding-left: 5px; height: 25px;" class="border-collapse f12" colspan="4">B. Informasi tidak/belum dapat diberikan karena</td>
    </tr>
    <tr>
        <td style="width: 5%;" class="border-collapse f12 text-center"></td>
        <td style="width: 25%; padding-left: 5px; min-height: 20px;" class="border-collapse f12" colspan="3">
            <table style="width: 100%">
                <tr>
                    <td style="width: 5%">
                        <div style="height: 15px; width: 15px; border: 1px solid black"></div>
                    </td>
                    <td style="width: 9%">
                        <div>Informasi belum dikuasai</div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%">
                        <div style="height: 15px; width: 15px; border: 1px solid black"></div>
                    </td>
                    <td style="width: 95%">
                        <div>Informasi belum didokumentasikan</div>
                    </td>
                </tr>
                <tr>
                    <td style="height: 25px;" colspan="2">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        Penyediaan Informasi dilakukan dalam jangka waktu .........................
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="width: 5%; " class="border-collapse f12 text-center"></td>
        <td style="width: 25%; padding-left: 5px; " class="border-collapse f12"></td>
        <td style="padding-left: 5px; min-height: 20px;" class="border-collapse f12" colspan="2">
            <div class="text-center f12" style="margin-bottom: 10px; margin-top: 5px;">Sidoarjo, {{ \Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}</div>
            <div class="text-center f12">An. PPID Pelaksana Daerah BBPJN Jawa Timur - Bali</div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="text-center f12 font-bold" style="margin-bottom: 5px;">Ir. ACHMAD SUBKI, MT.</div>
        </td>
    </tr>
</table>
{{--<table style="width: 100%; margin-bottom: 0; border: 0">--}}
{{--    <tr>--}}
{{--        <td style="width: 50%" class="f12">--}}
{{--            <div class="mb-0" style="margin-bottom: 0; margin-top: 0; ">Nomor : {{ $data->ticket_id }}</div>--}}
{{--        </td>--}}
{{--        <td style="width: 50%" class="f12">--}}
{{--            <div style="text-align: right">Sidoarjo, {{ \Carbon\Carbon::now()->formatLocalized('%d %B %Y') }}</div>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--</table>--}}

{{--<div class="f12">Sifat : Biasa</div>--}}
{{--<div class="f12">Lampiran : 1 (satu) berkas</div>--}}
{{--<div class="f12">Hal : Penyampaian Jawaban Saran / Pengaduan</div>--}}
{{--<br>--}}
{{--<div class="f12">Yth. {{ $data->name }}</div>--}}
{{--<div class="f12">di {{ $data->address }}</div>--}}
{{--<br>--}}
{{--<div style="text-align:  justify; font-size: 12px; text-indent: 50px; line-height: 2;">Menindaklanjuti Nota Dinas--}}
{{--    dari {{ $data->name }} nomor {{ $data->ticket_id }}--}}
{{--    tanggal {{ \Carbon\Carbon::parse($data->date)->formatLocalized('%d %B %Y') }}, perihal saran / pengaduan--}}
{{--    atas {{ $data->complain }}, bersama ini kami sampaikan data dukung dan kronologis atas saran / pengaduan dimaksud--}}
{{--    (terlampir)--}}
{{--</div>--}}
{{--<br>--}}
{{--<div style="text-align: justify; text-indent: 50px;" class="f12">Demikian disampaikan atas perhatiannya kami ucapkan--}}
{{--    terima kasih.--}}
{{--</div>--}}
{{--<br>--}}
{{--<table style="width: 100%">--}}
{{--    <tr>--}}
{{--        <td style="width: 70%"></td>--}}
{{--        <td style="width: 30%">--}}
{{--            <div style="text-align: center" class="f12">--}}
{{--                Kepala Bagian Umum dan Tata Usaha--}}
{{--            </div>--}}
{{--            <div style="height: 50px;"></div>--}}
{{--            <div style="text-align: center; text-decoration: underline;" class="f12">Prabandityo Triwibowo, ST.,--}}
{{--                M.Eng.--}}
{{--            </div>--}}
{{--            <div style="text-align: center;" class="f12">NIP 19820428200912100</div>--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--</table>--}}
{{--<div class="f12">Tembusan</div>--}}
{{--<div class="f12">1. Direktur Jendral Bina Marga.</div>--}}
{{--<div class="f12">2. Sekertaris Direktorat Jendral Bina Marga.</div>--}}
{{--<div class="f12">3. Kepala Balai Besar Pelaksanaan Jalan Nasional Jawa Timur - Bali.</div>--}}
</body>
</html>
