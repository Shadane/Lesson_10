
/*
 * функция для появляющихся закрываемых контейнеров с информацией.
 */
$.fn.appendToAlert = function (msg, alertClass, delay)
{
    /*
     * удаляем из queue, затем прячем контейнер с мессаджем, затем записываем туда новый мессадж,
     * затем меняем у него класс на нужный, затем показываем его, затем если указан delay, то контейнер исчезнет через указанное время
     */
    this.stop(true).hide();
    this.find('div').html(msg);
    this.removeClass('alert-info alert-warning alert-danger').addClass('alert-' + alertClass).fadeIn('slow');

    if (delay != undefined) {
        this.delay(delay).fadeOut();
    }
};

        /*
         * Функция, запускаемая при success в ajaxform.
         */
function showResponse(response){
            //блок автора
            
            /*
             * реагируем на респонсы от автора
             */
             if (response.author.status == 'new')
            {
                msgAu = 'Новый автор сохранен';
                msgAuClass='success';
                        /*
                         * в выпадающий список добавляем Нового автора
                         */
                $('ul.appendAuthors').append(response.author.menuItem);
            }
             else if(response.author.status == 'edit')
            {
                msgAu = 'Имя автора отредактировано';
                msgAuClass='success';
                        /*
                         * в выпадающем списке ищем по мылу нужную строку и заменяем ее отредактированным автором
                         */
                $('ul.appendAuthors>li:has(a[data-email="'+response.author.email+'"])').replaceWith(response.author.menuItem);
                
                /*
                 * У нас отредактировалось имя автора, поэтому нам нужно заменить
                 * его и во всех объявлениях в таблице. Для этого в каждой строке 
                 * в колоке с именем автора есть id, по нему это и делается.
                 */
                $('td[id="'+response.author.id+'"]').html(response.author.name);
            }
             
             else if(response.author.status == 'not edited')
            {
                msgAu = 'Автор не был перезаписан';
                msgAuClass='success';
            }
            else
            {
                msgAu = 'Ошибка базы данных';
                msgAuClass='danger';
            }
            
    //блок объявления
    if (response.submit=='new'){
                /*
                 * добавляем объявление
                 */
        $('table>tbody').append(response.smarty);
        msgAd = 'Объявление успешно сохранено';
        msgAdClass = 'info';
        
    }else if(response.submit=='edit'){
                /*
                 * при редактировании объявлении если мы нажимаем ОТПРАВИТЬ,
                 * то вынимается значение из скрытого поля и заменяется строка с таким ID
                 */
        id = $(':hidden#id').val();
        $('table>tbody>tr:has(td>a[id='+id+'])').replaceWith(response.smarty);
        
        msgAd = 'Объявление успешно отредактировано';
        msgAdClass = 'info';
    }else if(response.submit=='not edited'){
        /*
         * это происходит когда мы сохраняем в точности те же поля какие записаны в БД, т.е не меняем объявление.
         */
        msgAd = 'Объявление не было изменено';
        msgAdClass = 'info';
    }else {
        msgAd = 'Ошибка сохранения в БД';
        msgAdClass = 'info';
            
    }
            /*
             * это моя кастомная функция, с помощью нее показываем инфоблоки.
             */    
    $('div.alert:has(#container_warning)').appendToAlert(msgAd, msgAdClass);
    $('div.alert:has(#container_delete)').appendToAlert(msgAu, msgAuClass, '3000');
            /*
             * резет формы я вынес сюда отдельно, не стал его ставить в опциях,
             * т.к он срабатывает ДО SUCCESS, а в success я использую значение из hidden поля
             */
    $('form').resetForm();
};


$(function () {
    
    /*
     * ради интереса сделал такой глобальный эвент на аякс.
     * Изначально Список Авторов у нас hide, но после аякс запросов он
     * проверяет есть ли что-то внутри списка авторов, и если есть,
     * то отображает dropdown меню.
     */
    $(document).ajaxComplete(function () {
        if ($('ul.dropdown-menu>li').length > 0) {
            $('div.dropdown').show();
        }
        else
        {
            $('div.dropdown').hide();
        }


    });
    
    
    
    
    
    
            /*
             * опции для аякс формы
             */
    var options = {
        target: '#container_warning', // target element(s) to be updated with server response 
//        beforeSubmit:  beforeSubmit,  // pre-submit callback 
        success: showResponse, // post-submit callback 

        // other available options: 
        url: 'l17.php', // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        dataType: 'json', // 'xml', 'script', or 'json' (expected server response type) 
//        clearForm: true ,       // clear all form fields after successful submit 
//        resetForm: true     // reset the form after successful submit 

        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    };

    // bind form using 'ajaxForm' 
    $('form#adsform').ajaxForm(options);
    /*
     * очищаем форму.
     */
    $('form#adsform').resetForm();




/*
 * листенер нажатия на выпавший список авторов
 * Функция заполняет два поля формы.
 */
    $(document).on('click', 'a.authorMenu', function () {
        $('input#seller_name').val($(this).attr('data-name'));
        $('input#email').val($(this).attr('data-email'));
    });

        /*
         * листенер нажатия на Удалить.
         */
    $(document).on('click', 'a.delete', function () {
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


        $.getJSON('l17.php', data, function (response) {
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
                        $('form#adsform').resetForm();
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
            /*
             * выводим закрываемый инфодив
             */
            $('div.alert:has(#container_delete)').appendToAlert(response.delete.message, alert);

        });

    });


    /*
     * Listener: при нажатии на редактировать в таблице
     */

    $(document).on('click', 'a.edit', function () {
        /*
         * запиываем в переменную текущую строку и находим айди на возвращение объявления.
         * затем резетаем форму и запускаем аякс запрос.
         */
        var tr = $(this).closest('tr');
        var editid = {'formreturn': tr.find('a.delete').attr('id')};
        /*
         * резет формы во избежание недоразумений, когда мы возвращаем несколько объявлений не сохраняя их.
         */
            $('form').resetForm();
        $.ajax({
            type: 'GET',
            url: 'l17.php',
            data: editid,
            success: function (response) {
                /*
                 * парсим полученный ответ, записываем в переменную editInfo ту часть ответа,
                 * которая отвечает за вывод информации в форму, и заполняем форму
                 */
                var resp = $.parseJSON(response);
                editInfo = resp.edit;
                $('input#seller_name').val(editInfo.seller_name);
                $('input#inlineRadio1').prop('checked', false).filter('[value=' + editInfo.private + ']').prop('checked', true);
                $('input#email').val(editInfo.email);
                $('input#phone').val(editInfo.phone);
                $('input#title').val(editInfo.title);
                $('textarea#description').val(editInfo.description);
                $('input#price').val(editInfo.price);
                $('input#id').val(editInfo.id);
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

