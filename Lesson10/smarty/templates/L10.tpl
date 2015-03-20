<!DOCTYPE HTML>
<HTML>
   <HEAD>
      <TITLE>Lesson 10</TITLE>
      <link type="text/css" rel="stylesheet" href="./css/style.css" />

   </HEAD>
   <body>
<form method="post">
    <div class="radios"> 
        {html_radios name="private" options=$radios selected=$showform_params.private}
    </div> 
    <div> 
        <label>
            Ваше имя *
        </label>
        <input type="text" maxlength="20" value="{$showform_params.seller_name|strip|escape:'htmlall':'utf-8'}" name="seller_name">
    </div>
    <div> 
        <label>Электронная почта *</label>
        <input type="text" maxlength="50" value="{$showform_params.email|strip|escape:'htmlall':'utf-8'}" name="email">
        <div>
            <LABEL>Список Авторов&nbsp;<a href="?" title="Можете оставить поля 'Имя' и 'Электронная почта' пустыми и выбрать их из существующих">?</A></LABEL>
            <select  title="список авторов" name="saved_email"> 
                 <option value="0"></option>
                  {html_options options=$emails} 
            </select>
        </div>  
    </div>
     
    <div class="allow_mails">
            {html_checkboxes name="allow_mails" values="1" output='Я не хочу получать вопросы по объявлению по e-mail' selected=$showform_params.allow_mails  separator="<br />"}
    </div>
    <div> 
        <label>Номер телефона</label>
        <input type="text"  value="{$showform_params.phone|strip|escape:'htmlall':'utf-8'}" name="phone">
    </div>
    <div> 
       <label >Город</label> 
       <select title="Выберите Ваш город" name="location_id"> 
            <option value="">-- Выберите город --</option>
            <option disabled="disabled">-- Города --</option>
        {html_options options=$cities selected=$showform_params.location_id}
         </select>
    </div>
    <div> 
        <label for="fld_category_id" class="form-label">Категория</label> 
            <select name="category_id">
                <option value="">-- Выберите категорию --</option>
        {html_options options=$categories selected=$showform_params.category_id}
            </select> 
    </div>
    <div>
        <label>Название объявления *</label> 
        <input type="text" maxlength="30" value="{$showform_params.title|strip|escape:'htmlall':'utf-8'}" name="title">
    </div>
    <div> 
        <label>Описание объявления</label>
        <textarea maxlength="500" name="description" >{$showform_params.description|strip|escape:'htmlall':'utf-8'}</textarea>
    </div>
    <div> 
        <label >Цена</label>
        <input type="text" maxlength="9"  value="{$showform_params.price|strip|escape:'htmlall':'utf-8'}" name="price" >                                                         
    </div>
    <div> 
        <input type="hidden" value="{$showform_params.return_id}" name="return_id" >
        <input class="submit_button" type="submit" value="Отправить" name="main_form_submit"  > </div>
    <div>
        
        <LABEL class='notice'>{$showform_params.notice_title_is_empty}</LABEL>
    </div>
</form>
    
  <table>
           <tr>
               
                <td> |  Название объявления </td>
                <td>  |  Цена </td>
                <td>  |  Имя </td>
                <td>  |  Удалить | </td>
           </tr>
         </div> 
{if $ads_container}
    {foreach from=$ads_container key=key item=arr}

        <tr>
            <td> |  <a href="?formreturn={$key}"> {$arr.title|escape:'htmlall':'utf-8'}</a></td>
            <td>  |  {$arr.price|escape:'htmlall':'utf-8'}</td>
            <td>  |  {$arr.seller_name|escape:'htmlall':'utf-8'}</td>
            <td>  |  <a href="?delentry={$key}">Удалить</a> |</td>
            </tr>  
           
    {/foreach}
{/if}
  </TABLE>
   </body>
</HTML>

