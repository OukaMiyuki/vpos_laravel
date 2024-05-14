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