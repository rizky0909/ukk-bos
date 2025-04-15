<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 30px;
        }

        .section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #eee;
            padding: 8px;
            text-align: left;
        }

        td {
            padding: 8px;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="section">
        <p class="bold">Indo April</p>
        <p>Member Status : Member</p>
        <p>No. HP :{{$transaction->point}}</ </p>
        <p>Bergabung Sejak : 14 April 2025</p>
        <p>Poin Member : {{$transaction->point}}</p>
    </div>

    <table border="0">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>QTy</th>
                <th>Harga</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($collection as $item)
                
            @endforeach --}}
            <tr>
                <td>Bibit Toge</td>
                <td>2</td>
                <td>Rp. 100.000</td>
                <td>Rp. 200.000</td>
            </tr>
        </tbody>
    </table>

    <div class="section" style="margin-top: 20px;">
        <table border="0">
            <tr>
                <td class="bold">Total Harga</td>
                <td class="right bold">Rp. 200.000</td>
            </tr>
            <tr>
                <td>Poin Digunakan</td>
                <td class="right">0</td>
            </tr>
            <tr>
                <td class="bold">Harga Setelah Poin</td>
                <td class="right bold">Rp. 0</td>
            </tr>
            <tr>
                <td class="bold">Total Kembalian</td>
                <td class="right bold">Rp. 22.222</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>2025-04-14T22:22:30.000000Z | Petugas</p>
        <p class="bold">Terima kasih atas pembelian Anda!</p>
    </div>

</body>
</html>
