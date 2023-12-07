<!-- resources/views/pdf/embedded_viewer.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/dist/img/favicon.png">
    <title>{{$title}} | {{ env('APP_NAME') }} </title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        iframe {
            width: 100%;
            height: 100vh;
            border: none; 
        }
    </style>
</head>
<body>
    <iframe src="{{ $pdfUrl }}" width="100%" height="100vh"></iframe>
</body>
</html>