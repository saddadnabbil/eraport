<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEMBELAJARAN</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td colspan="9"><strong>Learning Data TK</strong></td>
            </tr>
            <tr>
                <td colspan="9">Waktu download : {{ $time_download }}</td>
            </tr>
            <tr>
                <td colspan="9">Didownload oleh : 
                    ({{ Auth::user()->username }})</td>
            </tr>
        </thead>
        <tbody>
            <!-- Pembelajaran  -->
            <tr>
            </tr>
            <tr>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>NO</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>TINGKATAN</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>TOPIC</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>GURU</strong>
                </td>
            </tr>
            <?php $no = 0; ?>
            @foreach ($data_pembelajaran as $pembelajaran)
                <?php $no++; ?>
                <tr>
                    <td align="center" style="border: 1px solid #000000;">{{ $no }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $pembelajaran->tingkatan->nama_tingkatan }}</td>
                    <td style="border: 1px solid #000000;">{{ $pembelajaran->topic->name }}</td>
                    <td style="border: 1px solid #000000;">
                        @if ($pembelajaran->guru)
                            {{ $pembelajaran->guru->karyawan->nama_lengkap }} {{ $pembelajaran->guru->gelar }}
                        @else
                            Guru not available
                        @endif
                    </td>
                </tr>
            @endforeach
            <!-- End Pembelajaran  -->
        </tbody>
    </table>
</body>

</html>
