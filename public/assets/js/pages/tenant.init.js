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


    // document.getElementById('enable_manual_batcode').onclick = function() {
    //     const barcode_txt = document.getElementById('barcode');
    //     if (barcode_txt.readOnly) {
    //         barcode_txt.readOnly = false;
    //         this.innerHTML = "Masukkan Barcode via Scanner";
    //         // console.log('✅ element is read-only');
    //     } else {
    //         // console.log('⛔️ element is not read-only');
    //         this.innerHTML = "Input Barcode Manual";
    //         barcode_txt.value = "";
    //         barcode_txt.readOnly = true;
    //     }
    //     // document.getElementById('myInput').readOnly = false;
    // };

    // var barcode = "";
    // var interval = "";

    // document.addEventListener('keydown', function(evt){
    //     if(interval)
    //         clearInterval(interval);
    //     if(evt.code == "Enter") {
    //         if(barcode)
    //             handleBarcode(barcode);
    //         barcode = '';
    //         return;
    //     }
    //     if(evt.key != 'Shift')
    //         barcode += evt.key;
    //     interval = setInterval( ()=> barcode = '', 20 );
    // });

    // function handleBarcode(scanned_barcode){
    //     console.log(scanned_barcode);
    // }

});

// Author: Neel Bhanushali <neal.bhanushali@gmail.com>
document.addEventListener('keydown', function(e) {
    // add scan property to window if it does not exist
    if(!window.hasOwnProperty('scan')) {
        window.scan = []
    }
    
    // if key stroke appears after 10 ms, empty scan array
    if(window.scan.length > 0 && (e.timeStamp - window.scan.slice(-1)[0].timeStamp) > 10) {
        window.scan = []
    }
    
    // if key store is enter and scan array contains keystrokes
    // dispatch `scanComplete` with keystrokes in detail property
    // empty scan array after dispatching event
    if(e.key === "Enter" && window.scan.length > 0) {
        let scannedString = window.scan.reduce(function(scannedString, entry) {
            return scannedString + entry.key
        }, "")
        window.scan = []
        return document.dispatchEvent(new CustomEvent('scanComplete', {detail: scannedString}))
    }
    
    // do not listen to shift event, since key for next keystroke already contains a capital letter
    // or to be specific the letter that appears when that key is pressed with shift key
    if(e.key !== "Shift") {
        // push `key`, `timeStamp` and calculated `timeStampDiff` to scan array
        let data = JSON.parse(JSON.stringify(e, ['key', 'timeStamp']))
        data.timeStampDiff = window.scan.length > 0 ? data.timeStamp - window.scan.slice(-1)[0].timeStamp : 0;

        window.scan.push(data)
    }
})
// listen to `scanComplete` event on document
document.addEventListener('scanComplete', function(e) { console.log(e.detail) })