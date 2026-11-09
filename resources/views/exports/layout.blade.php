<!DOCTYPE html>
<html>
<head>
    <title>Export PDF</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        .table-data th, .table-data td { border: 1px solid #e2e8f0; padding: 8px 10px; }
        .table-data th { background-color: #ecfdf5; color: #047857; font-weight: bold; text-transform: uppercase; font-size: 11px; }
        .table-data tr:nth-child(even) { background-color: #f8fafc; }
        .header-table { border-bottom: 3px solid #10b981; margin-bottom: 25px; padding-bottom: 15px; }
        .header-logo { width: 130px; height: auto; }
        .header-title { font-size: 22px; font-weight: 800; margin: 0; color: #065f46; letter-spacing: 0.5px; }
        .header-subtitle { font-size: 15px; font-weight: bold; margin: 5px 0; color: #047857; }
        .header-address { font-size: 10px; margin: 0; color: #64748b; line-height: 1.4; }
        .text-center { text-align: center; }
        .mb-10 { margin-bottom: 10px; }
        .mb-20 { margin-bottom: 20px; }
        .fw-bold { font-weight: bold; }
        /* .title-box { background-color: #059669; color: white; padding: 10px; border-radius: 4px; margin-bottom: 20px; display: inline-block; } */
        .info-table td { padding: 4px 0; border: none; }
        .info-label { color: #64748b; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
        .card { border: 1px solid #d1fae5; border-radius: 8px; padding: 15px; background: #fff; margin-bottom: 20px; }
        .card-header { font-size: 14px; font-weight: bold; color: #047857; border-bottom: 2px solid #34d399; padding-bottom: 8px; margin-bottom: 12px; }
        .highlight-row { background-color: #d1fae5 !important; }
        .highlight-text { color: #065f46; font-weight: bold; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ public_path('images/medical-logo.svg') }}" class="header-logo" alt="MindScans medical logo">
            </td>
            <td width="85%" class="text-center">
                <p class="header-title">MindScans</p>
                <p class="header-subtitle">Mental Health Screening</p>
                <p class="header-address">Jl. Tirto Agung, Pedalangan, Kec. Banyumanik, Kota Semarang, Jawa Tengah 50268</p>
            </td>
        </tr>
    </table>
    
    @yield('content')
</body>
</html>
