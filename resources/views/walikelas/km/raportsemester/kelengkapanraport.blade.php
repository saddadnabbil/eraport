<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8" />
    <title></title>
    <link rel="icon" type="image/png" href="logo.png">
  </head>

  <style>
    /* main */
    body {
        padding: 40px;
    }

    * {
        margin: 0;
        padding: 0;
        text-indent: 0; 
    }

    h1, h2, h3, h4, h5 .title {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
    }

    h1 {
      font-family: Arial, sans-serif;
      font-size: 16pt;
    }

    h5 {
      font-family: Arial, sans-serif;
      font-size: 13pt;
    }

    p {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        text-decoration: none;
        font-size: 11pt;
        margin: 0;
    }

    table, tbody {
        vertical-align: top;
        overflow: visible;
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
      background-image: url("{{ public_path().'/assets/dist/img/logo-with-text.png' }}");
      background-size: 75%;
      background-position: center center;
      background-repeat: no-repeat;
      opacity: 0.1;
    }

    @media print {
        td {
            -webkit-print-color-adjust: exact; /* For Chrome */
            print-color-adjust: exact; /* For other browsers */
        }
    }
  </style>

  <body>
    <!-- Page 1 Cover -->
    <div class="cover">
        <table style="width: 100%; border-collapse: collapse;" class="watermarked">
            <!-- Header Table -->
            <table class="header-table" style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="text-align: left; vertical-align: middle;">
                        <img src="{{ public_path().'/assets/dist/img/tut-wuri-handayani.png' }}" alt="" width="80px" height="80px">
                    </td>
                    
                    <td style="text-align: center; vertical-align: middle;">
                        <h1>
                            GLOBAL INDONESIA SCHOOL <br>
                            <span style="font-weight: normal; font-size: 15pt; padding-top: 7px;">
                                DINAS PENDIDIKAN KABUPATEN SERANG 
                            </span>
                        </h1>
                    </td>
        
                    <td style="text-align: right; vertical-align: middle;">
                        <img src="./assets/dist/img/logo.png" alt="" width="80px" height="80px">
                    </td>
                </tr>
            </table>
        
            <!-- Body Table -->
            <table class="body-table" style="width: 100%; border-collapse: collapse; margin-top: 65pt;">
                <tr>
                    <td style="text-align: center; vertical-align: middle;">
                        <h1 style="font-size: 22pt; ">
                            STUDENT REPORT CARD <br>
                        </h1>
                    </td>
                </tr>
                <tr class="name">
                    <tr >
                        <td style="text-align: center; vertical-align: middle; padding-top: 65pt">
                            <h5 class="title" style="font-weight: noromal;"> 
                            Student Name
                            </h5>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; vertical-align: middle; padding-top: 10pt">
                            <p style="font-weight: noromal;">{{ strtoupper($anggota_kelas->siswa->nama_lengkap) }}</p>
                        </td>
                    </tr>
                </tr>
                <tr class="nis">
                    <tr >
                        <td style="text-align: center; vertical-align: middle; padding-top: 20pt">
                            <h5 class="title"  style="font-weight: normal;"> 
                            Student Identity Number
                            </h5>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; vertical-align: middle; padding-top: 4pt">
                            <p style="font-weight: 400; font-size: 9pt;"><i>( NIS )</i></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; vertical-align: middle; padding-top: 10pt">
                            <p style="font-weight: 400;">{{ $anggota_kelas->siswa->nis }}</p>
                        </td>
                    </tr>
                </tr>
                <tr class="nisn">
                    <tr >
                        <td style="text-align: center; vertical-align: middle; padding-top: 20pt">
                            <h5 class="title"  style="font-weight: normal;"> 
                            National Student Identity Number
                            </h5>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; vertical-align: middle; padding-top: 4pt">
                            <p style="font-weight: 400; font-size: 9pt;"><i>( NISN )</i></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; vertical-align: middle; padding-top: 10pt">
                            <p style="font-weight: 400;">{{ $anggota_kelas->siswa->nisn }}</p>
                        </td>
                    </tr>
                </tr>
                <tr class="identity">
                    <tr >
                        <td style="text-align: center; vertical-align: middle; padding-top: 20pt">
                            <h3  class="title" style="font-weight: normal;"> 
                              National School Identity Number
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; vertical-align: middle; padding-top: 4pt">
                            <p style="font-weight: 400; font-size: 9pt;"><i>( NPSN )</i></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; vertical-align: middle; padding-top: 10pt">
                            <p style="font-weight: 400;">{{ $sekolah->npsn }}</p>
                        </td>
                    </tr>
                </tr>
            </table>
        
            <!-- Footer Table -->
            <table class="footer-table" style="border-collapse: collapse; margin-top: 40pt; position: fixed; bottom: 25%; left: 0%;">
                <tr >
                    <td style="text-align: center; vertical-align: middle; padding-top: 20pt">
                        <h5 style="font-weight: normal;"> 
                            Address
                        </h5>
                    </td>
                </tr>
                <tr >
                    <td style="text-align: center; vertical-align: middle; padding-top: 4pt">
                        <p style="font-weight: 400; line-height: 1.3; padding: 0 200px"> 
                          {{ $sekolah->alamat }}
                        </p>
                    </td>
                </tr>
            </table>
        </table>  
    </div>
    <div class="page-break"></div>

  </body>
</html>