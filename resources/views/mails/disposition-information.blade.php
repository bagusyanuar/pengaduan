<html>
<head>
    <title>Disposisi Permintaan Infromasi</title>
</head>
<body>
<h3>No. Ticket {{ $data->ticket_id }}</h3>
@if($target === 'satker')
    <p>Kepada Satker</p>
    <a href="{{ route('information.data.satker.by.ticket', ['ticket' =>  str_replace('/', '-', $data->ticket_id)]) }}">Link</a>
@endif

@if($target === 'ppk')
    <p>Kepada PPK</p>
    <a href="{{ route('information.data.ppk.by.ticket', ['ticket' =>  str_replace('/', '-', $data->ticket_id)]) }}">Link</a>
@endif
</body>
</html>
