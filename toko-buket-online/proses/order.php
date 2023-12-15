<?php 
include '../koneksi/koneksi.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$kd_cs = $_POST['kode_cs'];
$nama = $_POST['nama'];
$prov = $_POST['prov'];
$kota = $_POST['kota'];
$alamat = $_POST['almt'];
$kopos = $_POST['kopos'];
$tanggal = date('Y-m-d');



$kode = mysqli_query($conn, "SELECT invoice from produksi order by invoice desc");
$data = mysqli_fetch_assoc($kode);
$num = substr($data['invoice'], 3, 4);
$add = (int) $num + 1;
if(strlen($add) == 1){
	$format = "INV000".$add;
}else if(strlen($add) == 2){
	$format = "INV00".$add;
}
else if(strlen($add) == 3){
	$format = "INV0".$add;
}else{
	$format = "INV".$add;
}
// Handle Receipt Image Upload
$receiptPath = NULL;
if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == 0) {
    $receiptFile = $_FILES['receipt'];
    $uploadDirectory = "../image/receipt/"; // Adjust this path as needed
    $filePath = $uploadDirectory . basename($receiptFile["name"]);

    // Validate file here (size, type, etc.)

    if (move_uploaded_file($receiptFile["tmp_name"], $filePath)) {
        $receiptPath = $filePath; // This path will be saved in the database
    } else {
        // Handle error - unable to move file
        // Consider logging this error
    }
} else {
    if (isset($_FILES['receipt'])) {
        // Handle error - file upload error
        // Consider logging this error
    }
}

$keranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kd_cs'");

while($row = mysqli_fetch_assoc($keranjang)){
	$kd_produk = $row['kode_produk'];
	$nama_produk = $row['nama_produk'];
	$qty = $row['qty'];
	$harga = $row['harga'];
	$status = "Pesanan Baru";

	$order = mysqli_query($conn, "INSERT INTO produksi (invoice, kode_customer, kode_produk, nama_produk, qty, harga, status, tanggal, provinsi, kota, alamat, kode_pos, terima, tolak, cek,receipt) VALUES ('$format', '$kd_cs', '$kd_produk', '$nama_produk', '$qty', '$harga', '$status', '$tanggal', '$prov', '$kota', '$alamat', '$kopos', '0', '0', '0', '$receiptPath')");





}
	$del_keranjang = mysqli_query($conn,"DELETE FROM keranjang WHERE kode_customer = '$kd_cs'");

	if($del_keranjang){
		header("location:../selesai.php");
	}



?>