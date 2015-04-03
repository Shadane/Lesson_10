<?php
/*
 * класс для загрузки списка городов
 */
 class CityStore extends Store
{
     public function loadAll()
    {
        $this->store = $this->ads_db->selectcol('SELECT '
                                               .'city_id as ARRAY_KEY, city_name '
                                               .'FROM `cities`');
    }
}
