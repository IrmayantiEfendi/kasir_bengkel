<div class="modal-header">
          <h3 class="modal-title">Buat Akun Karyawan Baru</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <form method="POST" action="action/register.php">
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-12 mb-sm-0">
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="User Name">
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="password" name="password"
                                            placeholder="Password">
                                        <!-- <input type="Password" id="Newpassword" name="password" class="form-control"
                                            aria-label="Insert Password" aria-describedby="basic-addon2" placeholder="Password">
                                            <span class="input-group-text" id="showHide">
                                                <i class="fas fa-fw fa-eye"></i>
                                            </span> -->
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-12 mb-sm-0">
                                        <input type="text" class="form-control"
                                            id="no_hp" name="no_hp" placeholder="No HP (Whatsapp)">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-12 mb-sm-0">
                                        <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-12 mb-sm-0">
                                        <p>Tanggal Mulai Kerja</p>
                                        <input type="date" class="form-control"
                                            id="tgl_mulai" name="tgl_mulai" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-12 mb-sm-0">
                                        <select class="form-control" id="hari_libur" name="hari_libur">
                                            <option value="0">===Pilih Hari Libur===</option>
                                            <option>Senin</option>
                                            <option>Selasa</option>
                                            <option>Rabu</option>
                                            <option>Kamis</option>
                                            <option>Jumat</option>
                                            <option>Sabtu</option>
                                            <option>Minggu</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary btn-user btn-block" name="simpan" value="Buat Akun">
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
    const password = document.getElementById('Newpassword'); // id dari input password
    const showHide = document.getElementById('showHide'); // id span showHide dalam input group password

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