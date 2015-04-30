/*
 * объявляем функцию подгрузки динамического контента на страницу(таблицы)
 */

function userfuncAppendToTable(smartyResp) {
    $('div.container_ads').html(smartyResp);
}
/*
 * объявляем функцию резета формы
 */
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
        else if (type == 'hidden')
            this.value = '';
    });
};

$.fn.appendToAlert = function (msg, alertClass, delay)
{
    /*
     * удаляем из queue, затем прячем контейнер с мессаджем, затем записываем туда новый мессадж,
     * затем меняем у него класс на нужный, затем показываем его, затем если указан delay, то контейнер исчезнет через указанное время
     */
    this.stop(true);
    this.hide();
    this.find('div').html(msg);
    this.removeClass('alert-info alert-warning alert-danger').addClass('alert-' + alertClass).fadeIn('slow');

    if (delay != undefined) {
        this.delay(delay).fadeOut();
    }
};





$(function () {
    /*
     * очищаем форму
     */
    $('form#adsform').clearForm();

    /* 
     * выставляем настройки аякса
     */

    $.ajaxSetup({
        timeout: 5000,
        datatype: 'json'
    });
    /* 
     * запрашиваем таблицу
     */
    $.ajax({
        type: 'POST',
        url: 'buttonLogic.php',
        success: function (response) {
            var resp = $.parseJSON(response);
            userfuncAppendToTable(resp.smarty);
        },
        error: function (response) {
            console.log(response);
        }
    });
    /* 
     * при нажатии на Отправить(или энтер на клавиатуре)
     */
    $('form#adsform').submit(function () {
        /*
         * если необходимые поля не заполнены, то выводим сообщение и останавливаем Submit
         */
        if (!($('.requiredTitle').val() && ($('.requiredName').val() && $('.requiredEmail').val()) || $('.requiredAuthor').val() > 0)) {
            $('div.alert:has(#container_warning)').appendToAlert('Введите обязательные поля', 'danger', 2500);
            return false;
        }
        /*
         * сериализуем форму для отправки
         */
        var form = $('#adsform').serialize();
        $.ajax({
            type: 'POST',
            url: 'buttonLogic.php',
            data: form,
            success: function (response) {
                /*
                 * парсим ответ страницы
                 */
                var resp = $.parseJSON(response);
                /*
                 * очищаем форму
                 */
                $('form#adsform').clearForm();
                /*
                 * загружаем данные от smarty->fetch в контейнер
                 */
                userfuncAppendToTable(resp.smarty);
                /*
                 * выводим сообщение
                 */
                $('div.alert:has(#container_warning)').appendToAlert(resp.submit, 'info');
            }
        });
        return false;
    });
});

