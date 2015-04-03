<?php
/*
 * класс для загрузки списка категорий
 */
 class CtgsStore extends Store
{
    public function loadAll()
    {
        $result = $this->ads_db->select('SELECT '
                                       .'cat_id as ARRAY_KEY, category, parent_id as PARENT_KEY  '
                                       .'FROM `categories`');
        foreach ($result as $val) {
            foreach ($val['childNodes'] as $chkey => $chval) {
                $categories[$val['category']][$chkey] = $chval['category'];
            }
        }
        $this->store = $categories;
    }
}
