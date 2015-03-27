<?php 
class db_container{
    protected $ads_db;
       /**
     * Статическая переменная, в которой мы
     * будем хранить экземпляр класса
     */
    protected static $_instance;
    
    
    
    private function config(){
    require_once './config.php';
    if (!isset($config_arr)){
        die ('No userdata, try checking config.php');
    }
    return $config_arr;
    }

    /**
     * Закрываем доступ к функции вне класса.
     * Паттерн Singleton не допускает вызов
     * этой функции вне класса
     *
     */
    private function __construct(){
        /**
         * При этом в функцию можно вписать
         * свой код инициализации. Также можно
         * использовать деструктор класса.
         * Эти функции работают по прежднему,
         * только не доступны вне класса
         */
        $config_arr = $this->config();
        $this->ads_db = DBSimple_Generic::connect("mysql://".$config_arr['user_name'].":".$config_arr['password']."@".$config_arr['server_name']."/".$config_arr['database']."");
        if (!is_object($this->ads_db)){ die('CONNECTION PROBLEM'); }
        $this->ads_db->setErrorHandler('databaseErrorHandler');
        $this->ads_db->setLogger('myLogger');
    }
 
    /**
     * Закрываем доступ к функции вне класса.
     * Паттерн Singleton не допускает вызов
     * этой функции вне класса
     *
     */
    /**
     * Статическая функция, которая возвращает
     * экземпляр класса или создает новый при
     * необходимости
     *
     * @return SingletonTest
     */
    public static function getInstance() {
        
        // проверяем актуальность экземпляра
        if (null === self::$_instance) {
            // создаем новый экземпляр
            self::$_instance = new self();
        }
        // возвращаем созданный или существующий экземпляр
        return self::$_instance->ads_db;
    }
        // возвращаем созданный или существующий экземпляр

    
}
    