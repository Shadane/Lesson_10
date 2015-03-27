<!DOCTYPE HTML>
<HTML>
   <HEAD>
      <TITLE>Lesson 11</TITLE>
      <meta charset="utf-8">
      <link type="text/css" rel="stylesheet" href="./css/style.css" />

   </HEAD>
   <body>
<form method="post">
    <div class="radios"> 
        {html_radios name="private" options=$radios selected=$ads->showform.private}
    </div> 
    <div> 
        <label>
            Ваше имя *
        </label>
        <input type="text" maxlength="20" value="{$ads->showform.seller_name|strip|escape:'htmlall':'utf-8'}" name="seller_name">
    </div>
    <div> 
        <label>Электронная почта *</label>
        <input type="text" maxlength="50" value="{$ads->showform.email|strip|escape:'htmlall':'utf-8'}" name="email">
        <div>
            <LABEL>Список Авторов&nbsp;<a href="?" title="Можете оставить поля 'Имя' и 'Электронная почта' пустыми и выбрать их из существующих">?</A></LABEL>
            <select  title="список авторов" name="saved_email"> 
                 <option value="0">&nbsp;</option>
                  {html_options options=$authors->authorsToShow selected=$ads->showform.author_id} 
            </select>
        </div>  
    </div>
     
    <div class="allow_mails">
            {html_checkboxes name="allow_mails" values="1" output='Я не хочу получать вопросы по объявлению по e-mail' selected=$ads->showform.allow_mails  separator="<br />"}
    </div>
    <div> 
        <label>Номер телефона</label>
        <input type="text"  value="{$ads->showform.phone|strip|escape:'htmlall':'utf-8'}" name="phone">
    </div>
    <div> 
       <label >Город</label> 
       <select title="Выберите Ваш город" name="location_id"> 
            <option value="">-- Выберите город --</option>
            <option disabled="disabled">-- Города --</option>
        {html_options options=$cities->cities selected=$ads->showform.location_id}
         </select>
    </div>
    <div> 
        <label>Категория</label> 
            <select name="category_id">
                <option value="">-- Выберите категорию --</option>
        {html_options options=$categories->categories selected=$ads->showform.category_id}
            </select> 
    </div>
    <div>
        <label>Название объявления *</label> 
        <input type="text" maxlength="30" value="{$ads->showform.title|strip|escape:'htmlall':'utf-8'}" name="title">
    </div>
    <div> 
        <label>Описание объявления</label>
        <textarea maxlength="500" name="description" >{$ads->showform.description|strip|escape:'htmlall':'utf-8'}</textarea>
    </div>
    <div> 
        <label >Цена</label>
        <input type="text" maxlength="9"  value="{$ads->showform.price|strip|escape:'htmlall':'utf-8'}" name="price" >                                                         
    </div>
    <div> 
        <input type="hidden" value="{$ads->showform.return_id}" name="return_id" >
        <input class="submit_button" type="submit" value="Отправить" name="main_form_submit"  > </div>
    <div class='notice'>
        {if $ads->showform.notice_field}
        <LABEL>{$ads->showform.notice_field}</LABEL>
        {/if}
    </div>
</form>
    
  <table>
           <tr>
               
                <td> |  Название объявления </td>
                <td>  |  Цена </td>
                <td>  |  Имя </td>
                <td>  |  Удалить | </td>
           </tr>
{if $adstable->ads}
    {foreach from=$adstable->ads key=key item=arr}

        <tr>
            <td> |  <a href="?formreturn={$key}"> {$arr->title|escape:'htmlall':'utf-8'}</a></td>
            <td>  |  {$arr->price|escape:'htmlall':'utf-8'}</td>
            <td>  |  {$arr->seller_name|escape:'htmlall':'utf-8'}</td>
            <td>  |  <a href="?delentry={$key}">Удалить</a> |</td>
            </tr>  
           
    {/foreach}
 {else}
 		</TABLE>
 		<div class='notice'>
 			<label >No active ads at the moment</label>
 			</div>
 		
{/if}
  </TABLE>
   </body>
</HTML>

