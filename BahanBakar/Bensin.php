 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembelian Bahan Bakar</title>
    <style>
        /* CSS styles */
        body {
            text-align: center;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            color: white;
            background-image: url(https://st2.depositphotos.com/1279189/9322/i/450/depositphotos_93220076-stock-photo-gas-station-at-night.jpg);
            background-size: cover;
        }

        #main {
            width: 70%;
            margin: 50px auto;
            background-color: rgba(0, 0, 0, 0.7);
            text-align: center;
            border-radius: 10px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 12px;
        }

        select,
        input[type="number"] {
            width: calc(65% - 20px);
            padding: 12px;
            border: 1px solid #777;
            border-radius: 6px;
            box-sizing: border-box;
            background-color: #444;
            color: white;
        }

        button {
            width: 100px;
            padding: 15px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.1s;
            font-size: 15px;
        }

        button:hover {
            background-color: #45a049;
        }

        hr {
            border: none;
            border-top: 1px dashed #777;
            margin: 24px 0;
        }

        .bukti-transaksi {
            text-align: center;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            background-color: #808080;
            color: #333;
        }

        @media print {
            body {
                background-color: white;
                color: black;
            }

            #main {
                background-color: transparent;
                border: none;
                width: 100%;
                margin: 0;
                padding: 20px;
            }

            form {
                display: none;
            }

            .bukti-transaksi {
                border: 2px solid #ccc;
                border-radius: 10px;
                background-color: #f9f9f9;
                padding: 20px;
                color: #333;
                margin: 0 auto;
                max-width: 600px;
            }

            .print-button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div id="main">
        <h1 style="color: yellow;">Shell Bensin</h1>
        <form id="purchase-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="JBB">Jenis Bahan Bakar:</label>
            <select id="JBB" name="JBB">
                <option value="Shell Super">Shell Super</option>
                <option value="Shell V-Power">Shell V-Power</option>
                <option value="Shell V-Power Diesel">Shell V-Power Diesel</option>
                <option value="Shell V-Power Nitro">Shell V-Power Nitro</option>
            </select> <br> <br>

            <label for="Total">Jumlah Liter:</label>
            <input type="number" id="Total" name="Total" min="0" step="1" required>
            <br><br>

            <label for="MetodePembayaran">Metode Pembayaran:</label>
            <select id="MetodePembayaran" name="MetodePembayaran">
                <option value="Tunai">Tunai</option>
                <option value="Non Tunai">Non Tunai</option>
            </select>
            <br><br>
            <button type="submit">Beli</button>
        </form>
        <br>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            class Shell
            {
                protected $jenisBB;
                protected $price;
                protected $Total;
                protected $PPN;

                public function __construct($jenisBB, $price, $Total)
                {
                    $this->jenisBB = $jenisBB;
                    $this->price = $price;
                    $this->Total = $Total;
                    $this->vpn = 10;
                }

                public function getJenisBB()
                {
                    return $this->jenisBB;
                }

                public function getPrice()
                {
                    return $this->price;
                }

                public function getTotal()
                {
                    return $this->Total;
                }

                public function getPPN()
                {
                    return $this->PPN;
                }
            }

            class Beli extends Shell
            {

                public function __construct($jenisBB, $price, $Total)
                {
                    parent::__construct($jenisBB, $price, $Total);
                }

                public function hitungJumlah()
                {
                    $total = $this->price * $this->Total;
                    $total += $total * $this->PPN / 100;
                    return $total;
                }

                public function struk()
                {
                    $total = $this->hitungJumlah();
                    echo "<div class='bukti-transaksi'>";
                    echo "<h3>Bukti Transaksi:</h3>";
                    echo "<p>Anda Membeli Bahan Bakar Minyak Dengan Tipe : " . $this->jenisBB . "</p>";
                    echo "<p>Dengan Jumlah : " . $this->Total . " Liter</p>";
                    echo "<p>Metode Pembayaran: " . $_POST["MetodePembayaran"] . "</p>";
                    echo "<p>Total yang harus anda bayar: Rp " . number_format($total, 0, ',', '.') . "</p>";
                    echo "</div>";
                }
            }

            $hargaBahanBakar = [
                "Shell Super" => 15420.00,
                "Shell V-Power" => 16130.00,
                "Shell V-Power Diesel" => 18310.00,
                "Shell V-Power Nitro" => 16510.00,
            ];

            $jenisBB = $_POST["JBB"];
            $Total = $_POST["Total"];


            if (array_key_exists($jenisBB, $hargaBahanBakar)) {
                $Price = $hargaBahanBakar[$jenisBB];
                $beli = new Beli($jenisBB, $Price, $Total);
                $beli->struk();
                echo '<button class="print-button" onclick="printReceipt()">Cetak</button>';
            } else {
                echo "<h4 style='text-align: center;'>Jenis bahan bakar tidak valid.</h4>";
            }
        }

        ?>
    </div>

    <script>
        function printReceipt() {
            document.getElementById("purchase-form").style.display = "none";
            window.print();
            document.getElementById("purchase-form").style.display = "block";
        }
    </script>
</body>

</html>
