$(document).ready(function () {
    $("#tipe_barang").change(function () {
        var val = $(this).val();
        if (val == "PCS") {
            $("#satuan").html("<option value=''>- Pilih Satuan Barang -</option><option value='Qty'>Qty</option><option value='Jumlah'>Jumlah</option>");
        } else if (val == "Pack") {
            $("#satuan").html("<option value=''>- Pilih Satuan Barang -</option><option value='Berat'>Berat</option><option value='Jarak'>Jarak</option><option value='Volume'>Volume</option><option value='Panjang'>Panjang</option><option value='Custom'>Custom</option>");
        } 
    });
    $("#satuan").change(function () {
        var val = $(this).val();
        if (val == "Berat") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='Kg - (Kilogram)'>Kg - (Kilogram)</option><option value='g - (gram)'>g - (gram)</option><option value='Ons'>Ons</option><option value='g - (gram)'>g - (gram)</option><option value='Mg - (Miligram)'>Mg - (Miligram)</option><option value='Ton'>Ton</option><option value='Kw - (Kuintal)'>Kuintal</option>");
        } else if (val == "Jarak") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='Km - (Kilometer)'>Km - (Kilometer</option>");
        } else if (val == "Volume") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='kl - (Kiloliter)'>kl - (Kiloliter)</option><option value='hl - (Hektaliter)'>hl - (Hektaliter)</option><option value='dal - (Dekaliter)'>dal - (Dekaliter)</option><option value='l - (Liter)'>l - (Liter)</option><option value='dl - (Desiliter)'>dl - (Desiliter)</option><option value='cl - (Centiliter)'>cl - (Centiliter)</option><option value='ml - (Mililiter)'>ml - (Mililiter)</option>");
        } else if (val == "Panjang") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='km - (Kilometer)'>km - (Kilometer)</option><option value='hm - (Hektometer)'>hm - (Hektometer)</option><option value='dm - (Dekameter)'>dm - (Dekameter)</option><option value='m - (Meter)'>m - (Meter)</option><option value='dm - (Desimeter)'>dm - (Desimeter)</option><option value='cm - (Centimeter)'>cm - (Centimeter)</option><option value='mm - (Milimeter)'>mm - (Milimeter)</option><option value='inch - (Inchi)'>inch - (Inchi)</option>");
        } else if (val == "Custom") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='Custom'>Custom</option>");
        } else if (val == "Qty") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='PCS'>PCS</option>");
        } else if (val == "Jumlah") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='Lusin'>Lusin</option><option value='Gross'>Gross</option><option value='Kodi'>Kodi</option><option value='Rim'>Rim</option>");
        } 
    });
});