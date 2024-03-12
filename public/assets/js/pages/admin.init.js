$(document).ready(function(){
    // var form = document.getElementById("logout-form");

    // document.getElementById("#logout").addEventListener("click", function () {
    //   form.submit();
    // });

    $('#image').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });
});