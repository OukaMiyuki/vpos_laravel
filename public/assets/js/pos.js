window.onload = function(e){ 
    var lama = 1000;
    t = null;
    window.print();
    // t = setTimeout("self.close()",lama);
    window.onafterprint = back;

    function back() {
        window.close();
    }
}