<?php
require 'config/koneksi.php';
$select         = mysqli_query($conn, "SELECT * FROM toko ");
$id             = mysqli_fetch_assoc($select);
// 
$no_trans_jual = $_GET['no_trans_jual'];
$selectJual = mysqli_query($conn, "SELECT * FROM pengeluaran LEFT JOIN databarang ON pengeluaran.kode_barang=databarang.kode_barang LEFT JOIN faktur_jual ON pengeluaran.no_trans_jual=faktur_jual.no_trans_jual LEFT JOIN tb_user ON pengeluaran.id_user=tb_user.id_user WHERE pengeluaran.no_trans_jual='$no_trans_jual' GROUP BY pengeluaran.id_keluar");
$data       = mysqli_fetch_assoc($selectJual);
$admin      = $data['username'];
// ganti ke indonesia
date_default_timezone_set("Asia/Jakarta");
$today = date('d-m-Y H:i:s');
?>
<html>

<head>
    <title>Faktur Pembayaran</title>
    <style>
        #tabel {
            font-size: 15px;
            border-collapse: collapse;
        }

        #tabel td {
            padding-left: 5px;
            border: 1px solid black;
        }
    </style>
</head>
<!-- auto print saat loading halaman -->
<script>
function printdata(){
    var divContents = document.getElementById("printArea").innerHTML; 
    var a = window.open('', '', 'height=1000, width=1000'); 
    a.document.write('<html><title>Faktur Pembayaran</title>'); 
    a.document.write('<body><br>'); 
    a.document.write(divContents); 
    a.document.write('</body></html>'); 
    a.document.close(); 
    a.print(); 
}
</script>

<body style='font-family:tahoma; font-size:8pt;' onload="printdata()">
<div id="printArea">
    <center>
        <table style='width:350px; font-size:16pt; font-family:calibri; border-collapse: collapse;' border='0'>
            <td width='70%' align='CENTER' vertical-align:top'><span style='color:black;'>
                    <b><?php echo $id['nama_toko'] ?></b>
                <br><span style='font-size:12pt'><?php echo $id['alamat_toko'] ?></span></br>
                <span style='font-size:12pt'>No Telp : <?php echo $id['no_telp'] ?></span></br>
            </td>
        </table>
        
        <br>
        <table cellspacing='0' cellpadding='0' style='width:350px; font-size:12pt; font-family:calibri;  border-collapse: collapse;' border='0'>
            <tr>
                <td>No Faktur : <?php echo $no_trans_jual ?></td>
            </tr>
            <tr>
                <td>Admin   : <?php echo $admin ?></td>
            </tr>
            <tr>
                <td><?php echo $today; ?></td>
            </tr>
        </table>

        <style>
            hr {
                display: block;
                margin-top: 0.5em;
                margin-bottom: 0.5em;
                margin-left: auto;
                margin-right: auto;
                border-style: inset;
                border-width: 1px;
            }
        </style>
        <br>
        =============================================
        <table cellspacing='0' cellpadding='0' style='width:350px; font-size:12pt; font-family:calibri;  border-collapse: collapse;' border='0'>

            <tr align='center'>
                <td width='10%'>Item</td>
                <td width='13%'>Harga</td>
                <td width='4%'>Qty</td>
                <td width='10%'>Diskon (Rp)</td>
                <td width='13%'>Total</td>
            <tr>
                <td colspan='5'>
                    <hr>
                </td>
            </tr>
            </tr>
            <?php 
            $selectData = mysqli_query($conn, "SELECT * FROM pengeluaran LEFT JOIN databarang ON pengeluaran.kode_barang=databarang.kode_barang LEFT JOIN faktur_jual ON pengeluaran.no_trans_jual=faktur_jual.no_trans_jual LEFT JOIN tb_user ON pengeluaran.id_user=tb_user.id_user WHERE pengeluaran.no_trans_jual='$no_trans_jual' GROUP BY pengeluaran.id_keluar");
            while($row = mysqli_fetch_array($selectData)){
                ?>  
                <tr>
                    <td style='vertical-align:top'><?php echo $row['nama_barang'] ?></td>
                    <td style='vertical-align:top; text-align:right; padding-right:10px'><?php echo number_format($row['harga_jual'],1) ?></td>
                    <td style='vertical-align:top; text-align:right; padding-right:10px'><?php echo $row['qty_keluar'] ?></td>
                    <td style='vertical-align:top; text-align:right; padding-right:10px'><?php echo number_format($row['diskon'],1) ?></td>
                    <td style='text-align:right; vertical-align:top'><?php echo number_format($row['harga_jual']*$row['qty_keluar'],1) ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan='5'>
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan='4'>
                    <div style='text-align:right; color:black'>Total : </div>
                </td>
                <td style='text-align:right; font-size:16pt; color:black'><?php echo number_format($data['total_harga_jual'],1) ?></td>
            </tr>
            <tr>
                <td colspan='4'>
                    <div style='text-align:right; color:black'>Bayar : </div>
                </td>
                <td style='text-align:right; font-size:16pt; color:black'><?php echo number_format($data['uang_bayar'],1) ?></td>
            </tr>
            <tr>
                <td colspan='5'>
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan='4'>
                    <div style='text-align:right; color:black'>Kembali : </div>
                </td>
                <td style='text-align:right; font-size:16pt; color:black'><?php echo number_format($data['uang_bayar']-$data['total_harga_jual'],1) ?></td>
            </tr>
        </table>
        <table style='width:350; font-size:12pt;' cellspacing='2'>
            <tr></br>
                <td align='center'>****** TERIMAKASIH ******</br></td>
            </tr>
        </table>
        <br>
        <table style='width:350; font-size:10pt;' cellspacing='2'>
            <tr>
                <td align='center'>*Barang yang sudah dibeli tidak dapat dikembalikan, kecuali ada perjanjian</br></td>
            </tr>
        </table>
    </center>
</div>
</body>

</html>