onScan.attachTo(document, {
    suffixKeyCodes: [13], // enter-key expected at the end of a scan
    reactToPaste: true, // Compatibility to built-in scanners in paste-mode (as opposed to keyboard-mode)
    onScan: function(sCode, iQty) { // Alternative to document.addEventListener('scan')
        //alert('Scanned: ' + iQty + 'x ' + sCode);
        // let barcode = document.getElementById("barcode");
        $("#nominal").val(sCode);
        $('#pos').DataTable().search(sCode).draw();
        var theTbl = document.getElementById('pos');
        var Cells = theTbl.getElementsByTagName("td");
        console.log(Cells[2].innerText);
        if(Cells[2].innerText == sCode){
            if(Cells[6].innerText != "Pack" && Cells[6].innerText != "Custom"){
                document.getElementById('cartForm').submit();
            }

            if(Cells[6].innerText == "Pack" || Cells[6].innerText == "Custom"){
                if(Cells[6].innerText == "Custom"){
                    const id_invoice = $('#add_custom_product').attr('data-id_invoice');
                    const id = $('#add_custom_product').attr('data-id');
                    const barcode = $('#add_custom_product').attr('data-barcode');
                    const pd_name = $('#add_custom_product').attr('data-pd_name');
                    const t_barang = $('#add_custom_product').attr('data-tipe_barang');  
                    $("#show #id_id_invoice").val(id_invoice);  
                    $("#show #id_id").val(id);
                    $("#show #barcode_barcode").val(barcode);
                    $("#show #name_name").val(pd_name);
                    $("#show #tipe_tipe").val(t_barang);
                    $('#modalAddCustomProduct').modal('show'); 
                    $('#modalAddPackProduct').modal('hide');
                }
                if(Cells[6].innerText == "Pack"){
                    const id_invoice_pack = $('#add_pack_product').attr('data-id_invoice_pack');  
                    const id_pack = $('#add_pack_product').attr('data-id_pack');
                    const barcode_pack = $('#add_pack_product').attr('data-barcode_pack');
                    const pd_name_pack = $('#add_pack_product').attr('data-pd_name_pack');
                    const t_barang_pack = $('#add_pack_product').attr('data-tipe_barang_pack');
                    const t_price_pack = $('#add_pack_product').attr('data-price_pack');
                    const t_satuan_unit_pack = $('#add_pack_product').attr('data-satuan_unit_pack');
                    let satuan_text = "Satuan Barang : "+t_satuan_unit_pack;
                    $("#show_pack #id_id_id").val(id_pack);
                    $("#show_pack #id_id_id_invoice").val(id_invoice_pack);
                    $("#show_pack #barcode_barcode_barcode").val(barcode_pack);
                    $("#show_pack #name_name_name").val(pd_name_pack);
                    $("#show_pack #tipe_tipe_tipe").val(t_barang_pack);
                    $("#show_pack #price_price").val(t_price_pack);
                    $("#show_pack #satuan_unit_barang").text(satuan_text);
                    $('#modalAddCustomProduct').modal('hide');
                    $('#modalAddPackProduct').modal('show'); 
                }
            }
            // document.getElementById('cartForm').submit();
        }
        // barcode.value = sCode;
    },
    onKeyDetect: function(iKeyCode){ // output all potentially relevant key events - great for debugging!
        console.log('Pressed: ' + iKeyCode);
    }
});

$(document).ready(function(){
    $(document).on("click", "#add_custom_product", function() {
        var id_invoice = $(this).data('id_invoice');
        var id = $(this).data('id');
        var barcode = $(this).data('barcode');
        var pd_name = $(this).data('pd_name');
        var t_barang = $(this).data('tipe_barang');
        $("#show #id_id_invoice").val(id_invoice);
        $("#show #id_id").val(id);
        $("#show #barcode_barcode").val(barcode);
        $("#show #name_name").val(pd_name);
        $("#show #tipe_tipe").val(t_barang);
    });

    $(document).on("click", "#add_pack_product", function() {
        var id_invoice = $(this).data('id_invoice_pack');
        var id = $(this).data('id_pack');
        var barcode = $(this).data('barcode_pack');
        var pd_name = $(this).data('pd_name_pack');
        var t_barang = $(this).data('tipe_barang_pack');
        var t_price_pack = $(this).data('price_pack');
        var t_satuan_unit = $(this).data('satuan_unit_pack');
        let satuan_text = "Satuan Barang : "+t_satuan_unit;
        $("#show_pack #id_id_id").val(id);
        $("#show_pack #id_id_id_invoice").val(id_invoice);
        $("#show_pack #barcode_barcode_barcode").val(barcode);
        $("#show_pack #name_name_name").val(pd_name);
        $("#show_pack #tipe_tipe_tipe").val(t_barang);
        $("#show_pack #price_price").val(t_price_pack);
        $("#show_pack #satuan_unit_barang").text(satuan_text);
    });
});