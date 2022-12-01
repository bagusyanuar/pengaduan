<html>
<head>
    <title>Jawaban Saran / Pengaduan</title>
</head>
<body>
<h3>No. Ticket : {{ $data->ticket_id }}</h3>
Berikut Link Jawaban Saran Pengaduan
<a href="{{ route('complain.answers.uki.by.ticket', ['ticket' =>  str_replace('/', '-', $data->ticket_id)]) }}">Link</a>
</body>
</html>
