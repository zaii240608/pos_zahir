<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Mingguan</title>
    <style>
        body { font-family: Arial, sans-serif; color: #1e293b; margin: 32px; }
        header { display: flex; justify-content: space-between; align-items: start; border-bottom: 2px solid #0f766e; padding-bottom: 16px; margin-bottom: 20px; }
        h1 { margin: 0; font-size: 22px; } p { margin: 6px 0 0; color: #64748b; font-size: 13px; }
        button { border: 0; background: #0f766e; color: white; padding: 10px 16px; border-radius: 6px; cursor: pointer; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #cbd5e1; padding: 9px 10px; text-align: left; }
        th { background: #f0fdfa; color: #134e4e; } .right { text-align: right; }
        .summary { display: flex; gap: 28px; margin-bottom: 20px; font-size: 13px; }
        @media print { body { margin: 12px; } button { display: none; } }
    </style>
</head>
<body>
    @php
        $totalOmzet = $transaksis->sum('total_pembayaran');
        $totalProduk = $transaksis->sum(fn ($transaksi) => $transaksi->items->sum('kuantitas'));
    @endphp
    <header>
        <div>
            <h1>Laporan Penjualan Mingguan</h1>
            <p>Minggu ke-{{ $minggu }} / {{ $tahun }}: {{ $rentangTanggal }}</p>
        </div>
        <button type="button" onclick="window.print()">Cetak Laporan</button>
    </header>
    <div class="summary">
        <strong>{{ $transaksis->count() }} transaksi</strong>
        <strong>{{ $totalProduk }} produk terjual</strong>
        <strong>Omzet: Rp {{ number_format($totalOmzet, 0, ',', '.') }}</strong>
    </div>
    <table>
        <thead><tr><th>No.</th><th>Tanggal / Waktu</th><th>ID Transaksi</th><th>Metode</th><th class="right">Total</th></tr></thead>
        <tbody>
            @forelse($transaksis as $transaksi)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaksi->created_at->format('d-m-Y H:i') }}</td>
                    <td>#{{ $transaksi->id }}</td>
                    <td>{{ $transaksi->metode_pembayaran ?? 'CASH' }}</td>
                    <td class="right">Rp {{ number_format($transaksi->total_pembayaran ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Tidak ada transaksi pada periode ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
