<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1">
        <title>Autocomplete Input Tanpa Database</title>
        <link href="https://masrud.com/cloudme.fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <style>
            body {
                font-family: 'Roboto', Arial, Sans-serif;
                font-size: 15px;
                font-weight: 400;
            }
            .container {
                left: 50%;
                position: absolute;
                top: 7.5%;
                transform: translate(-50%, -7.5%);
            }
            input[type=text] {
                border: 2px solid #bdbdbd;
                font-family: 'Roboto', Arial, Sans-serif;
                font-size: 15px;
                font-weight: 400;
                padding: .5em .75em;
                width: 300px;
            }
            input[type=text]:focus {
                border: 2px solid #757575;
                outline: none;
            }
            .autocomplete-suggestions {
                border: 1px solid #999;
                background: #FFF;
                overflow: auto;
            }
            .autocomplete-suggestion {
                padding: 2px 5px;
                white-space: nowrap;
                overflow: hidden;
            }
            .autocomplete-selected {
                background: #F0F0F0;
            }
            .autocomplete-suggestions strong {
                font-weight: normal;
                color: #3399FF;
            }
            .autocomplete-group {
                padding: 2px 5px;
            }
            .autocomplete-group strong {
                display: block;
                border-bottom: 1px solid #000;
            }
        </style>
    </head>
    <body>
        <?php include '../func/auto_complete.php'; ?>
        <div class="container">
            <h3>Autocomplete Input Tanpa Database</h3>
            <form action="" method="post">
                <input type="text" id="kode_barang" name="kode_barang" placeholder="Nama kode_barang">
            </form>
        </div>

        <!-- <script type="text/javascript">
            $(document).ready(function() {
                // Data yang ditampilkan pada autocomplete.
                var kode_barang = [
                    { value: 'Anggur', data: 'Anggur' },
                    { value: 'Apple', data: 'Apple' },
                    { value: 'Jeruk', data: 'Jeruk' },
                    { value: 'Mangga', data: 'Mangga' },
                    { value: 'Melon', data: 'Melon' },
                    { value: 'Manggis', data: 'Manggis' },
                    { value: 'Nanas', data: 'Nanas' },
                    { value: 'Semangka', data: 'Semangka' },
                    { value: 'Durian', data: 'Durian' },
                    { value: 'Peer', data: 'Peer' },
                    { value: 'Alpukat', data: 'Alpukat' },
                    { value: 'Nangka', data: 'Nangka' },
                    { value: 'Pepaya', data: 'Pepaya' },
                    { value: 'Sawo', data: 'Sawo' },
                    { value: 'Salak', data: 'Salak' },
                    { value: 'Pisang', data: 'Pisang' },
                    { value: 'Klengkeng', data: 'Klengkeng' },
                    { value: 'Rambutan', data: 'Rambutan' }
                ];

                // Selector input yang akan menampilkan autocomplete.
                $( "#kode_barang" ).autocomplete({
                    lookup: kode_barang
                });
            })
        </script> -->

        <script type="text/javascript">
    $(document).ready(function() {
        // Selector input yang akan menampilkan autocomplete.
        $( "#kode_barang" ).autocomplete({
            serviceUrl: "../func/source.php",   // Kode php untuk memproses data
            dataType: "JSON",           // Tipe data JSON
            onSelect: function (suggestion) {
                $( "#kode_barang" ).val("" + suggestion.kode_barang);
            }
        });
    })
</script>
    </body>
</html>