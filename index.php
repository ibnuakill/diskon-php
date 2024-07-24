<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Diskon</title>
    <link rel="stylesheet" href="src/style.css">
</head>

<body>
    <div class="wrapper">
        <?php include 'header.php'; ?>


        <div class="container">
            <div class="title">Perhitungan Diskon</div>
            <form method="post" action="">
                <div class="form-group">
                    <label for="total_belanja">Total Belanja Rp. </label>
                    <input type="text" id="total_belanja" name="total_belanja" placeholder="Masukan Total Belanja..." required>
                </div>
                <button type="submit">Hitung Diskon</button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                include 'koneksi.php';

                // Fungsi untuk menghitung diskon berdasarkan total belanja
                function hitungDiskon($totalBelanja)
                {
                    if ($totalBelanja >= 100000) {
                        return array(0.1 * $totalBelanja, 10); // Diskon 10%
                    } elseif ($totalBelanja >= 50000) {
                        return array(0.05 * $totalBelanja, 5); // Diskon 5%
                    } else {
                        return array(0, 0); // Tidak ada diskon
                    }
                }

                // Fungsi untuk memformat angka menjadi format Rupiah tanpa desimal
                function formatRupiah($angka)
                {
                    return "Rp. " . number_format($angka, 0, ',', '.');
                }

                // Mengambil nilai total belanja dari input form
                $totalBelanja = str_replace('.', '', $_POST['total_belanja']);
                $totalBelanja = str_replace(',', '.', $totalBelanja);
                $totalBelanja = (float)$totalBelanja;

                if ($totalBelanja < 0) {
                    echo "<div class='result'>Total belanja tidak boleh negatif.</div>";
                } else {
                    list($diskon, $persentaseDiskon) = hitungDiskon($totalBelanja);
                    $totalBayar = $totalBelanja - $diskon;

                    // Menyimpan data ke database
                    $stmt = $conn->prepare("INSERT INTO transaksi (total_belanja, diskon, total_bayar) VALUES (?, ?, ?)");
                    $stmt->bind_param("ddd", $totalBelanja, $diskon, $totalBayar);
                    $stmt->execute();
                    $stmt->close();

                    echo "<div class='result'>Total belanja: <span class='highlight'>" . formatRupiah($totalBelanja) . "</span></div>";
                    echo "<div class='result'>Diskon: <span class='highlight'>" . formatRupiah($diskon) . " (" . $persentaseDiskon . "%)</span></div>";
                    echo "<div class='result'>Total bayar: <span class='highlight'>" . formatRupiah($totalBayar) . "</span></div>";
                }
            }

            ?>
        </div>
        <?php include 'footer.php'; ?>

    </div>
    <script src="src/script.js"></script>
</body>

</html>