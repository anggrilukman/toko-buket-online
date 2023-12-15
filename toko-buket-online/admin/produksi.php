<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'header.php';
$sortage = mysqli_query($conn, "SELECT * FROM produksi WHERE cek = '1'");
if (!$sortage) {
    echo "Error: " . mysqli_error($conn);
    exit;
}
$cek_sor = mysqli_num_rows($sortage);
$nama_material = []; // Initialize the array
?>

<div class="container">
    <h2 style=" width: 100%; border-bottom: 4px solid gray"><b>Daftar Pesanan</b></h2>
    <br>
    <h5 class="bg-success" style="padding: 7px; width: 710px; font-weight: bold;"><marquee>Lakukan Reload Setiap Masuk Halaman ini, untuk menghindari terjadinya kesalahan data dan informasi</marquee></h5>
    <a href="produksi.php" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i> Reload</a>
    <br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Invoice</th>
                <th scope="col">Kode Customer</th>
                <th scope="col">Status</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Receipt</th> <!-- Added column for receipt -->
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $result = mysqli_query($conn, "SELECT invoice, kode_customer, status, kode_produk, qty, terima, tolak, cek, tanggal, receipt FROM produksi GROUP BY invoice, kode_customer, status, kode_produk, qty, terima, tolak, cek, tanggal, receipt");

            if (!$result) {
                echo "Error: " . mysqli_error($conn);
                exit;
            }
            $no = 1;
            while($row = mysqli_fetch_assoc($result)) {
                $kodep = $row['kode_produk'];
                $inv = $row['invoice'];
                ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= htmlspecialchars($row['invoice']); ?></td>
                    <td><?= htmlspecialchars($row['kode_customer']); ?></td>
                    <td>
                        <?php 
                        if($row['terima'] == 1) {
                            echo '<span style="color: green;font-weight: bold;">Pesanan Diterima (Siap Kirim)</span>';
                        } elseif($row['tolak'] == 1) {
                            echo '<span style="color: red;font-weight: bold;">Pesanan Ditolak</span>';
                        } else {
                            echo '<span style="color: orange;font-weight: bold;">' . htmlspecialchars($row['status']) . '</span>';
                        }
                        ?>
                    </td>
                    <td><?= htmlspecialchars($row['tanggal']); ?></td>
					<td>
    <?php if (!empty($row['receipt'])): ?>
        <a href="#" data-toggle="modal" data-target="#receiptModal" data-receipt="<?= htmlspecialchars($row['receipt']); ?>">Lihat Bukti Transfer</a>
    <?php else: ?>
        No Receipt
    <?php endif; ?>
</td>

			<td>
							<?php if( $row['tolak']==0 && $row['cek']==1 && $row['terima']==0){ ?>
								<a href="inventory.php?cek=0" id="rq" class="btn btn-warning"><i class="glyphicon glyphicon-warning-sign"></i> Request Material Shortage</a> 
								<a href="proses/tolak.php?inv=<?= $row['invoice']; ?>" class="btn btn-danger" onclick="return confirm('Yakin Ingin Menolak ?')"><i class="glyphicon glyphicon-remove-sign"></i> Tolak</a> 
							<?php }else if($row['terima'] == 0 && $row['cek']==0){ ?>

								<a href="proses/terima.php?inv=<?= $row['invoice']; ?>&kdp=<?= $row['kode_produk']; ?>" class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Terima</a> 
								<a href="proses/tolak.php?inv=<?= $row['invoice']; ?>" class="btn btn-danger" onclick="return confirm('Yakin Ingin Menolak ?')"><i class="glyphicon glyphicon-remove-sign"></i> Tolak</a> 
							<?php } ?>

							<a href="detailorder.php?inv=<?= $row['invoice']; ?>&cs=<?= $row['kode_customer']; ?>" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-eye-open"></i> Detail Pesanan</a>
						</td>
        </tr>
        <?php
        $no++; 
    }
    ?>

			</tbody>
		</table>

		<?php 
if($cek_sor > 0){
 ?>
	<br>
	<br>
	<div class="row">
		<div class="col-md-4 bg-danger" style="padding:10px;">
			<h4>Kekurangan Material </h4>
			<h5 style="color: red;font-weight: bold;">Silahkan Tambah Stok Material dibawah ini : </h5>
			<table class="table table-striped">
				<tr>
					<th>No</th>
					<th>Material</th>
				</tr>
	<?php 
	$arr = array_values(array_unique($nama_material));
	for ($i=0; $i < count($arr); $i++) { 

	 ?>
				<tr>
					<td><?= $i+1 ?></td>
					<td><?= $arr[$i]; ?></td>
				</tr>
	<?php } ?>
			</table>
		</div>
	</div>
<?php 
}
 ?>
 <!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog moadal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receiptModalLabel">Bukti Transfer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
			<img src="" id="receiptImage" alt="Receipt" style="width: 100%; height: auto;">

            </div>
        </div>
    </div>
</div>


	</div>

	



	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#receiptModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var receiptSrc = button.data('receipt'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('#receiptImage').attr('src', receiptSrc);
    });
});
</script>


	<?php 
	include 'footer.php';
	?>