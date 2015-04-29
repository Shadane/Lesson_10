function loadAdsTable() {
    $('div.container_ads').load('adsTable.php');
}



$(function () {
    
    $.fn.clearForm = function () {
        return this.each(function () {
            var type = this.type, tag = this.tagName.toLowerCase();
            if (tag == 'form')
                return $(':input', this).clearForm();
            if (type == 'text' || type == 'password' || type == 'number' || type == 'email' || type == 'tel' || tag == 'textarea')
                this.value = '';
            else if (type == 'checkbox')
                this.checked = false;
            else if (tag == 'select')
                this.selectedIndex = 0;
            else if (type == 'radio')
                 $('input#inlineRadio1').prop('checked', false).filter('[value=0]').prop('checked', true);
        });
    };
$('form#adsform').clearForm();

    loadAdsTable();


    $.ajaxSetup({
        timeout: 5000,
        datatype: 'json'
    });


    




    $('form#adsform').submit(function () {
        var form = $('#adsform').serialize();
        console.log(form);
        $.ajax({
            type: 'POST',
            url: 'buttonLogic.php',
            data: form,
            success: function (response) {

                loadAdsTable();
                var resp = $.parseJSON(response);
                $('input#id').attr('value', "");
                $('form#adsform').clearForm();
                
                $('#container_warning').html(resp);
            $('div.alert:has(#container_warning)').removeClass('alert-info alert-warning alert-danger').addClass('alert-success').fadeIn('slow');
            }
        });

        return false;
    });




});

