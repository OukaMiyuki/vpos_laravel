$(document).ready(function () {
    const tipe_barang = $("#tipe_barang").val();

    if(tipe_barang == "PCS"){
        $("#satuan").html("<option value=''>- Pilih Satuan Barang -</option><option value='Qty'>Qty</option><option value='Jumlah'>Jumlah</option>");
    } else if(tipe_barang == "Pack"){
        $("#satuan").html("<option value=''>- Pilih Satuan Barang -</option><option value='Berat'>Berat</option><option value='Jarak'>Jarak</option><option value='Volume'>Volume</option><option value='Panjang'>Panjang</option>");
    } else if(tipe_barang == "Custom"){
        $("#satuan").html("<option value=''>- Pilih Satuan Barang -</option><option value='Custom'>Custom</option>  ");
    }

    const satuan_barang = $('#satuan').attr('data-satuan_barang');

    if(satuan_barang){
        if(satuan_barang == "Berat"){
            $("#satuan").val("Berat").change();
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='Kg - (Kilogram)'>Kg - (Kilogram)</option><option value='g - (gram)'>g - (gram)</option><option value='Ons'>Ons</option><option value='Mg - (Miligram)'>Mg - (Miligram)</option><option value='Ton'>Ton</option><option value='Kw - (Kuintal)'>Kw - (Kuintal)</option>");
        } else if (satuan_barang == "Jarak"){
            $("#satuan").val("Jarak").change();
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='km - (Kilometer)'>km - (Kilometer)</option>");
        } else if (satuan_barang == "Volume"){
            $("#satuan").val("Volume").change();
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='kl - (Kiloliter)'>kl - (Kiloliter)</option><option value='hl - (Hektaliter)'>hl - (Hektaliter)</option><option value='dal - (Dekaliter)'>dal - (Dekaliter)</option><option value='l - (Liter)'>l - (Liter)</option><option value='dl - (Desiliter)'>dl - (Desiliter)</option><option value='cl - (Centiliter)'>cl - (Centiliter)</option><option value='ml - (Mililiter)'>ml - (Mililiter)</option>");
        } else if (satuan_barang == "Panjang"){
            $("#satuan").val("Panjang").change();
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='km - (Kilometer)'>km - (Kilometer)</option><option value='hm - (Hektometer)'>hm - (Hektometer)</option><option value='dam - (Dekameter)'>dam - (Dekameter)</option><option value='m - (Meter)'>m - (Meter)</option><option value='dm - (Desimeter)'>dm - (Desimeter)</option><option value='cm - (Centimeter)'>cm - (Centimeter)</option><option value='mm - (Milimeter)'>mm - (Milimeter)</option><option value='inch - (Inchi)'>inch - (Inchi)</option>");
        } else if (satuan_barang == "Jumlah"){
            $("#satuan").val("Jumlah").change();
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='Lusin'>Lusin</option><option value='Gross'>Gross</option><option value='Kodi'>Kodi</option><option value='Rim'>Rim</option>");
        } else if (satuan_barang == "Custom"){
            $("#satuan").val("Custom").change();
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='Custom'>Custom</option>");
        } else if (satuan_barang == "Qty"){
            $("#satuan").val("Qty").change();
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='PCS'>PCS</option>");
        }
    }

    const satuan_unit = $('#unit').attr('data-satuan_unit');

    if(satuan_unit == "Kg - (Kilogram)"){
        $("#unit").val("Kg - (Kilogram)").change();
    } else if(satuan_unit == "g - (gram)"){
        $("#unit").val("g - (gram)").change();
    } else if(satuan_unit == "Ons"){
        $("#unit").val("Ons").change();
    } else if(satuan_unit == "Mg - (Miligram)"){
        $("#unit").val("Mg - (Miligram)").change();
    } else if(satuan_unit == "Ton"){
        $("#unit").val("Ton").change();
    } else if(satuan_unit == "Kw - (Kuintal)"){
        $("#unit").val("Kw - (Kuintal)").change();
    } else if(satuan_unit == "km - (Kilometer)"){
        $("#unit").val("km - (Kilometer)").change();
    } else if(satuan_unit == "kl - (Kiloliter)"){
        $("#unit").val("kl - (Kiloliter)").change();
    } else if(satuan_unit == "hl - (Hektaliter)"){
        $("#unit").val("hl - (Hektaliter)").change();
    } else if(satuan_unit == "dal - (Dekaliter)"){
        $("#unit").val("dal - (Dekaliter)").change();
    } else if(satuan_unit == "l - (Liter)"){
        $("#unit").val("l - (Liter)").change();
    } else if(satuan_unit == "dl - (Desiliter)"){
        $("#unit").val("dl - (Desiliter)").change();
    } else if(satuan_unit == "cl - (Centiliter)"){
        $("#unit").val("cl - (Centiliter)").change();
    } else if(satuan_unit == "ml - (Mililiter"){
        $("#unit").val("ml - (Mililiter").change();
    } else if(satuan_unit == "km - (Kilometer)"){
        $("#unit").val("km - (Kilometer)").change();
    } else if(satuan_unit == "hm - (Hektometer)"){
        $("#unit").val("hm - (Hektometer)").change();
    } else if(satuan_unit == "dam - (Dekameter)"){
        $("#unit").val("dam - (Dekameter)").change();
    } else if(satuan_unit == "m - (Meter)"){
        $("#unit").val("m - (Meter)").change();
    } else if(satuan_unit == "dm - (Desimeter)"){
        $("#unit").val("dm - (Desimeter)").change();
    } else if(satuan_unit == "cm - (Centimeter)"){
        $("#unit").val("cm - (Centimeter)").change();
    } else if(satuan_unit == "cm - (Centimeter)"){
        $("#unit").val("cm - (Centimeter)").change();
    } else if(satuan_unit == "mm - (Milimeter)"){
        $("#unit").val("mm - (Milimeter)").change();
    } else if(satuan_unit == "inch - (Inchi)"){
        $("#unit").val("inch - (Inchi)").change();
    } else if(satuan_unit == "PCS"){
        $("#unit").val("PCS").change();
    } else if(satuan_unit == "Lusin"){
        $("#unit").val("Lusin").change();
    } else if(satuan_unit == "Gross"){
        $("#unit").val("Gross").change();
    } else if(satuan_unit == "Kodi"){
        $("#unit").val("Kodi").change();
    } else if(satuan_unit == "Rim"){
        $("#unit").val("Rim").change();
    } else if(satuan_unit == "Custom"){
        $("#unit").val("Custom").change();
    } 


    $("#tipe_barang").change(function () {
        var val = $(this).val();
        if (val == "PCS") {
            $("#satuan").html("<option value=''>- Pilih Satuan Barang -</option><option value='Qty'>Qty</option><option value='Jumlah'>Jumlah</option>");
        } else if (val == "Pack") {
            $("#satuan").html("<option value=''>- Pilih Satuan Barang -</option><option value='Berat'>Berat</option><option value='Jarak'>Jarak</option><option value='Volume'>Volume</option><option value='Panjang'>Panjang</option>");
        } else if (val == "Custom") {
            $("#satuan").html("<option value=''>- Pilih Satuan Barang -</option><option value='Custom'>Custom</option>  ");
        } 
    });
    $("#satuan").change(function () {
        var val = $(this).val();
        if (val == "Berat") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='Kg - (Kilogram)'>Kg - (Kilogram)</option><option value='g - (gram)'>g - (gram)</option><option value='Ons'>Ons</option><option value='Mg - (Miligram)'>Mg - (Miligram)</option><option value='Ton'>Ton</option><option value='Kw - (Kuintal)'>Kw - (Kuintal)</option>");
        } else if (val == "Jarak") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='km - (Kilometer)'>km - (Kilometer)</option>");
        } else if (val == "Volume") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='kl - (Kiloliter)'>kl - (Kiloliter)</option><option value='hl - (Hektaliter)'>hl - (Hektaliter)</option><option value='dal - (Dekaliter)'>dal - (Dekaliter)</option><option value='l - (Liter)'>l - (Liter)</option><option value='dl - (Desiliter)'>dl - (Desiliter)</option><option value='cl - (Centiliter)'>cl - (Centiliter)</option><option value='ml - (Mililiter)'>ml - (Mililiter)</option>");
        } else if (val == "Panjang") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='km - (Kilometer)'>km - (Kilometer)</option><option value='hm - (Hektometer)'>hm - (Hektometer)</option><option value='dam - (Dekameter)'>dam - (Dekameter)</option><option value='m - (Meter)'>m - (Meter)</option><option value='dm - (Desimeter)'>dm - (Desimeter)</option><option value='cm - (Centimeter)'>cm - (Centimeter)</option><option value='mm - (Milimeter)'>mm - (Milimeter)</option><option value='inch - (Inchi)'>inch - (Inchi)</option>");
        } else if (val == "Qty") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='PCS'>PCS</option>");
        } else if (val == "Jumlah") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='Lusin'>Lusin</option><option value='Gross'>Gross</option><option value='Kodi'>Kodi</option><option value='Rim'>Rim</option>");
        } else if (val == "Custom") {
            $("#unit").html("<option value=''>- Pilih Satuan Unit Barang -</option><option value='Custom'>Custom</option>");
        } 
    });
});