$(document).ready(function(){

    $("#custom-form").hide();
    $("#custom").change(function() {
        if ($(this).val() == 'checked') {
            $('#custom-form').show();
            $('.form1').hide();
        }});
    $(function (){
        $( "#datepicker" ).datepicker({
            numberOfMonths: 2,
            showButtonPanel: true,
            dateFormat: 'yy-mm-dd'
        })});
});







