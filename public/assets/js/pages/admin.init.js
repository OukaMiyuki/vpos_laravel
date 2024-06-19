$(document).ready(function(){

    $('#swift_code').on('change',function(){
            if($(this).val() != "default"){
            $('#nama_bank').val($( "#swift_code option:selected" ).text());
        }else{
            $('#nama_bank').val('');
        }
    });

    $('#image').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });

    $(document).on("click", "#approval-umi", function() {
        var id = $(this).data('id');
        var store_identifier = $(this).data('store_identifier');
        $("#show #id").val(id);
        $("#show #store_identifier").val(store_identifier);
    });

    $(document).on("click", "#reject-umi", function() {
        var id = $(this).data('id');
        var store_identifier = $(this).data('store_identifier');
        $("#reject #id").val(id);
        $("#reject #store_identifier").val(store_identifier);
    });

    $(document).on("click", "#edit-data-qris", function() {
        var id = $(this).data('id');
        var store_identifier = $(this).data('store_identifier');
        var qris_login = $(this).data('qris_login');
        var qris_password = $(this).data('qris_password');
        var qris_merchant_id = $(this).data('qris_merchant_id');
        var qris_store_id = $(this).data('qris_store_id');
        var mdr = $(this).data('mdr');
        $("#show #id").val(id);
        $("#show #store_identifier").val(store_identifier);
        $("#show #qris_login").val(qris_login);
        $("#show #qris_password").val(qris_password);
        $("#show #qris_merchant_id").val(qris_merchant_id);
        $("#show #qris_store_id").val(qris_store_id);
        $("#show #mdr").val(mdr);
    });
    $(document).on("click", "#edit-data-insentif", function() {
        var id = $(this).data('id');
        var jenis_insentif = $(this).data('jenis_insentif');
        var nominal = $(this).data('nominal');
        $("#show #id").val(id);
        $("#show #name").val(jenis_insentif);
        $("#show #nominal_insentif").val(nominal);
    });
});
$("#saldo-qris-txt").hide();
$("#saldo-agregate-aplikasi-txt").hide();
$("#saldo-agregate-transfer-txt").hide();
$(document).ready(function() {
    $("#dana").on('change', function() {
        if ($(this).val() == ''){
            $("#jenis-tarik").val("");
            $("#saldo-qris-txt").hide();
            $("#saldo-agregate-aplikasi-txt").hide();
            $("#saldo-agregate-transfer-txt").hide();
            $("#tarikDanaButton").attr('disabled',true);
        } else {
            $("#tarikDanaButton").attr('disabled',false);

            if($("#dana").val() == 'Qris'){
                $("#jenis-tarik").val("Qris");
                $("#saldo-qris-txt").show();
                $("#saldo-agregate-transfer-txt").hide();
                $("#saldo-agregate-aplikasi-txt").hide();
            } else if($("#dana").val() == 'Aplikasi'){
                $("#jenis-tarik").val("Aplikasi");
                $("#saldo-qris-txt").hide();
                $("#saldo-agregate-transfer-txt").hide();
                $("#saldo-agregate-aplikasi-txt").show();
            } else if($("#dana").val() == 'Transfer'){
                $("#jenis-tarik").val("Transfer");
                $("#saldo-qris-txt").hide();
                $("#saldo-agregate-transfer-txt").show();
                $("#saldo-agregate-aplikasi-txt").hide();
            } else {
                $("#jenis-tarik").val("");
                $("#saldo-qris-txt").hide();
                $("#saldo-agregate-aplikasi-txt").hide();
                $("#saldo-agregate-transfer-txt").hide();
                $("#tarikDanaButton").attr('disabled',true);
            }
        }
    });
});
