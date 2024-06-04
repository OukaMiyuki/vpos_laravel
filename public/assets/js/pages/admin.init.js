$(document).ready(function(){

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
});
