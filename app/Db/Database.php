<?php
 
namespace App\Db;
use \PDO;
use \PDOException;
 
class Database
{
    private static $host;
    private static $name;
    private static $user;
    private static $pass;
    private static $port;

    private $table;
    private $connection;
 
    public function __construct($table=null){
        $this->table = $table;
        $this->setConnection();
    }
    public static function config($host,$name,$user,$pass){


        self::$host = $host;
        self::$name = $name;
        self::$user = $user;
        self::$pass = $pass;
        self::$port = 3306;
       
    }
    

    private function setConnection(){
        try{
            $this->connection = new PDO('mysql:host='.self::$host.';dbname='.self::$name.';port='.self::$port,self::$user,self::$pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die('ERROR: ' .$e->getMessage());
        }
    }

    public function insert($values){
        $fields = array_keys($values);
        $binds = array_pad([], count($fields),'?');
        $query = ' INSERT INTO ' .$this->table. '(' .implode(',', $fields).') VALUES ('.implode(',', $binds). ')';
        $this->execute($query, array_values($values)); //Executa uma query
        return $this->connection->lastInsertId(); //retorna o ultimo id
        
    }

    public function execute($query, $params = []){
        try{
          $statement = $this->connection->prepare($query);
          $statement->execute($params);
          return $statement;
        }catch(PDOException $e){
            die('ERROR: ' .$e->getMessage());
        }
    }
    public function select($where = null, $order  = null, $limit = null, $fields = '*'){
       
        $where = strlen($where) ? 'WHERE ' .$where : '';
        $order = strlen($order) ? 'ORDER BY ' .$order : '';
        $limit = strlen($limit) ? 'LIMIT ' .$limit : '';
            
        $query = 'SELECT' .$fields. 'FROM ' .$this->table. ' ' .$where. ' ' .$order. ' ' .$limit;
       
        return $this->execute($query);
    }

    public function update($where, $values){
        $fields = array_keys($values);
        $query = 'UPDATE ' .$this->table. ' SET ' .implode('=?,',$fields). '=? WHERE ' .$where;
        $this->execute($query, array_values($values));
    } 

    public function delete($where){
        $query = 'DELETE FROM ' .$this->table. ' WHERE ' .$where; 

        $this->execute($query); 
        return true;
    }

}