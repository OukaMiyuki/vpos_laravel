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
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_transaction span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_transaction').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_transaction span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_transaction.draw();
    });

    var table_user_transaction = $('.user-table-transaction').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/mitra-bisnis/transaction',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_transaction').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_transaction').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/user/transaction',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_transaction').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_transaction').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'store_identifier', name: 'store_identifier'},
            {data: 'email', name: 'email'},
            {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
            {data: 'tanggal_pembayaran', name: 'tanggal_pembayaran'},
            {data: 'jenis_pembayaran', name: 'jenis_pembayaran'},
            {data: 'status', name: 'status'},
            {data: 'nominal_bayar', name: 'nominal_bayar'},
            {data: 'mdr', name: 'mdr'},
            {data: 'nominal_mdr', name: 'nominal_mdr'},
            {data: 'nominal_terima_bersih', name: 'nominal_terima_bersih'},
            // {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { className: 'text-center', targets: [4,5] },
        ],
    });
});

$(function () {
    var table_settlement_ready = $('.user-table-transaction-ready-settlement').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/user/transaction/settlement-ready',
            "type": "GET",
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/user/transaction/settlement-ready',
        //     "type": "GET",
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'store_identifier', name: 'store_identifier'},
            {data: 'email', name: 'email'},
            {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
            {data: 'tanggal_pembayaran', name: 'tanggal_pembayaran'},
            {data: 'jenis_pembayaran', name: 'jenis_pembayaran'},
            {data: 'status', name: 'status'},
            {data: 'nominal_bayar', name: 'nominal_bayar'},
            {data: 'mdr', name: 'mdr'},
            {data: 'nominal_mdr', name: 'nominal_mdr'},
            {data: 'nominal_terima_bersih', name: 'nominal_terima_bersih'},
            // {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { className: 'text-center', targets: [4,5] },
        ],
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_user_withdraw span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_user_withdraw').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_user_withdraw span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_withdrawal.draw();
    });


    var table_user_withdrawal = $('.user-table-withdrawal').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/user/withdrawals',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_user_withdraw').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_user_withdraw').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/user/withdrawals',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_user_withdraw').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_user_withdraw').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'email', name: 'email'},
            {data: 'jenis_penarikan', name: 'jenis_penarikan'},
            {data: 'tanggal_penarikan', name: 'tanggal_penarikan'},
            {data: 'nominal', name: 'nominal'},
            {data: 'total_biaya', name: 'total_biaya'},
            {data: 'status', name: 'status'},
        ],
        columnDefs: [
            { className: 'text-center', targets: [5] },
        ],
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_umi_request span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_umi_request').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_umi_request span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
        console.log("Walla");
        table_user_withdrawal.draw();
    });


    var table_user_withdrawal = $('.user-table-umi-request').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/user/request-umi',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_umi_request').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_umi_request').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/user/request-umi',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_umi_request').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_umi_request').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'email', name: 'email'},
            {data: 'store_identifier', name: 'store_identifier'},
            {data: 'tanggal_pengajuan', name: 'tanggal_pengajuan'},
            {data: 'tanggal_approval', name: 'tanggal_approval'},
            {data: 'status', name: 'status'},
            {data: 'file_attach', name: 'file_attach'},
            {data: 'note', name: 'note'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { className: 'text-center', targets: [3, 4, 5, 6] },
        ],
    });
});

$(function () {
    var table_settlement_ready = $('.user-table-marketing-list').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/mitra-aplikasi/list',
            "type": "GET",
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/mitra-aplikasi/list',
        //     "type": "GET",
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'action', name: 'action'},
            {data: 'name', name: 'name'},
            {data: 'no_ktp', name: 'no_ktp'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'tanggal_gabung', name: 'tanggal_gabung'},
            {data: 'status', name: 'status'},
            // {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { className: 'text-center', targets: [6,7] },
        ],
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_user_withdraw_mitra_alikasi span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_user_withdraw_mitra_alikasi').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_user_withdraw_mitra_alikasi span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_withdrawal.draw();
    });


    var table_user_withdrawal = $('.user-table-withdrawal-mitra-aplikasi').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/mitra-aplikasi/withdraw',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_user_withdraw_mitra_alikasi').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_user_withdraw_mitra_alikasi').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/mitra-aplikasi/withdraw',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_user_withdraw_mitra_alikasi').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_user_withdraw_mitra_alikasi').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'tanggal_penarikan', name: 'tanggal_penarikan'},
            {data: 'nominal', name: 'nominal'},
            {data: 'biaya_admin', name: 'biaya_admin'},
            {data: 'status', name: 'status'},
        ],
        columnDefs: [
            { className: 'text-center', targets: [5] },
        ],
    });
});

$(function () {
    var table_user_withdrawal = $('.user-table-mitra-bisnis-list').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/mitra-bisnis/list',
            "type": "GET",
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/mitra-bisnis/list',
        //     "type": "GET",
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'tanggal_gabung', name: 'tanggal_gabung'},
            {data: 'total_merchant', name: 'total_merchant'},
            {data: 'total_withdraw', name: 'total_withdraw'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { className: 'text-center', targets: [5] },
        ],
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

$(function () {
    var table_user_withdrawal = $('.user-table-mitra-bisnis-merchant-list').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/mitra-bisnis/merchant',
            "type": "GET",
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/mitra-bisnis/merchant',
        //     "type": "GET",
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'merchant_name', name: 'merchant_name'},
            {data: 'store_identifier', name: 'store_identifier'},
            {data: 'mitra_bisnis', name: 'mitra_bisnis'},
            {data: 'email', name: 'email'},
            {data: 'jenis_usaha', name: 'jenis_usaha'},
            {data: 'status', name: 'status'},
            {data: 'status_umi', name: 'status_umi'},
            {data: 'total_transaksi', name: 'total_transaksi'},
            {data: 'total_penghasilan', name: 'total_penghasilan'},
            {data: 'invoice_list_action', name: 'invoice_list_action', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { className: 'text-center', targets: [6,7,8,10,11] },
        ],
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_user_mitra_bisnis_withdraw span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_user_mitra_bisnis_withdraw').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_user_mitra_bisnis_withdraw span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_mitrabisnis_withdrawal.draw();
    });


    var table_user_mitrabisnis_withdrawal = $('.user-table-withdrawal-mitra-bisnis').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/mitra-bisnis/withdrawals',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_user_mitra_bisnis_withdraw').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_user_mitra_bisnis_withdraw').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/mitra-bisnis/withdrawals',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_user_mitra_bisnis_withdraw').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_user_mitra_bisnis_withdraw').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'tanggal_penarikan', name: 'tanggal_penarikan'},
            {data: 'nominal', name: 'nominal'},
            {data: 'total_biaya', name: 'total_biaya'},
            {data: 'status', name: 'status'},
        ],
        columnDefs: [
            { className: 'text-center', targets: [1,5,8] },
        ],
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

$(function () {
    var table_user_withdrawal = $('.user-table-mitra-tenant-list').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/mitra-tenant/list',
            "type": "GET",
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/mitra-tenant/list',
        //     "type": "GET",
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'no_ktp', name: 'no_ktp'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'tanggal_gabung', name: 'tanggal_gabung'},
            {data: 'jenis_kelamin', name: 'jenis_kelamin'},
            {data: 'status', name: 'status'},
            {data: 'total_invoice', name: 'total_invoice'},
            {data: 'total_withdraw', name: 'total_withdraw'},
            {data: 'invitation_code', name: 'invitation_code'},
            {data: 'holder', name: 'holder'},
            {data: 'nama_mitra', name: 'nama_mitra'},
        ],
        columnDefs: [
            { className: 'text-center', targets: [1, 6, 8, 11] },
        ],
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

$(function () {
    var table_user_mitra_tenant_store_list = $('.user-table-mitra-tenant-store-list').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/mitra-tenant/store',
            "type": "GET",
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/mitra-tenant/store',
        //     "type": "GET",
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'store_identifier', name: 'store_identifier'},
            {data: 'store_name', name: 'store_name'},
            {data: 'jenis_usaha', name: 'jenis_usaha'},
            {data: 'status_umi', name: 'status_umi'},
            {data: 'total_transaksi', name: 'total_transaksi'},
            {data: 'total_penghasilan', name: 'total_penghasilan'},
            {data: 'invoice_list_action', name: 'invoice_list_action', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { className: 'text-center', targets: [7,8,9] },
        ],
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

$(function () {
    var table_user_kasir_list = $('.user-table-kasir-list').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/mitra-tenant/kasir',
            "type": "GET",
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/mitra-tenant/kasir',
        //     "type": "GET",
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'jenis_kelamin', name: 'jenis_kelamin'},
            {data: 'status', name: 'status'},
            {data: 'store_identifier', name: 'store_identifier'},
            {data: 'store_name', name: 'store_name'},
            {data: 'tenant', name: 'tenant'},
        ],
        columnDefs: [
            { className: 'text-center', targets: [4,5,9] },
        ],
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_mitra_tenant_transaction span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_mitra_tenant_transaction').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_mitra_tenant_transaction span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_tenant_transaction.draw();
    });

    var table_tenant_transaction = $('.data-table-user-mitra-tenant-transaction').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/mitra-tenant/transaction',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_mitra_tenant_transaction').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_mitra_tenant_transaction').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/mitra-tenant/transaction',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_mitra_tenant_transaction').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_mitra_tenant_transaction').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'tenant', name: 'tenant'},
            {data: 'store_identifier', name: 'store_identifier'},
            {data: 'store_name', name: 'store_name'},
            {data: 'status', name: 'status'},
            {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
            {data: 'tanggal_pembayaran', name: 'tanggal_pembayaran'},
            {data: 'nilai_transaksi', name: 'nilai_transaksi'},
            {data: 'jenis_pembayaran', name: 'jenis_pembayaran'},
            {data: 'sub_total', name: 'sub_total'},
            {data: 'diskon', name: 'diskon'},
            {data: 'pajak', name: 'pajak'},
            {data: 'nominal_bayar', name: 'nominal_bayar'},
            {data: 'kembalian', name: 'kembalian'},
            {data: 'mdr', name: 'mdr'},
            {data: 'nominal_mdr', name: 'nominal_mdr'},
            {data: 'nominal_terima_bersih', name: 'nominal_terima_bersih'},
            // {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_user_mitra_tenant_withdraw span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_user_mitra_tenant_withdraw').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_user_mitra_tenant_withdraw span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_mitrabisnis_withdrawal.draw();
    });


    var table_user_mitrabisnis_withdrawal = $('.user-table-withdrawal-mitra-tenant').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/mitra-tenant/withdrawals',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_user_mitra_tenant_withdraw').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_user_mitra_tenant_withdraw').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/mitra-tenant/withdrawals',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_user_mitra_tenant_withdraw').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_user_mitra_tenant_withdraw').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'tanggal_penarikan', name: 'tanggal_penarikan'},
            {data: 'nominal', name: 'nominal'},
            {data: 'total_biaya', name: 'total_biaya'},
            {data: 'status', name: 'status'},
        ],
        columnDefs: [
            { className: 'text-center', targets: [1,5,8] },
        ],
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_user_settlement_history span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_user_settlement_history').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_user_settlement_history span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_settlement_history.draw();
    });


    var table_user_settlement_history = $('.user-table-settlement-history').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/finance/settlement/history',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_user_settlement_history').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_user_settlement_history').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/finance/settlement/history',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_user_settlement_history').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_user_settlement_history').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nomor_settlement', name: 'nomor_settlement'},
            {data: 'tanggal_settlement', name: 'tanggal_settlement'},
            {data: 'nominal', name: 'nominal'},
            {data: 'total_cashback', name: 'total_cashback'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { className: 'text-center', targets: [2,5,6] },
        ],
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_user_login_history span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_user_login_history').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_user_login_history span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_login_history.draw();
    });


    var table_user_login_history = $('.user-table-login-history').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/history/user-login',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_user_login_history').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_user_login_history').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/history/user-login',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_user_login_history').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_user_login_history').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'email', name: 'email'},
            {data: 'activity', name: 'activity'},
            {data: 'lokasi', name: 'lokasi'},
            {data: 'ip_address', name: 'ip_address'},
            {data: 'tanggal', name: 'tanggal'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { className: 'text-center', targets: [5,6,7] },
        ],
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_user_register_history span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_user_register_history').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_user_register_history span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_register_history.draw();
    });


    var table_user_register_history = $('.user-table-register-history').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/history/user-register',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_user_register_history').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_user_register_history').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/history/user-register',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_user_register_history').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_user_register_history').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'email', name: 'email'},
            {data: 'activity', name: 'activity'},
            {data: 'lokasi', name: 'lokasi'},
            {data: 'ip_address', name: 'ip_address'},
            {data: 'tanggal', name: 'tanggal'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { className: 'text-center', targets: [5,6,7] },
        ],
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_user_activity_history span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_user_activity_history').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_user_activity_history span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_activity_history.draw();
    });


    var table_user_activity_history = $('.user-table-activity-history').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/history/user-activity',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_user_activity_history').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_user_activity_history').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/history/user-activity',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_user_activity_history').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_user_activity_history').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'email', name: 'email'},
            {data: 'activity', name: 'activity'},
            {data: 'lokasi', name: 'lokasi'},
            {data: 'ip_address', name: 'ip_address'},
            {data: 'tanggal', name: 'tanggal'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { className: 'text-center', targets: [5,6,7] },
        ],
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_user_withdraw_history span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_user_withdraw_history').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_user_withdraw_history span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_withdraw_history.draw();
    });


    var table_user_withdraw_history = $('.user-table-withdraw-history-list').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/history/user-withdrawal',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_user_withdraw_history').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_user_withdraw_history').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/history/user-withdrawal',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_user_withdraw_history').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_user_withdraw_history').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'email', name: 'email'},
            {data: 'activity', name: 'activity'},
            {data: 'lokasi', name: 'lokasi'},
            {data: 'ip_address', name: 'ip_address'},
            {data: 'tanggal', name: 'tanggal'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { className: 'text-center', targets: [5,6,7] },
        ],
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_user_error_history span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_user_error_history').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_user_error_history span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_error_history.draw();
    });


    var table_user_error_history = $('.user-table-error-history-list').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/admin/dashboard/history/error',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_user_error_history').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_user_error_history').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/admin/dashboard/history/error',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_user_error_history').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_user_error_history').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'email', name: 'email'},
            {data: 'activity', name: 'activity'},
            {data: 'lokasi', name: 'lokasi'},
            {data: 'ip_address', name: 'ip_address'},
            {data: 'tanggal', name: 'tanggal'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            { className: 'text-center', targets: [5,6,7] },
        ],
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

// $(function () {
//     var start_date = moment().subtract(1, 'M');
//     var end_date = moment();
//     $('#daterange_transaction_merchant_invoice span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
//     $('#daterange_transaction_merchant_invoice').daterangepicker({
//         startDate : start_date,
//         endDate : end_date
//     }, function(start_date, end_date){
//         $('#daterange_transaction_merchant_invoice span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

//         table_merchant_invoice_list.draw();
//     });

//     var table_merchant_invoice_list = $('.user-table-mitra-bisnis-invoice-list').DataTable({
//         processing: true,
//         serverSide: true,
//         // ajax: {
//         //     "url": 'https://visipos.id/admin/dashboard/mitra-bisnis/merchant/invoice/'+id+'/'+store_identifier,
//         //     "type": "GET",
//                 // data : function(data){
//                 //     data.from_date = $('#daterange_transaction_merchant_invoice').data('daterangepicker').startDate.format('YYYY-MM-DD');
//                 //     data.to_date = $('#daterange_transaction_merchant_invoice').data('daterangepicker').endDate.format('YYYY-MM-DD');
//                 // }
//         // },
//         ajax: {
//             "url": 'http://localhost:8000/admin/dashboard/mitra-bisnis/merchant/invoice/'+id+'/'+store_identifier,
//             "type": "GET",
//             data : function(data){
//                 data.from_date = $('#daterange_transaction_merchant_invoice').data('daterangepicker').startDate.format('YYYY-MM-DD');
//                 data.to_date = $('#daterange_transaction_merchant_invoice').data('daterangepicker').endDate.format('YYYY-MM-DD');
//             }
//         },
//         columns: [
//             {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
//             {data: 'nama_mitra', name: 'nama_mitra'},
//             {data: 'merchant_name', name: 'merchant_name'},
//             {data: 'store_identifier', name: 'store_identifier'},
//             {data: 'nomor_invoice', name: 'nomor_invoice'},
//             {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
//             {data: 'tanggal_pembayaran', name: 'tanggal_pembayaran'},
//             {data: 'jenis_pembayaran', name: 'jenis_pembayaran'},
//             {data: 'status_pembayaran', name: 'status_pembayaran'},
//             {data: 'nominal_bayar', name: 'nominal_bayar'},
//             {data: 'mdr', name: 'mdr'},
//             {data: 'nominal_mdr', name: 'nominal_mdr'},
//             {data: 'nominal_terima_bersih', name: 'nominal_terima_bersih'},
//         ],
//         columnDefs: [
//             { className: 'text-center', targets: [6,7,8,10,11] },
//         ],
//         scrollX: !0,
//         language: {
//             paginate: {
//                 previous: "<i class='mdi mdi-chevron-left'>",
//                 next: "<i class='mdi mdi-chevron-right'>"
//             }
//         },
//         drawCallback: function() {
//             $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
//         }
//     });
// });

$(document).ready(function() {
    $("#basic-table").DataTable({
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });

    // $("#selection-datatable").DataTable({
    //     select: {
    //         style: "multi"
    //     },
    //     language: {
    //         paginate: {
    //             previous: "<i class='mdi mdi-chevron-left'>",
    //             next: "<i class='mdi mdi-chevron-right'>"
    //         }
    //     },
    //     drawCallback: function() {
    //         $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
    //     }
    // });

    $("#scroll-horizontal-table").DataTable({
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});

