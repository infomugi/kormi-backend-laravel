        @page {
            margin: 26px 34px 46px 34px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 8.8pt;
            line-height: 1.4;
            color: #181916;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            vertical-align: top;
        }

        .accent-bar {
            height: 6px;
            background: #c6fa28;
            margin-bottom: 16px;
        }

        /* ---------- Kop dokumen ---------- */
        .kop {
            width: 100%;
        }

        .kop-left {
            width: 60%;
            padding-right: 14px;
        }

        .kop-right {
            width: 40%;
        }

        .logo {
            width: 44px;
            height: 45px;
        }

        .kop-org {
            font-size: 11.5pt;
            font-weight: bold;
            letter-spacing: 0.02em;
            color: #1d1e1b;
            line-height: 1.2;
        }

        .kop-org-sub {
            font-size: 7pt;
            color: #7f827c;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .kop-title {
            margin-top: 7px;
            font-size: 15pt;
            font-weight: bold;
            letter-spacing: -0.01em;
            color: #1d1e1b;
        }

        .kop-desc {
            font-size: 8pt;
            color: #7f827c;
        }

        .meta {
            background: #f5f6f4;
            border: 1px solid #e6e8e1;
            padding: 9px 11px;
            font-size: 7.6pt;
        }

        .meta td {
            padding: 2px 0;
        }

        .meta .label {
            color: #7f827c;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-size: 6.6pt;
            width: 46%;
            padding-right: 6px;
        }

        .meta .value {
            font-weight: bold;
            text-align: right;
            font-variant-numeric: tabular-nums;
        }

        .kop-rule {
            margin: 11px 0 12px;
            border-top: 2px solid #1d1e1b;
        }

        /* ---------- Seksi ---------- */
        .section {
            margin-bottom: 11px;
            page-break-inside: avoid;
        }

        .sec-head {
            margin-bottom: 7px;
        }

        .sec-num {
            display: inline-block;
            width: 16px;
            height: 16px;
            line-height: 16px;
            text-align: center;
            background: #1d1e1b;
            color: #c6fa28;
            font-size: 7.5pt;
            font-weight: bold;
            margin-right: 6px;
        }

        .sec-title {
            font-size: 9.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sec-note {
            color: #7f827c;
            font-size: 7.6pt;
            font-weight: normal;
            text-transform: none;
            letter-spacing: 0;
        }

        /* ---------- Tabel identitas ---------- */
        .kv {
            border: 1px solid #e6e8e1;
        }

        .kv th, .kv td {
            padding: 5px 8px;
            border-top: 1px solid #e6e8e1;
            font-size: 8.6pt;
        }

        .kv tr:first-child th,
        .kv tr:first-child td {
            border-top: none;
        }

        .kv th {
            width: 18%;
            background: #f5f6f4;
            text-align: left;
            font-size: 7.4pt;
            font-weight: normal;
            color: #7f827c;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .kv td {
            width: 32%;
            font-weight: bold;
        }

        .kv td.strong-full {
            font-weight: bold;
        }

        /* ---------- Metrik ringkasan ---------- */
        .metrics {
            border: 1px solid #e6e8e1;
            background: #f5f6f4;
        }

        .metrics td {
            width: 25%;
            padding: 7px 9px;
            border-left: 1px solid #e6e8e1;
        }

        .metrics td:first-child {
            border-left: none;
        }

        .metrics .metric-value {
            font-size: 12.5pt;
            font-weight: bold;
            letter-spacing: -0.01em;
            line-height: 1.2;
            font-variant-numeric: tabular-nums;
        }

        .metrics .metric-label {
            margin-top: 1px;
            font-size: 6.6pt;
            font-weight: bold;
            color: #7f827c;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .metrics .metric-sub {
            font-size: 7pt;
            color: #7f827c;
        }

        /* ---------- Tabel data ---------- */
        .tabel {
            border: 1px solid #e6e8e1;
            font-size: 8.6pt;
        }

        .tabel thead th {
            background: #1d1e1b;
            color: #ffffff;
            text-align: left;
            padding: 5px 8px;
            font-size: 7.2pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .tabel tbody td {
            padding: 5px 8px;
            border-top: 1px solid #e6e8e1;
            font-variant-numeric: tabular-nums;
        }

        .tabel tbody tr:nth-child(even) td {
            background: #fafbf8;
        }

        .tabel .angka {
            text-align: right;
            font-weight: bold;
        }

        .tabel tfoot td {
            padding: 7px 9px;
            border-top: 2px solid #1d1e1b;
            background: #eefcd0;
            font-weight: bold;
            font-size: 8.8pt;
        }

        .tabel tfoot .angka {
            text-align: right;
            font-size: 10pt;
        }

        /* ---------- Catatan status ---------- */
        .notice {
            padding: 8px 11px;
            border: 1px solid #f0dfa4;
            background: #fdf8e7;
            font-size: 8.6pt;
            page-break-inside: avoid;
        }

        .notice b {
            color: #6b5312;
        }

        .empty-value {
            color: #7f827c;
            font-weight: normal;
        }

        /* ---------- Foto bukti ---------- */
        .foto-wrap {
            padding: 9px;
            border: 1px solid #e6e8e1;
            background: #f5f6f4;
            display: inline-block;
        }

        .foto-wrap img {
            max-width: 250px;
            max-height: 190px;
        }

        .foto-caption {
            margin-top: 5px;
            font-size: 7.2pt;
            color: #7f827c;
        }

        /* ---------- Tanda tangan ---------- */
        .tutup {
            margin-top: 12px;
            page-break-inside: avoid;
        }

        .catatan {
            padding: 7px 10px;
            border-left: 3px solid #c6fa28;
            background: #fafbf8;
            font-size: 7.6pt;
            color: #55584f;
            margin-bottom: 10px;
        }

        .tanda {
            width: 100%;
        }

        .tanda td {
            width: 50%;
            font-size: 8.6pt;
        }

        .tanda .tanggal {
            font-size: 8.6pt;
        }

        .tanda .ruang {
            height: 38px;
        }

        .tanda .nama {
            font-weight: bold;
            text-decoration: underline;
        }

        .tanda .peran {
            font-size: 7.4pt;
            color: #7f827c;
        }

        /* ---------- Bar proporsi ---------- */
        .track {
            height: 6px;
            background: #e8eae4;
        }

        .track .fill {
            height: 6px;
            background: #1d1e1b;
        }

        .track .fill.is-lime {
            background: #c6fa28;
        }

        .tabel td .track {
            margin-top: 2px;
        }
