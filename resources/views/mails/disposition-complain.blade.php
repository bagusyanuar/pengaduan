<html>
<head>
    <title>Disposisi Saran / Pengaduan</title>
</head>
<body>
<h3>No. Ticket {{ $data->ticket_id }}</h3>
@if($target === 'satker')
    <p>Kepada Satker</p>
    <a href="{{ route('complain.data.uki.by.ticket', ['ticket' =>  str_replace('/', '-', $data->ticket_id)]) }}">Link</a>
@endif

@if($target === 'ppk')
    <p>Kepada PPK</p>
    <a href="{{ route('complain.data.uki.by.ticket', ['ticket' =>  str_replace('/', '-', $data->ticket_id)]) }}">Link</a>
@endif
</body>
</html>
