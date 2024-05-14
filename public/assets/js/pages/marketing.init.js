$(document).ready(function(){
    $('#image').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage').attr('src', e.target.result);
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
});