
<!-- modal edit -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Edit data masuk</h3>
        </div>
        <div class="modal-body">
          <form action="action/temp_edit_brg_masuk.php" method="POST" role="form">
            <div class="form-group">
                <input type="text" name="id_masuk_temp" value="" readonly hidden>
              <div class="row">
                <label class="col-sm-3 control-label text-right">Kode Barang</label>         
                <div class="col-sm-8"><input type="text" class="form-control" name="kode_barang" value="<?php echo $id['kode_barang'] ?>" readonly></div>
              </div>
            </div>
          </form>
        </div>
      </div>
<!-- modal edit close -->