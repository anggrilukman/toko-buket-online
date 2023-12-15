<?php 
include 'header.php';
if(isset($_SESSION['user'])){
    $kode_customer = $_SESSION['kd_cs'];

    // Fetching purchase history from the produksi table
    $query = "SELECT * FROM produksi WHERE kode_customer = '$kode_customer' ORDER BY tanggal DESC";
    $result = mysqli_query($conn, $query);
}
?>

<div class="container" style="padding-bottom: 300px;">
    <h2 style=" width: 100%; border-bottom: 4px solid #ff8680"><b>Purchase History</b></h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(mysqli_num_rows($result) > 0){
                $no = 1;
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['invoice']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_produk']) . "</td>";
                    echo "<td>Rp." . number_format($row['harga']) . "</td>";
                    echo "<td>" . $row['qty'] . "</td>";
                    echo "<td>Rp." . number_format($row['harga'] * $row['qty']) . "</td>";
                    echo "<td>" . $row['tanggal'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No Purchase History</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


<?php 
include 'footer.php';
?>