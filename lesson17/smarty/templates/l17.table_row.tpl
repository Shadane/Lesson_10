{if is_a($ad, 'CompanyAds')}
{assign var="trColor" value="warning"}
{else}
{assign var="trColor" value=""}
{/if}

        <tr class="{$trColor} adlist">
            <td>{$ad->getTitle()|escape:'htmlall':'utf-8'}</td>
            <td>{$ad->getPrice()|escape:'htmlall':'utf-8'}$</td>
            <td id="{$authorId}">{$auName|escape:'htmlall':'utf-8'}</td>
            <td><a class="edit btn btn-xs">Редактировать</a>&nbsp;&nbsp;<a class="delete btn btn-xs" id="{$ad->getId()}">Удалить</a></td>
        </tr>

