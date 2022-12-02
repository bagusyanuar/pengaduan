<html>
<head>
    <title>Jawaban Permintaan Informasi</title>
</head>
<body>
<h3>No. Ticket : {{ $data->ticket_id }}</h3>
Berikut Link Jawaban Permintaan Informasi
<a href="{{ route('information.answers.uki.by.ticket', ['ticket' =>  str_replace('/', '-', $data->ticket_id)]) }}">Link</a>
</body>
</html>
