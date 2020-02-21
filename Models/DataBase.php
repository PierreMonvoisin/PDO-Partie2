<?php
require_once '../params.php';
/**
 * Description of DataBase
 *
 * @author s albrecht
 */
class DataBase {
   public $db;
   protected static $instance = null;
   public function __construct(){
   }
   public static function getInstance(){
     if (is_null(self::$instance)){
       $dsn = 'mysql:dbname='. DB. ';host='. HOST. ';charset=UTF8';
       try {
         self::$instance = new PDO($dsn, USER, PASS, ['PDO::ATTR_ERRMODE'=> 'PDO::ERRMODE_EXCEPTION']);
       } catch (Exception $ex) {
         die('La connexion à la bdd a échoué !');
       }
     }
     return self::$instance;
   }
}

