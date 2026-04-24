<h2 style="text-align:center;">LAPORAN KANDANG AYAM</h2>

<p>Total Ayam Masuk: {{ $totalMasuk }}</p>
<p>Total Ayam Keluar: {{ $totalKeluar }}</p>
<p>Rata-rata Suhu: {{ $avgSuhu }} °C</p>

<hr>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>Tanggal</th>
        <th>Suhu</th>
        <th>Masuk</th>
        <th>Keluar</th>
    </tr>

    @foreach($data as $d)
    <tr>
        <td>{{ $d->created_at }}</td>
        <td>{{ $d->temperature }}</td>
        <td>{{ $d->chicken_in }}</td>
        <td>{{ $d->chicken_out }}</td>
    </tr>
    @endforeach
</table>