<!-- MESSAGE NOTIFICATION -->
<script type="text/javascript" src="../js/message/jquery_message.js"></script>
    <script type="text/javascript">
    function ambilPesan(){
        $.ajax({
            type: "POST",
            url: "func/get-info-request.php",
            dataType:'json',
            success: function(data){
                $("#jumlah").html(data.unseen_notification);
                if (data.unseen_notification > 4) {
                    $("#moreMasuk").html(data.totalMasuk-2+' Request Pembelian Lainnya');
                    $("#moreKeluar").html(data.totalKeluar-2+' Request Penjualan Lainnya');
                }else{
                    $("#moreMasuk").html('Lihat Semua Request Pembelian');
                    $("#moreKeluar").html('Lihat Semua Request Penjualan');
                }
                $("#pesan").html(data.notification);
                timer = setTimeout("ambilPesan()",5000);
            }
        });  
    }
    $(document).ready(function(){
        ambilPesan();
    });
</script>
<!-- MESSAGE NOTIF -->

<!-- Nav Item - Alerts -->
<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <span class="badge badge-danger badge-counter" id="jumlah"></span>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
            Info Request Edit Hapus
        </h6>
        <div id="pesan">
        <!-- isi data disini -->
        </div>
        <a class="dropdown-item text-center small text-gray-500" href="rincian_request_masuk.php" id="moreMasuk"></a>
        <a class="dropdown-item text-center small text-gray-500" href="rincian_request_keluar.php" id="moreKeluar"></a>
    </div>
</li>