$(document).ready(function(){
    $('#image').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });

    $('#ktp-image').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImageKtp').attr('src', e.target.result);
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

    $(document).on("click", "#kirimWaButton", function() {
        var id = $(this).data('id');
        $("#kirimWa #id").val(id);
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

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_transaction_tunai_tenant span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_transaction_tunai_tenant').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_transaction_tunai_tenant span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_transaction.draw();
    });

    var table_user_transaction = $('.tenant-transaction-tunai').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/tenant/dashboard/transaction/tunai',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_transaction_tunai_tenant').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_transaction_tunai_tenant').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/tenant/dashboard/transaction/tunai',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_transaction_tunai_tenant').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_transaction_tunai_tenant').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'kasir', name: 'kasir'},
            {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
            {data: 'tanggal_pembayaran', name: 'tanggal_pembayaran'},
            {data: 'jenis_pembayaran', name: 'jenis_pembayaran'},
            {data: 'transaksi_oleh', name: 'transaksi_oleh'},
            {data: 'status_transaksi', name: 'status_transaksi'},
            {data: 'status_pembayaran', name: 'status_pembayaran'},
            {data: 'sub_total', name: 'sub_total'},
            {data: 'pajak', name: 'pajak'},
            {data: 'diskon', name: 'diskon'},
            {data: 'nilai_transaksi', name: 'nilai_transaksi'},
            {data: 'nominal_bayar', name: 'nominal_bayar'},
            {data: 'kembalian', name: 'kembalian'},
        ],
        // columnDefs: [
        //     { className: 'text-center', targets: [4,5] },
        // ],
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_transaction_list_tenant span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_transaction_list_tenant').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_transaction_list_tenant span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_transaction.draw();
    });

    var table_user_transaction = $('.tenant-transaction-list-all').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/tenant/dashboard/transaction/list',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_transaction_list_tenant').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_transaction_list_tenant').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/tenant/dashboard/transaction/list',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_transaction_list_tenant').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_transaction_list_tenant').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'kasir', name: 'kasir'},
            {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
            {data: 'tanggal_pembayaran', name: 'tanggal_pembayaran'},
            {data: 'jenis_pembayaran', name: 'jenis_pembayaran'},
            {data: 'status_pembayaran', name: 'status_pembayaran'},
            {data: 'transaksi_oleh', name: 'transaksi_oleh'},
            {data: 'status_transaksi', name: 'status_transaksi'},
            {data: 'sub_total', name: 'sub_total'},
            {data: 'pajak', name: 'pajak'},
            {data: 'diskon', name: 'diskon'},
            {data: 'nilai_transaksi', name: 'nilai_transaksi'},
            {data: 'nominal_bayar', name: 'nominal_bayar'},
            {data: 'kembalian', name: 'kembalian'},
            {data: 'mdr', name: 'mdr'},
            {data: 'nominal_mdr', name: 'nominal_mdr'},
            {data: 'nominal_terima_bersih', name: 'nominal_terima_bersih'},
        ],
        // columnDefs: [
        //     { className: 'text-center', targets: [4,5] },
        // ],
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_transaction_list_qris_tenant span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_transaction_list_qris_tenant').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_transaction_list_qris_tenant span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_transaction.draw();
    });

    var table_user_transaction = $('.tenant-transaction-list-qris').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": 'https://visipos.id/tenant/dashboard/transaction/qris',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_transaction_list_qris_tenant').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_transaction_list_qris_tenant').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        // ajax: {
        //     "url": 'http://localhost:8000/tenant/dashboard/transaction/qris',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_transaction_list_qris_tenant').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_transaction_list_qris_tenant').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'kasir', name: 'kasir'},
            {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
            {data: 'tanggal_pembayaran', name: 'tanggal_pembayaran'},
            {data: 'jenis_pembayaran', name: 'jenis_pembayaran'},
            {data: 'status_pembayaran', name: 'status_pembayaran'},
            {data: 'transaksi_oleh', name: 'transaksi_oleh'},
            {data: 'status_transaksi', name: 'status_transaksi'},
            {data: 'sub_total', name: 'sub_total'},
            {data: 'pajak', name: 'pajak'},
            {data: 'diskon', name: 'diskon'},
            {data: 'nominal_bayar', name: 'nominal_bayar'},
            {data: 'mdr', name: 'mdr'},
            {data: 'nominal_mdr', name: 'nominal_mdr'},
            {data: 'nominal_terima_bersih', name: 'nominal_terima_bersih'},
        ],
        // columnDefs: [
        //     { className: 'text-center', targets: [4,5] },
        // ],
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_transaction_list_qris_pending_tenant span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_transaction_list_qris_pending_tenant').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_transaction_list_qris_pending_tenant span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_transaction.draw();
    });

    var table_user_transaction = $('.tenant-transaction-list-qris-pending').DataTable({
        processing: true,
        serverSide: true,
        // ajax: {
        //     "url": 'https://visipos.id/tenant/dashboard/transaction/list/pending-payment',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_transaction_list_qris_pending_tenant').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_transaction_list_qris_pending_tenant').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        ajax: {
            "url": 'http://localhost:8000/tenant/dashboard/transaction/list/pending-payment',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_transaction_list_qris_pending_tenant').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_transaction_list_qris_pending_tenant').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'kasir', name: 'kasir'},
            {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
            {data: 'tanggal_pembayaran', name: 'tanggal_pembayaran'},
            {data: 'jenis_pembayaran', name: 'jenis_pembayaran'},
            {data: 'status_pembayaran', name: 'status_pembayaran'},
            {data: 'transaksi_oleh', name: 'transaksi_oleh'},
            {data: 'status_transaksi', name: 'status_transaksi'},
            {data: 'sub_total', name: 'sub_total'},
            {data: 'pajak', name: 'pajak'},
            {data: 'diskon', name: 'diskon'},
            {data: 'nominal_bayar', name: 'nominal_bayar'},
            {data: 'mdr', name: 'mdr'},
            {data: 'nominal_mdr', name: 'nominal_mdr'},
            {data: 'nominal_terima_bersih', name: 'nominal_terima_bersih'},
        ],
        // columnDefs: [
        //     { className: 'text-center', targets: [4,5] },
        // ],
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_transaction_list_qris_finish_tenant span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_transaction_list_qris_finish_tenant').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_transaction_list_qris_finish_tenant span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_transaction.draw();
    });

    var table_user_transaction = $('.tenant-transaction-list-qris-finish').DataTable({
        processing: true,
        serverSide: true,
        // ajax: {
        //     "url": 'https://visipos.id/tenant/dashboard/pemasukan/qris',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_transaction_list_qris_finish_tenant').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_transaction_list_qris_finish_tenant').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        ajax: {
            "url": 'http://localhost:8000/tenant/dashboard/pemasukan/qris',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_transaction_list_qris_finish_tenant').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_transaction_list_qris_finish_tenant').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'nomor_invoice', name: 'nomor_invoice'},
            {data: 'kasir', name: 'kasir'},
            {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
            {data: 'tanggal_pembayaran', name: 'tanggal_pembayaran'},
            {data: 'jenis_pembayaran', name: 'jenis_pembayaran'},
            {data: 'status_pembayaran', name: 'status_pembayaran'},
            {data: 'transaksi_oleh', name: 'transaksi_oleh'},
            {data: 'status_transaksi', name: 'status_transaksi'},
            {data: 'sub_total', name: 'sub_total'},
            {data: 'pajak', name: 'pajak'},
            {data: 'diskon', name: 'diskon'},
            {data: 'nominal_bayar', name: 'nominal_bayar'},
            {data: 'mdr', name: 'mdr'},
            {data: 'nominal_mdr', name: 'nominal_mdr'},
            {data: 'nominal_terima_bersih', name: 'nominal_terima_bersih'},
        ],
        // columnDefs: [
        //     { className: 'text-center', targets: [4,5] },
        // ],
    });
});

$(function () {
    var start_date = moment().subtract(1, 'M');
    var end_date = moment();
    $('#daterange_settlement_tenant span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));
    $('#daterange_settlement_tenant').daterangepicker({
        startDate : start_date,
        endDate : end_date
    }, function(start_date, end_date){
        $('#daterange_settlement_tenant span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

        table_user_transaction.draw();
    });

    var table_user_transaction = $('.tenant-settlement-list').DataTable({
        processing: true,
        serverSide: true,
        // ajax: {
        //     "url": 'https://visipos.id/tenant/dashboard/finance/saldo/settlement',
        //     "type": "GET",
        //     data : function(data){
        //         data.from_date = $('#daterange_settlement_tenant').data('daterangepicker').startDate.format('YYYY-MM-DD');
        //         data.to_date = $('#daterange_settlement_tenant').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //     }
        // },
        ajax: {
            "url": 'http://localhost:8000/tenant/dashboard/finance/saldo/settlement',
            "type": "GET",
            data : function(data){
                data.from_date = $('#daterange_settlement_tenant').data('daterangepicker').startDate.format('YYYY-MM-DD');
                data.to_date = $('#daterange_settlement_tenant').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nomor_settlement', name: 'nomor_settlement'},
            {data: 'periode_settlement', name: 'periode_settlement'},
            {data: 'nominal_settlement', name: 'nominal_settlement'},
            {data: 'status', name: 'status'},
            {data: 'note', name: 'note'},
            {data: 'periode_transaksi', name: 'periode_transaksi'},
        ],
        // columnDefs: [
        //     { className: 'text-center', targets: [4,5] },
        // ],
    });
});

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
    $("#scroll-horizontal-datatable").DataTable({
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
    $("#pos").DataTable({
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        },
    });
    $('#pos_filter label input').on( 'focus', function () {
        this.setAttribute( 'id', 'search-input-table' );
    });
});
