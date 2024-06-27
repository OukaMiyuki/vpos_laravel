$(document).ready(function(){
    $('#image').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });

    $('#swift_code').on('change',function(){
            if($(this).val() != "default"){
            $('#nama_bank').val($( "#swift_code option:selected" ).text());
        }else{
            $('#nama_bank').val('');
        }
    });
});

$(document).ready(function() {
    let total_tarik = document.getElementById("total_tarik");
    $('#nominal_tarik_dana').on("input", function() {
        var nominal = parseInt(document.getElementById("nominal_tarik_dana").value);
        if(nominal<10000){
            total_tarik.value = 0;
        } else {
            var biaya_transfer = parseInt(document.getElementById("biaya_transfer_bank").value);
            var total = nominal+biaya_transfer;
            // let nominal_clean = nominal.replace(/[^0-9.-]+/g,"");
            // let biaya_transfer_clean = biaya_transfer.replace(/[^0-9.-]+/g,"");
            // let total =biaya_transfer+nominal;
            // let total_withdraw = parseInt(total);
            total_tarik.value = formatRupiah(total, "Rp. ");
            // total_tarik.value = total;
        }
    });
});

function formatRupiah(angka, prefix) {
    var number_string = angka.toString().replace(/[^,\d]/g, ""),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}