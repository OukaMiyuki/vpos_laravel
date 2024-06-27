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

    $(document).on("click", "#detailsupplier", function() {
        var nama_supplier = $(this).data('nama');
        var email_supplier = $(this).data('email');
        var phone_supplier = $(this).data('phone');
        var alamat_supplier = $(this).data('alamat');
        var keterangan = $(this).data('keterangan');
        $("#show #nama_supplier").val(nama_supplier);
        $("#show #phone").val(phone_supplier);
        $("#show #email").val(email_supplier);
        $("#show #alamat").val(alamat_supplier);
        $("#show #keterangan").val(keterangan);
    });

    $(document).on("click", "#editsupplier", function() {
        var id = $(this).data('id');
        var nama_supplier = $(this).data('nama');
        var email_supplier = $(this).data('email');
        var phone_supplier = $(this).data('phone');
        var alamat_supplier = $(this).data('alamat');
        var keterangan = $(this).data('keterangan');
        $("#show #id").val(id);
        $("#show #nama_supplier").val(nama_supplier);
        $("#show #phone").val(phone_supplier);
        $("#show #email").val(email_supplier);
        $("#show #alamat").val(alamat_supplier);
        $("#show #keterangan").val(keterangan);
    });

    $(document).on("click", "#editkategori", function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        $("#show #id").val(id);
        $("#show #category").val(nama);
    });

    $(document).on("click", "#editbatch", function() {
        var id = $(this).data('id');
        var kode = $(this).data('kode');
        var keterangan = $(this).data('keterangan');
        $("#show #id").val(id);
        $("#show #name").val(kode);
        $("#show #keterangan").val(keterangan);
    });

    $(document).on("click", "#aktifkandiskon", function() {
        var id = $(this).data('id');
        $("#show #id").val(id);
    });

    $(function(){
        var dtToday = new Date();
        
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        
        var maxDate = year + '-' + month + '-' + day;
        $('#t_beli').attr('max', maxDate);
    });

    $(document).on("click", "#enable_manual_batcode", function() {
        const barcode_txt = document.getElementById('barcode');
        if (barcode_txt.readOnly) {
            barcode_txt.readOnly = false;
            this.innerHTML = "Masukkan Barcode via Scanner";
            // console.log('✅ element is read-only');
        } else {
            // console.log('⛔️ element is not read-only');
            this.innerHTML = "Input Barcode Manual";
            barcode_txt.value = "";
            barcode_txt.readOnly = true;
        }
    });

});

$("#tunai_text").hide();
$("#nominal").attr("disabled", "disabled");
$("#kembalian").attr("disabled", "disabled");
$(document).ready(function(){
    $('#pembayaran').on('change', function() {
        if ( this.value == 'Tunai') {
            $("#tunai_text").show();
            $("#nominal").removeAttr("disabled");
            $("#kembalian").removeAttr("disabled");
        }
        else {
            $("#tunai_text").hide();
            $("#nominal").val("");
            $("#nominal").attr("disabled", "disabled");
            $("#kembalian").attr("disabled", "disabled");
        }
    });
});

$(document).ready(function() {
    let kembaliantxt = document.getElementById("kembalian");
    $('#nominal').on("input", function() {
        let nominal = $('#nominal').val();
        let subttl = $('#subbttl').val();
        let angka_sub_total = subttl.replace(/[^0-9.-]+/g,"");
        let subtotal = parseInt(angka_sub_total);
        let kembalian = nominal-subtotal;
        if (kembalian >= 0){
            // $('#kembalian').val(kembalian);
            kembaliantxt.value = formatRupiah(kembalian, "Rp. ");
        } else {
            $('#kembalian').val(0);
        }
    });
});

$(document).ready(function() {
    let kmbtxtt = document.getElementById("kem");
    $('#nom').on("input", function() {
        let nom = $('#nom').val();
        let subtl = $('#ttl').val();
        let angka_sub_total = subtl.replace(/[^0-9.-]+/g,"");
        let sbtotal = parseInt(angka_sub_total);
        let kembl = nom-sbtotal;
        if (kembl >= 0){
            // $('#kembalian').val(kembalian);
            kmbtxtt.value = formatRupiah(kembl, "Rp. ");
        } else {
            $('#kem').val(0);
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

$(document).ready(function() {
    //document.getElementById("sidebaruser-check").checked = true;
    $("#pembayaran").on('change', function() {
        if ($(this).val() == ''){
            $("#formCheckout").attr('disabled',true);
        } else {
            $("#formCheckout").attr('disabled',false);
            $('#formCheckout').on('click', function(e){
                if($("#pembayaran").val() == 'Tunai'){
                    if($("#nominal").val().length > 0 && $("#kembalian").val().length > 0){
                        $("#checkoutProcess #jenisPembayaran").val($("#pembayaran").val());
                        $("#checkoutProcess #nominalText").val($("#nominal").val());
                        $("#checkoutProcess #kembalianText").val($("#kembalian").val());
                        $('#processInvoice').modal('show');
                        e.preventDefault();
                    }
                } else if($("#pembayaran").val() == 'Qris'){
                    $("#checkoutProcess #jenisPembayaran").val($("#pembayaran").val());
                    $('#processInvoice').modal('show');
                    e.preventDefault();
                }
            });
        }
    });
});