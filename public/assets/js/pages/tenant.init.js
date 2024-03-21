$(document).ready(function(){
    $('#image').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
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

onScan.attachTo(document, {
    suffixKeyCodes: [13], // enter-key expected at the end of a scan
    reactToPaste: true, // Compatibility to built-in scanners in paste-mode (as opposed to keyboard-mode)
    onScan: function(sCode, iQty) { // Alternative to document.addEventListener('scan')
        alert('Scanned: ' + iQty + 'x ' + sCode);
        let barcode = document.getElementById("barcode");
        // $("#nominal").val(sCode);
        // $('#pos').DataTable().search(sCode).draw();
        // var theTbl = document.getElementById('pos');
        // var Cells = theTbl.getElementsByTagName("td");
        // console.log(Cells[2].innerText);
        // if(Cells[2].innerText == sCode){
        //     document.getElementById('cartForm').submit();
        // }
        barcode.value = sCode;
    },
    onKeyDetect: function(iKeyCode){ // output all potentially relevant key events - great for debugging!
        console.log('Pressed: ' + iKeyCode);
    }
});