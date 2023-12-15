<?php 
include 'header.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$kd = mysqli_real_escape_string($conn,$_GET['kode_cs']);
$cs = mysqli_query($conn, "SELECT * FROM customer WHERE kode_customer = '$kd'");
$rows = mysqli_fetch_assoc($cs);
?>

<div class="container" style="padding-bottom: 200px">
	<h2 style=" width: 100%; border-bottom: 4px solid #ff8680"><b>Checkout</b></h2>
	<div class="row">
		<div class="col-md-6">
			<h4>Daftar Pesanan</h4>
			<table class="table table-stripped">
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Harga</th>
					<th>Qty</th>
					<th>Sub Total</th>
				</tr>
				<?php 
				$result = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kd'");
				$no = 1;
				$hasil = 0;
				while($row = mysqli_fetch_assoc($result)){
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= $row['nama_produk']; ?></td>
						<td>Rp.<?= number_format($row['harga']); ?></td>
						<td><?= $row['qty']; ?></td>
						<td>Rp.<?= number_format($row['harga'] * $row['qty']);  ?></td>
					</tr>
					<?php 
					$total = $row['harga'] * $row['qty'];
					$hasil += $total;
					$no++;
				}
				?>
				<tr>
					<td colspan="5" style="text-align: right; font-weight: bold;">Grand Total = <?= number_format($hasil); ?></td>
				</tr>
			</table>
		</div>

	</div>
	<div class="row">
	<div class="col-md-6 bg-success">
		<h5>Pastikan Pesanan Anda Sudah Benar</h5>
	</div>
	</div>
	<br>
	<div class="row">
	<div class="col-md-6 bg-warning">
		<h5>isi Form dibawah ini </h5>
	</div>
	</div>
	<br>
	<form action="proses/order.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="kode_cs" value="<?= $kd; ?>">
		<div class="form-group">
			<label for="exampleInputEmail1">Nama</label>
			<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama" name="nama" style="width: 557px;" value="<?= $rows['nama']; ?>" readonly>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				<label for="provinceSelect">Provinsi</label>
    <select class="form-control" id="provinceSelect" name="prov">
        <!-- Options will be added here by JavaScript -->
    </select>
				</div>
			</div>

			<div class="col-md-6">
    <div class="form-group">
        <label for="exampleInputPassword1">Kota</label>
        <select class="form-control" id="exampleInputPassword1" name="kota">
            <?php
            $cities = [
                "Denpasar", "Bandung", "Batu", "Bekasi", "Blitar", "Bogor", "Cianjur", "Cilegon",
                "Cimahi", "Cirebon", "Depok", "Jakarta", "Madiun", "Magelang", "Malang", "Mojokerto",
                "Pasuruan", "Pekalongan", "Probolinggo", "Salatiga", "Semarang", "South Tangerang",
                "Sukabumi", "Surabaya", "Surakarta", "Tasikmalaya", "Tangerang", "Tegal", "Yogyakarta",
                "Kediri", "Serang", "Purwokerto", "Balikpapan", "Banjarbaru", "Banjarmasin", "Bontang",
                "Palangkaraya", "Pontianak", "Samarinda", "Singkawang", "Tarakan", "Tenggarong", "Ambon",
                "Tual", "Ternate", "Tidore", "Bima", "Mataram", "Kupang", "Jayapura", "Merauke", "Kota Sorong",
                "Manokwari", "Bau-Bau", "Bitung", "Gorontalo", "Kendari", "Makassar", "Manado", "Palu",
                "Pare-Pare", "Palopo", "Tomohon", "Banda Aceh", "Bandar Lampung", "Batam", "Bengkulu",
                "Blangkejeren", "Binjai", "Bireuen", "Bukittinggi", "Dumai", "Jambi", "Langsa", "Lhokseumawe",
                "Lubuklinggau", "Meulaboh", "Medan", "Metro", "Padang", "Padang Panjang", "Padang Sidempuan",
                "Pagar Alam", "Palembang", "Pangkal Pinang", "Pariaman", "Payakumbuh", "Pekanbaru",
                "Pematang Siantar", "Prabumulih", "Sigli", "Redelong (Simpang Tiga Redelong)", "Sabang",
                "Sawah Lunto", "Sibolga", "Singkil", "Solok", "Takengon", "Tapaktuan", "Tanjung Balai",
                "Tanjung Pinang", "Tebing Tinggi"
            ];

            foreach ($cities as $city) {
                echo "<option value=\"$city\">$city</option>";
            }
            ?>
        </select>
    </div>
</div>


		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputPassword1">Alamat</label>
					<input type="text" class="form-control" id="exampleInputPassword1" placeholder="Alamat" name="almt">
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputPassword1">Kode Pos</label>
					<input type="text" class="form-control" id="exampleInputPassword1" placeholder="Kode Pos" name="kopos">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="receiptImage">Upload Bukti transfer</label>
					<input type="file" class="form-control" id="receiptImage" name="receipt">
				</div>
			</div>
		</div>

		<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-shopping-cart"></i> Order Sekarang</button>
		<a href="keranjang.php" class="btn btn-danger">Cancel</a>
	</form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var provinces = [
        "Aceh", "Bali", "Banten", "Bengkulu", "Gorontalo", "Jakarta", "Jambi",
        "Jawa Barat", "Jawa Tengah", "Jawa Timur", "Kalimantan Barat",
        "Kalimantan Selatan", "Kalimantan Tengah", "Kalimantan Timur",
        "Kalimantan Utara", "Kepulauan Bangka Belitung", "Kepulauan Riau",
        "Lampung", "Maluku", "Maluku Utara", "Nusa Tenggara Barat",
        "Nusa Tenggara Timur", "Papua", "Papua Barat", "Riau", "Sulawesi Barat",
        "Sulawesi Selatan", "Sulawesi Tengah", "Sulawesi Tenggara",
        "Sulawesi Utara", "Sumatera Barat", "Sumatera Selatan", "Sumatera Utara",
        "Yogyakarta"
    ];

    var select = document.getElementById('provinceSelect');
    provinces.forEach(function(province) {
        var option = document.createElement('option');
        option.value = province;
        option.text = province;
        select.appendChild(option);
    });
});
</script>

<?php 
include 'footer.php';
?>