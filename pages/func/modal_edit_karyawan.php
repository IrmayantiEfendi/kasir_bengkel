<?php
require '../config/koneksi.php';
session_start();
$id_user = $_SESSION['id_user'];
// 
$page_no   = $_GET['page_no'];
$kolom_cari= $_GET['kolom_cari'];
$select         = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user='$id_user' ");
$id             = mysqli_fetch_assoc($select);
?>
<!-- modal edit -->
<div class="modal-header">
    <h3 class="modal-title">Edit Akun Karyawan</h3>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <form method="POST" action="action/edit_user.php">
                            <div class="form-group row">
                                <!-- page no dan kolom cari -->
                                <input type="text" class="form-control" name="page_no" value="<?php echo $page_no ?>" readonly hidden>
                                <input type="text" class="form-control" name="kolom_cari" value="<?php echo $kolom_cari ?>" readonly hidden>
                                <input type="text" class="form-control" name="id_user" value="<?php echo $id_user ?>" readonly hidden>

                                <div class="col-sm-12 mb-12 mb-sm-0">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="User Name" value="<?php echo $id['username'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-12 mb-sm-0">
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="No HP (Whatsapp)" value="<?php echo $id['no_hp'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-12 mb-sm-0">
                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat"><?php echo $id['alamat'] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-12 mb-sm-0">
                                    <p>Tanggal Mulai Kerja</p>
                                    <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" value="<?php echo $id['tgl_mulai'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-12 mb-sm-0">
                                    <select class="form-control" id="hari_libur" name="hari_libur">
                                        <!-- select data yg terpilih -->
                                        <?php
                                        $selectOption = mysqli_query($conn, "SELECT hari_libur FROM tb_user WHERE id_user='$id_user' ");
                                        $data         = mysqli_fetch_assoc($selectOption);
                                        $harilibur    = $data['hari_libur'];
                                        ?>
                                        <option value="0">===Pilih Hari Libur===</option>
                                        <option <?php if($harilibur === 'Senin'){ echo "selected='selected'"; }?>>Senin</option>
                                        <option <?php if($harilibur === 'Selasa'){ echo "selected='selected'"; }?>>Selasa</option>
                                        <option <?php if($harilibur === 'Rabu'){ echo "selected='selected'"; }?>>Rabu</option>
                                        <option <?php if($harilibur === 'Kamis'){ echo "selected='selected'"; }?>>Kamis</option>
                                        <option <?php if($harilibur === 'Jumat'){ echo "selected='selected'"; }?>>Jumat</option>
                                        <option <?php if($harilibur === 'Sabtu'){ echo "selected='selected'"; }?>>Sabtu</option>
                                        <option <?php if($harilibur === 'Minggu'){ echo "selected='selected'"; }?>>Minggu</option>
                                    </select>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-info btn-user btn-block" name="update" value="Update">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery for showHide -->
<script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>       
<script>
    const password = document.getElementById('oldPassword'); // id dari input password
    const showHide = document.getElementById('showHide1'); // id span showHide dalam input group password

    password.type = 'password'; // set type input password menjadi password
    showHide.innerHTML = '<i class="fas fa-fw fa-eye"></i>'; // masukan icon eye dalam icon bootstrap 5
    showHide.style.cursor = 'pointer'; // ubah cursor menjadi pointer
    // jadi ketika span di hover maka cursornya berubah pointer

    showHide.addEventListener('click', () => {
    // ketika span diclick
        if (password.type === 'password') {
            // jika type inputnya password
            password.type = 'text'; // ubah type menjadi text
            showHide.innerHTML = '<i class="fas fa-fw fa-eye-slash"></i>'; // ubah icon menjadi eye slash
        } else {
            // jika type bukan password (text)
            showHide.innerHTML = '<i class="fas fa-fw fa-eye"></i>'; // ubah icon menjadi eye
            password.type = 'password'; // ubah type menjadi password
        }
    });
</script>