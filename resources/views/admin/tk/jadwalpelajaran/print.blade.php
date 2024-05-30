<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            padding: 0 20px
        }

        table,
        td,
        th {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        th {
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .p-1 {
            margin-top: 0px !important;
            padding: 0 !important;
            margin: 0px !important;
        }

        .mb-0 {
            margin-bottom: 5px !important;
            margin-top: 5px !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <table style=" border: none">
            <tr style="border: none">
                <td colspan="2" style="border: none">
                    <h3 style="text-align: center;"><strong>{{ strtoupper($kelas->nama_kelas) }} </strong></h3>
                </td>
            </tr>
        </table>

        <table class="border-dark table-auto" style="">
            <thead>
                <tr style="height: 10px">
                    <th style="background-color: #93acd457; color: #212529; padding: 0px; width: 120px">
                        <p class="text-center mb-0">TIME</p>
                    </th>
                    @foreach ($dataWeekdays as $weekdays)
                        <th scope="col" class="p-1 whitespace-nowrap"
                            style="background-color: #93acd457; color: #212529; padding: 0px;">
                            <p class="text-center mb-0">
                                {{ strtoupper($weekdays) }}
                            </p>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @if ($dataJadwalPelajaranSlot->isEmpty())
                    <tr>
                        <td colspan="{{ count($dataWeekdays) + 1 }}" class="text-center border p-1 ">
                            Data not available</td>
                    </tr>
                @else
                    @php
                        $skippedCells = [];
                    @endphp
                    @foreach ($dataJadwalPelajaranSlot as $index => $slot)
                        <tr style="height: 100%">
                            <td scope="col" rowspan="" class="p-1 border">
                                <p class="text-center text-dark mb-0">
                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($slot->stop_time)->format('H:i') }}
                                </p>
                            </td>
                            @if ($slot->keterangan == 1)
                                @foreach ($dataWeekdays as $day => $weekdays)
                                    @php
                                        $rowspan = 1;
                                    @endphp
                                    @for ($i = $index + 1; $i < count($dataJadwalPelajaranSlot); $i++)
                                        @if (isset($selected[$dataJadwalPelajaranSlot[$i]->id][$weekdays]))
                                            @if ($selected[$dataJadwalPelajaranSlot[$i]->id][$weekdays] != $selected[$slot->id][$weekdays])
                                            @break
                                        @endif
                                        @php
                                            $rowspan++;
                                            // Add the skipped cells to the list
                                            $skippedCells[] = [
                                                'slot_id' => $dataJadwalPelajaranSlot[$i]->id,
                                                'days' => $weekdays,
                                                'index' => $i,
                                            ];
                                        @endphp
                                    @endif
                                @endfor
                                @php
                                    $isPrimary =
                                        isset($selected[$slot->id][$weekdays]) &&
                                        $selected[$slot->id][$weekdays] &&
                                        !in_array(
                                            ['slot_id' => $slot->id, 'days' => $weekdays, 'index' => $index],
                                            $skippedCells,
                                        );
                                @endphp
                                @if (!in_array(['slot_id' => $slot->id, 'days' => $weekdays, 'index' => $index], $skippedCells))
                                    <td class="p-1 border"
                                        style="
                                    @foreach ($dataTopic as $topic)
                                        @if (isset($selected[$slot->id][$weekdays]) && $selected[$slot->id][$weekdays] == $topic->id)
                                            background-color: {{ $topic->color }};
                                            color: #212529;"
                                        @endif @endforeach
                                        
                                        rowspan="{{ $rowspan }}">
                                        @foreach ($dataTopic as $topic)
                                            @if (isset($selected[$slot->id][$weekdays]) && $selected[$slot->id][$weekdays] == $topic->id)
                                                <div class="text-center" style="padding: 7px">
                                                    {{ $topic->name }}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                @endif
                            @endforeach
                        @else
                            <td colspan="{{ count($dataWeekdays) }}" class="border text-center p-1 text-dark">
                                <strong>
                                    <i>
                                        @if ($slot->keterangan == 2)
                                            Dismissal
                                        @elseif ($slot->keterangan == 3)
                                            Healthy Meal Time
                                        @else
                                            Other
                                        @endif
                                    </i>
                                </strong>
                            </td>
                        @endif
                    </tr>
                @endforeach

            @endif
        </tbody>
    </table>

    <table style="width: 50%; margin: 140px auto 0px; text-align: center; border: none">
        <tr style="border: none">
            <td style="padding-right: 20px; border: none; text-align: right;">
                <img src="./assets/dist/img/merdeka-belajar.png" alt="Merdeka Belajar"
                    style="max-width: 100%; height: 100px;">
            </td>
            <td style="padding: 0 20px; border: none; text-align: cenet;">
                <img src="./assets/dist/img/timetable_tk.png" alt="timetable_tk"
                    style="max-width: 100%; height: 80px;">
            </td>
            <td style="padding-left: 20px; border: none; text-align: left;">
                <img src="./assets/dist/img/timetable_tk2.png" alt="timetable_tk2"
                    style="max-width: 100%; height: 80px;">
            </td>
        </tr>
    </table>
</div>

</body>

</html>
