<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 80%; margin: 20px auto;">
        <!-- Form untuk memilih filter -->
        <form id="filterForm" action="{{ route('report.pdf') }}" method="GET" style="margin-bottom: 20px;">
            <label for="filter">Pilih Filter:</label>
            <select name="filter" id="filter" onchange="document.getElementById('filterForm').submit();">
                <option value="Hari" {{ request('filter') == 'Hari' ? 'selected' : '' }}>Hari</option>
                <option value="Minggu" {{ request('filter') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                <option value="Bulan" {{ request('filter') == 'Bulan' ? 'selected' : '' }}>Bulan</option>
            </select>
        </form>
    </div>

    <div style="width: 80%; margin: 0 auto;">
        <img src="{{ $quickChartUrl }}" alt="Report Chart">

    </div>


    
</body>
</html>
