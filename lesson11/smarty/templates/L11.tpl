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
        {html_radios name="private" options=$radios selected=$adToReturn->private|default:'0'}
    </div> 
    <div> 
        <label>
            Ваше имя *
        </label>
        <input type="text" maxlength="20" value="{$adToReturn->seller_name|strip|escape:'htmlall':'utf-8'}" name="seller_name">
    </div>
    <div> 
        <label>Электронная почта *</label>
        <input type="text" maxlength="50" value="{$adToReturn->email|strip|escape:'htmlall':'utf-8'}" name="email">
        <div>
            <LABEL>Список Авторов&nbsp;<a href="?" title="Можете оставить поля 'Имя' и 'Электронная почта' пустыми и выбрать их из существующих">?</A></LABEL>
            <select  title="список авторов" name="saved_email"> 
                 <option value="0">&nbsp;</option>
                  {html_options options=$checkboxAuthors selected=$adToReturn->author_id} 
            </select>
        </div>  
    </div>
     
    <div class="allow_mails">
            {html_checkboxes name="allow_mails" values="1" output='Я не хочу получать вопросы по объявлению по e-mail' selected=$adToReturn->allow_mails  separator="<br />"}
    </div>
    <div> 
        <label>Номер телефона</label>
        <input type="text"  value="{$adToReturn->phone|strip|escape:'htmlall':'utf-8'}" name="phone">
    </div>
    <div> 
       <label >Город</label> 
       <select title="Выберите Ваш город" name="location_id"> 
            <option value="">-- Выберите город --</option>
            <option disabled="disabled">-- Города --</option>
        {html_options options=$cities selected=$adToReturn->location_id}
         </select>
    </div>
    <div> 
        <label>Категория</label> 
            <select name="category_id">
                <option value="">-- Выберите категорию --</option>
        {html_options options=$categories selected=$adToReturn->category_id}
            </select> 
    </div>
    <div>
        <label>Название объявления *</label> 
        <input type="text" maxlength="30" value="{$adToReturn->title|strip|escape:'htmlall':'utf-8'}" name="title">
    </div>
    <div> 
        <label>Описание объявления</label>
        <textarea maxlength="500" name="description" >{$adToReturn->description|strip|escape:'htmlall':'utf-8'}</textarea>
    </div>
    <div> 
        <label >Цена</label>
        <input type="text" maxlength="9"  value="{$adToReturn->price|default:'0'|strip|escape:'htmlall':'utf-8'}" name="price" >                                                         
    </div>
    <div> 
        <input type="hidden" value="{$adToReturn->return_id}" name="return_id" >
        <input class="submit_button" type="submit" value="Отправить" name="main_form_submit"  > </div>
    <div class='notice'>
        {if $notice}
        <LABEL>{$notice->getNotice()}</LABEL>
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
{if $ads}
    {foreach from=$ads key=key item=arr}
{assign var="authorId" value=$arr->getAuthor_id()}
        <tr>
            <td> |  <a href="?formreturn={$key}"> {$arr->getTitle()|escape:'htmlall':'utf-8'}</a></td>
            <td>  |  {$arr->getPrice()|escape:'htmlall':'utf-8'}</td>
            <td>  |  {$authors.$authorId->getName()|escape:'htmlall':'utf-8'}</td>
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
