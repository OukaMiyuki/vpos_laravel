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
    $(document).on("click", "#edit-settlement", function() {
        var id = $(this).data('id');
        var start_date = $(this).data('start_date');
        var end_date = $(this).data('end_date');
        var note = $(this).data('note');
        console.log(start_date);
        $("#show #id").val(id);
        $("#show #start_date").val(start_date);
        $("#show #end_date").val(end_date);
        $("#show #note").val(note);
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

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table.draw();
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/mitra-bisnis/transaction',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/mitra-bisnis/transaction',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            // {data: 'name', name: 'name'},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'tenant', name: 'tenant'},
            {data: 'store_identifier', name: 'store_identifier'},
            {data: 'merchant_name', name: 'merchant_name'},
            {data: 'status', name: 'status'},
            {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
            {data: 'tanggal_pembayaran', name: 'tanggal_pembayaran'},
            {data: 'jenis_pembayaran', name: 'jenis_pembayaran'},
            {data: 'nominal_bayar', name: 'nominal_bayar'},
            {data: 'mdr', name: 'mdr'},
            {data: 'nominal_mdr', name: 'nominal_mdr'},
            {data: 'nominal_terima_bersih', name: 'nominal_terima_bersih'},
            // {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    var start_date_user_transaction = moment().subtract(1, 'M');
    var end_date_user_transaction = moment();
    $('#daterange-filter-user-transaction span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange-filter-user-transaction').daterangepicker({
        startDate : start_date_user_transaction,
        endDate : end_date_user_transaction
    }, function(start_date, end_date){
        $('#daterange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_transaction_user.draw();
    });


    var table_transaction_user = $('.user-table-transaction').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/mitra-bisnis/transaction',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange-filter-user-transaction').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange-filter-user-transaction').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/user/transaction',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'store_identifier', name: 'store_identifier'},
            {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
            {data: 'tanggal_pembayaran', name: 'tanggal_pembayaran'},
            {data: 'jenis_pembayaran', name: 'jenis_pembayaran'},
            {data: 'status', name: 'status'},
            {data: 'nominal_bayar', name: 'nominal_bayar'},
            {data: 'mdr', name: 'mdr'},
            {data: 'nominal_mdr', name: 'nominal_mdr'},
            {data: 'nominal_terima_bersih', name: 'nominal_terima_bersih'},
            // {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
});
