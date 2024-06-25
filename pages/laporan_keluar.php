<?php
require 'config/koneksi.php';
include 'layouts/main.php';
include 'func/auto_complete.php';
$id_user = 1;
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Rekap Laporan Transaksi Barang Masuk</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">

            <!-- Collapsable Card Example for Table -->
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2">
                    <h6 class="m-0 font-weight-bold text-primary">Laporan tanggal : <?php echo date('D, d M Y') ?></h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseCardExample2">
                    <div class="card-body">

                        <!-- Data Tables -->
                        <div class="row row mt-4">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr class="after-add-more">
                                        <th>No</th>
                                        <th>Jenis Laporan</th>
                                        <th colspan="2">
                                            <center>Jangka Waktu</center>
                                        </th>
                                        <th>Lihat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form method="GET">
                                        <input type="text" class="form-control" id="username" value="<?php echo $username ?>" hidden readonly>
                                        <tr>
                                            <td>1</td>
                                            <td>Penjualan Barang Harian</td>
                                            <td><input type="date" class="form-control" id="tgl_mulai"></td>
                                            <td><input type="date" class="form-control" id="tgl_selesai"></td>
                                            <td>
                                                <center><a href="#" id="laporanHarian" onclick="getLaporanJualHarian()"><i class="fas fa-fw fa-eye fa-2x" aria-hidden="true"></i></a></center>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Penjualan Barang Bulanan</td>
                                            <td>
                                                <?php
                                                // tahun
                                                echo "<select class='form-control' id='thn_mulai'>";
                                                for ($i = 2024; $i < 2070; $i++) {
                                                    echo "<option>" . $i . "</option>";
                                                }
                                                echo "</select>";
                                                echo "<br>";

                                                // bulan
                                                $bulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember");
                                                echo "<select class='form-control' id='bln_mulai'>";
                                                foreach ($bulan as $key => $value) {
                                                    echo "<option value='" . $key . "'>" . $value . "</option>";
                                                }
                                                echo "</select>";
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                // tahun
                                                echo "<select class='form-control' id='thn_selesai'>";
                                                for ($i = 2024; $i < 2070; $i++) {
                                                    echo "<option>" . $i . "</option>";
                                                }
                                                echo "</select>";
                                                echo "<br>";

                                                // bulan
                                                $bulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember");
                                                echo "<select class='form-control' id='bln_selesai'>";
                                                foreach ($bulan as $key => $value) {
                                                    echo "<option value='" . $key . "'>" . $value . "</option>";
                                                }
                                                echo "</select>";
                                                ?>
                                            </td>
                                            <td>
                                                <center><a href="#" onclick="getLaporanJualBulanan()"><i class="fas fa-fw fa-eye fa-2x" aria-hidden="true"></i></a></center>
                                            </td>
                                        </tr>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                        <!--  -->

                        <!--  -->
                    </div>
                </div>
            </div>
            <!-- end collapsable -->
        </div>
    </div>
</div>

<!-- Copyright from here -->
</div>
<!-- End of Main Content -->
<?php
include 'layouts/jqueryModal.php';
include 'layouts/copyright.php'; ?>

</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<!-- SCRIPT FUNCTION -->
<script>
    function getLaporanJualHarian() {
        var username = $("#username").val();
        var tgl_mulai = $("#tgl_mulai").val();
        var tgl_selesai = $("#tgl_selesai").val();
        window.open('PDF/laporan_keluar_harian.php?tgl_mulai='+tgl_mulai+'&&tgl_selesai='+tgl_selesai+'&&username='+username);
    }

    function getLaporanJualBulanan() {
        var username = $("#username").val();
        var thn_mulai = $("#thn_mulai").val();
        var thn_selesai = $("#thn_selesai").val();
        var bln_mulai = $("#bln_mulai").val();
        var bln_selesai = $("#bln_selesai").val();
        window.open('PDF/laporan_keluar_bulanan.php?thn_mulai='+thn_mulai+'&&thn_selesai='+thn_selesai+'&&bln_mulai='+bln_mulai+'&&bln_selesai='+bln_selesai+'&&username='+username);
    }
</script>