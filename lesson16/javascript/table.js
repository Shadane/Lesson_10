$(function () {
    /*
     * у нас есть селектор с авторами, он загружается вместе с таблицей,
     * а таблица у нас во втором фрейме. Поэтому я создал два контейнера - 
     * acceptable - посередине основной формы, replacable - контейнер второго фрейма.
     *  содержит селекторы, подгружаемые вместе с таблицей. сначала мы
     *  уничтожаем сожержимое контейнера формы, а потом после загрузки 
     *  таблицы перемещаем контейнер в форму. Получаем в итоге динамический контейнер посреди статической формы.
     */
    $('.acceptable > div > select').find('option:gt(0)').remove();
    $('.acceptable > div > select > option:first').after($('.replacable').contents());

    /*
     * при нажатии на удалить в таблице.
     */
    $('a.delete').click(function () {
        /*
         * дизейблим кнопку Удалить
         */
        $(this).attr('disabled', 'disabled');
                /*
                 * записываем массив для посыла,
                 * находим текущую строку
                 */
        var data = {'delentry': $(this).attr('id')};
        var tr = $(this).closest('tr');


        $.getJSON('buttonLogic.php?', data, function (response) {
            if (response.delete.status == 'success') {
                        /*
                         * если от сервера приходит ответ Success, то удаляем текущую строку,
                         * затем проверяем есть ли еще строки в таблице,
                         * если нет, то выводим сообщение, что объявлений больше нет ,
                         * резетаем форму и выставляем переменную с классом выводимого сообщение на info
                         */
                tr.fadeOut('slow', function () {
                    $(this).remove();
                    if (!$('table tbody tr').is('.adlist')) {

                        $('div.alert:has(#container_warning)').appendToAlert('Больше нет объявлений!', 'warning');
                        $('form#adsform').clearForm();
                    }
                })
                var alert = 'info';
                /*
                 * если пришел ответ с ошибкой, то выставляем класс Danger, и энейблим кнопку удаления.
                 */
            } else if (response.delete.status == 'error') {
                var alert = 'danger';
                tr.find('a.delete').attr('disabled', false);
            }
                    
            $('div.alert:has(#container_delete)').appendToAlert(response.delete.message, alert);

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
            success: function (response) {

                var resp = $.parseJSON(response);
                editInfo = resp.edit;
                $('input#seller_name').prop('value', editInfo.seller_name);
                $('input#inlineRadio1').prop('checked', false).filter('[value=' + editInfo.private + ']').prop('checked', true);
                $('input#email').prop('value', editInfo.email);
                $('input#phone').prop('value', editInfo.phone);
                $('input#title').prop('value', editInfo.title);
                $('textarea#description').val(editInfo.description);
                $('input#price').prop('value', editInfo.price);
                $('input#id').prop('value', editInfo.id);
                $('select#authors').val(editInfo.author_id);
                $('select#city').val(editInfo.location_id);
                $('select#ctgs').val(editInfo.category_id);
                if (editInfo.allow_mails) {
                    $('input#allow_mails').prop('checked', true);
                } else {
                    $('input#allow_mails').prop('checked', false);
                }

            },
            error: function () {
                $('div.alert:has(#container_warning)').appendToAlert('Ошибка редактирования объявления #' + editid.formreturn, 'danger');

            },
            complete: function () {
                $('div.alert:has(#container_warning)').appendToAlert('Редактируем объявление #' + editid.formreturn, 'success');
            }



        });


    });

});


