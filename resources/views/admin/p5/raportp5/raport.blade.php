<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ $title }} | {{ $anggota_kelas->siswa->nama_lengkap }} ({{ $anggota_kelas->siswa->nis }})</title>
    <link rel="icon" type="image/png" href="./assets/dist/img/logo.png">
    <style>
        /* Reset CSS */
        body,
        h1,
        h2,
        h3,
        p,
        td {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Main styles */
        body {
            padding: 30px;
        }

        h1 {
            font-size: 11pt;
            font-weight: bold;
        }

        h3 {
            font-size: 8pt;
        }

        p {
            font-size: 6pt;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid black;
            padding: 2pt;
        }

        .center-align {
            text-align: center;
        }

        .left-align {
            text-align: left;
        }

        .right-align {
            text-align: right;
        }

        .no-indent {
            text-indent: 0;
        }

        .pad-179 {
            padding: 0 20pt;
        }

        .line-height-123 {
            line-height: 123%;
        }

        .watermarked {
            position: relative;
        }

        .watermarked:after {
            content: "";
            display: block;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0px;
            left: 0px;
            background-image: url("{{ public_path() . '/assets/dist/img/logo.png' }}");
            background-size: 40%;
            background-position: center center;
            background-repeat: no-repeat;
            opacity: 0.1;
        }

        @media print {
            td {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="raport watermarked">
        <table class="header-table">
            <!-- Header table content -->
            
        </table>
        <table class="information-container">
            <!-- Information container content -->
        </table>
        <table>
            <!-- Table content -->
        </table>
    </div>
</body>

</html>
