$(function () {
/*
 * у нас есть селектор с авторами, он загружается вместе с таблицей,
 * а таблица у нас во втором фрейме. Поэтому я создал два контейнера - 
 * acceptable - посередине основной формы, replacable - контейнер второго фрейма.
 *  содержит селекторы, подгружаемые вместе с таблицей. сначала мы
 *  уничтожаем сожержимое контейнера формы, а потом после загрузки 
 *  таблицы перемещаем контейнер в форму. Получаем в итоге динамический контейнер посреди статической формы.
 */
$('.acceptable').empty();  
$('.replacable').appendTo('.acceptable').show();

        /*
         * при нажатии на удалить в таблице.
         */
$('a.delete').click(function () {
        $(this).attr('disabled', 'disabled');
        var data = {'delentry': $(this).attr('id')};
        var tr = $(this).closest('tr');


        $.getJSON('buttonLogic.php?', data, function (response) {
            if (response.status == 'success') {
                tr.fadeOut('slow', function () {
                    $(this).remove();
                    if (!$('table tbody tr').is('.adlist')) {
                        $('#container_warning').html('Больше нет объявлений!');
                        $('div.alert:has(#container_warning)').removeClass('alert-info alert-warning alert-danger').addClass('alert-warning').fadeIn('slow');
                        $('form#adsform').clearForm();
                    }
                })
                var alert = 'info';
            } else if (response.status == 'error') {
                var alert = 'danger';
                tr.find('a.delete').attr('disabled', false);
            }
            $('#container_delete').html(response.message);
            $('div.alert:has(#container_delete)').removeClass('alert-info alert-warning alert-danger').addClass('alert-' + alert).fadeIn('slow').delay(800).fadeOut(1000);
        });

    });
    

            /*
             * при нажатии на редактировать в таблице
             */
    
$('a.edit').click(function () {
        
        var tr = $(this).closest('tr');
        var editid = {'formreturn': tr.find('a.delete').attr('id')};
        $('form#adsform').clearForm();
  $.ajax({
    type: 'GET',
    url: 'buttonLogic.php',
    data: editid,
    success: function(response){
      
      var resp = $.parseJSON(response);
      $('input#seller_name').prop('value', resp.seller_name);
      $('input#inlineRadio1').prop('checked', false).filter('[value='+resp.private+']').prop('checked', true);
      $('input#email').prop('value', resp.email);
      $('input#phone').prop('value', resp.phone);
      $('input#title').prop('value', resp.title);
      $('textarea#description').val(resp.description);
      $('input#price').prop('value', resp.price);
      $('input#id').prop('value', resp.id);
      $('select#authors').val(resp.author_id);
      $('select#city').val(resp.location_id);
      $('select#ctgs').val(resp.category_id);
      if(resp.allow_mails){
          $('input#allow_mails').prop('checked', true);
      }else
          $('input#allow_mails').prop('checked', false);
    },
    error: function(){
        $('#container_warning').html('Ошибка редактирования объявления #'+editid.formreturn);
        $('div.alert:has(#container_warning)').removeClass('alert-info alert-warning alert-danger').addClass('alert-danger').fadeIn('slow');
    },
    complete: function(){
        $('#container_warning').html('Редактируем объявление #'+editid.formreturn);
        $('div.alert:has(#container_warning)').removeClass('alert-info alert-warning alert-danger').addClass('alert-success').fadeIn('slow');
    }
      
    
    
  });
  
  
});

});


