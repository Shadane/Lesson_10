<!DOCTYPE HTML>
<HTML>
   <HEAD>
      <TITLE>Lesson 15</TITLE>
    
          <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
{*      <link type="text/css" rel="stylesheet" href="./css/style.css" />*}
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

{*      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>*}
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
      
   </HEAD>
   <body>
       
       
       
       <div id="container"></div>
       
<form class="form-horizontal" method="post">
 <div class="container col-lg-5 col-md-8 col-sm-8 col-lg-offset-3 col-md-offset-1 col-sm-offset-1"> 
     
    <div class="form-group">
    <div class="col-sm-offset-5 col-sm-7 ">
      <div class="radio">

        {html_radios id="inlineRadio1" name="private" options=$radios selected=$adToReturn->private|default:'0'}
              </div>
       </div>
    </div>        
    <div class="form-group">
        <label for="seller_name" class="col-sm-5 control-label">Ваше имя *</label>
            <div class="col-sm-7">
            <input  type="text" class="form-control input-sm" id="seller_name" maxlength="20" value="{$auToReturn->seller_name|strip|escape:'htmlall':'utf-8'}" name="seller_name">
            </DIV>
    </div>
    <div class="form-group"> 
        <label class="col-sm-5 control-label" for="email">Электронная почта *</label>
        <div class="col-sm-7">
        <input class="form-control input-sm" id="email" type="email" maxlength="50" value="{$auToReturn->email|strip|escape:'htmlall':'utf-8'}" name="email">
        </div>
    </DIV>
        
    <div class="form-group">
            <LABEL class="col-sm-5 control-label" for="authors">Список Авторов&nbsp;<a href="?" title="Можете оставить поля 'Имя' и 'Электронная почта' пустыми и выбрать их из существующих">?</A></LABEL>
             <div class="col-sm-7">
            <select id="authors" class="form-control input-sm" title="список авторов" name="saved_email"> 
                 <option value="0">&nbsp;</option>
                  {html_options options=$checkboxAuthors selected=$adToReturn->author_id} 
            </select>
             </div>
    </div>  
    
     <div class="form-group">
        <div class="checkbox">
            <div class="col-sm-offset-5 col-sm-7">
            {html_checkboxes name="allow_mails" values="1" output='Я не хочу получать вопросы по объявлению по e-mail' selected=$adToReturn->allow_mails  separator="<br />"}
            </div>
        </div>
     </DIV>
        
    <div class="form-group"> 
        <label class="col-sm-5 control-label" for="phone">Номер телефона</label>
        <div class="col-sm-7">
        <input class="form-control input-sm" type="tel" id="phone"  value="{$adToReturn->phone|strip|escape:'htmlall':'utf-8'}" name="phone">
        </div>
    </div>
        
    <div class="form-group"> 
       <label  class="col-sm-5 control-label" for="city">Город</label> 
               <div class="col-sm-7">
       <select class="form-control input-sm" id="city" title="Выберите Ваш город" name="location_id"> 
            <option value="">-- Выберите город --</option>
            <option disabled="disabled">-- Города --</option>
        {html_options options=$cities selected=$adToReturn->location_id}
         </select>
         </div>
    </div>
         
    <div class="form-group"> 
        <label class="col-sm-5 control-label" for="ctgs">Категория</label> 
        <div class="col-sm-7">
            <select class="form-control input-sm" id="ctgs" name="category_id">
                <option value="">-- Выберите категорию --</option>
        {html_options options=$categories selected=$adToReturn->category_id}
            </select> 
        </div>
    </div>
            
    <div class="form-group">
        <label class="col-sm-5 control-label" for="title">Название объявления *</label> 
           <div class="col-sm-7">
        <input class="form-control input-sm" id="title" type="text" maxlength="30" value="{$adToReturn->title|strip|escape:'htmlall':'utf-8'}" name="title">
           </div>
    </div>
           
    <div class="form-group"> 
        <label  class="col-sm-5 control-label" for="description">Описание объявления</label>
         <div class="col-sm-7">
        <textarea class="form-control input-sm" maxlength="500" name="description" id="description">{$adToReturn->description|strip|escape:'htmlall':'utf-8'}</textarea>
         </div>
    </div>
         
    <div class="form-group"> 
        <label  class="col-sm-5 control-label" for="price">Цена</label>
         <div class="col-sm-7">
             <div class="input-group">
              <span class="input-group-addon">$</span>
        <input class="form-control input-sm" id="price" type="number" maxlength="9"  value="{$adToReturn->price|default:'0'|strip|escape:'htmlall':'utf-8'}" name="price" >
             </DIV>
         </div>
    </div>
             
    <div class="form-group"> 
        <input type="hidden" value="{$adToReturn->id}" name="id" >
        <div class="col-sm-offset-5 col-sm-7">
            <input class="submit_button btn btn-success btn-large"" type="submit" value="Отправить" name="main_form_submit"  > </DIV></div>
            
    <div class="form-group">
    <div class='notice'>
        {if $notice}
        <p class="col-sm-offset-5 col-sm-7 bg-warning">{$notice->getNotice()}</p>
        {/if}
    </div>
    </div>
 </DIV>
</form>
 

   <div class=" container col-lg-6 col-md-6 col-sm-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3">   

  <table class="table table-hover">
      <h2 class="sub-header text-center">Все объявления</h2>
      <THEAD>
           <tr>
               
                <th>Название объявления </td>
                <th>Цена </td>
                <th>Имя </td>
                <th>Действия</td>
           </tr>
      </THEAD>
      <tbody>
          
{if $ads}
    {foreach from=$ads key=key item=arr}
{assign var="authorId" value=$arr->getAuthor_id()}

{if is_a($arr, 'CompanyAds')}
{assign var="trColor" value="warning"}
{else}
{assign var="trColor" value=""}
{/if}


        <tr class="{$trColor}">
            <td>{$arr->getTitle()|escape:'htmlall':'utf-8'}</td>
            <td>{$arr->getPrice()|escape:'htmlall':'utf-8'}$</td>
            <td>{$authors.$authorId->getSeller_name()|escape:'htmlall':'utf-8'}</td>
            <td><a href="?formreturn={$key}">Редактировать</a>&nbsp;&nbsp;<a class="delete btn btn-xs" id="{$key}">Удалить</a></td>
        </tr>
    {/foreach}
 {else}
 		<div class='notice'>
 			<label >No active ads at the moment</label>
 			</div>
 		
{/if}
   </TBODY>
  </TABLE>
   </div>
      <script src="./javascript/ads.js"></script>
   </body>
</HTML>
