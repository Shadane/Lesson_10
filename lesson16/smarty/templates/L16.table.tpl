 <script src="./javascript/table.js"></script> 
 
 
 
 
<div class="replacable" style="display: none">
            <LABEL class="col-sm-5 control-label" for="authors">Список Авторов&nbsp;<a href="?" title="Можете оставить поля 'Имя' и 'Электронная почта' пустыми и выбрать их из существующих">?</A></LABEL>
             <div class="col-sm-7">
            <select id="authors" class="form-control input-sm" title="список авторов" name="saved_email"> 
                 <option value="0">&nbsp;</option>
                  {html_options options=$checkboxAuthors} 
            </select>
             </div>
     </div> 

       
 
 
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


        <tr class="{$trColor} adlist">
            <td>{$arr->getTitle()|escape:'htmlall':'utf-8'}</td>
            <td>{$arr->getPrice()|escape:'htmlall':'utf-8'}$</td>
            <td>{$authors.$authorId->getSeller_name()|escape:'htmlall':'utf-8'}</td>
            <td><a class="edit btn btn-xs">Редактировать</a>&nbsp;&nbsp;<a class="delete btn btn-xs" id="{$key}">Удалить</a></td>
        </tr>
    {/foreach}
 {else}
 		<div class='notice'>
 			<label >No active ads at the moment</label>
 			</div>
 		
{/if}
   </TBODY>
  </TABLE>


