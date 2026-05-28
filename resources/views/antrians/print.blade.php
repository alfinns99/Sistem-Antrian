<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }

        body {
            width: 100%;
            margin: 0;
            padding: 4mm 4mm 1mm 4mm;
            /* Rapatkan bagian bawah (1mm) */
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
            color: #000;
            line-height: 1.2;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }

        .header {
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
            font-weight: bold;
            /* Tambah Bold */
        }

        .nomor {
            font-size: 55pt;
            font-weight: bold;
            margin: 5px 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .footer {
            border-top: 1px dashed #000;
            padding-top: 5px;
            margin-top: 5px;
            font-size: 11pt;
            /* Sedikit diperbesar */
            /* font-weight: bold; Tambah Bold */
        }

        .info {
            font-size: 10pt;
        }

        .note {
            font-size: 9pt;
            margin-top: 5px;
        }

        /* Hapus fst-italic */

        h1,
        h2,
        h3,
        h4,
        h5,
        p,
        span,
        strong {
            margin: 0;
            padding: 0;
            font-weight: bold;
        }

        .normal {
            font-weight: normal;
        }
    </style>
</head>

<body onload="window.print();">
    <div class="header">
        <div style="font-size: 18pt; margin-bottom: 2px;">{{ $settings['ticket_header'] ?? config('app.name') }}</div>
        @if(isset($settings['ticket_header_2']) && $settings['ticket_header_2'])
            <div style="font-size: 13pt;">{{ $settings['ticket_header_2'] }}</div>
        @else
            <div style="font-size: 13pt;">SISTEM ANTRIAN RESMI</div>
        @endif
    </div>

    <div class="info">NOMOR ANTRIAN:</div>
    <div class="nomor">{{ $antrian->nomor_antrian }}</div>

    <div style="font-size: 10pt; margin-top: 2px; font-weight: bold;">
        {{ date('d-m-Y', strtotime($antrian->tanggal)) }} | {{ $antrian->created_at->format('H:i:s') }}
    </div>

    <div class="footer">
        <div style="font-size: 12pt;">{{ $settings['ticket_footer'] ?? 'TERIMA KASIH' }}</div>
        @if(isset($settings['ticket_note']) && $settings['ticket_note'])
            <div class="note" style="margin-top: 5px;">{{ $settings['ticket_note'] }}</div>
        @endif
    </div>

    <script>
        window.onafterprint = function () {
            window.close();
        };
    </script>
</body>

</html>