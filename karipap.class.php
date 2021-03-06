<?php
/**
 * karipap.class.php
 * weldan jamili <mweldan@gmail.com>
 * http://mweldan.com
 */
class Karipap {
    
    public $connection = false;
    public $id = "id";
    private $statement;
    private $db;
    private $database;
    private $host;
    private $user;
    private $password;
    
    public function __construct($database, $user, $pass, $host) {
        $this->database = $database;
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;  
        $this->connect();        
    }
    
    /**
     * connect to database 
     */
    public function connect() {  
        $this->db = new PDO(
            'mysql:host='.$this->host.';dbname='.$this->database.';',
            $this->user,
            $this->password);
        if ($this->db) {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection = true;
        }
        return $this->connection;
    }
    
    /**
     * execute raw query 
     */
    public function raw($sql) {
        $this->statement = $this->db->query($sql);
        return $this;
    }
    
    /**
     * execute prepared statement 
     */
    public function query($sql, $vars=array()) {
        $this->statement = $this->db->prepare($sql);
        if (isset($vars)) {
            $this->statement->execute($vars);
        }else {
            $this->statement->execute();
        }
        return $this;
    }
    
    /**
     * execute insert query 
     */
    public function create($table, $fields) {
        $sql = "insert into `".$table."`";
        $sql_columns = "(";
        $sql_values = " values(";
        $values = array(); 
        foreach($fields as $key => $value) {
            if (end($fields) == $value) {
                $sql_columns .= "`".$key."`)";
            }else {
                $sql_columns .= "`".$key."`,";
            }          
            $values[] = $value;
        }
        foreach($values as $value) {
            if (end($values) == $value) {
                $sql_values .= "?)";
            }else {
                $sql_values .= "?,";
            }          
        }        
        $sql .= $sql_columns;
        $sql .= $sql_values;
        
        $this->statement = $this->db->prepare($sql);
        return $this->statement->execute($values);
    }
    
    /**
     * execute delete query 
     */
    public function delete($table, $id) {
        $sql = "delete from `".$table."` ";
        $sql .= "where `".$this->id."` = ?";
        $this->statement = $this->db->prepare($sql);
        return $this->statement->execute(array($id));
    }
    
    /**
     * return row count of last executed query 
     */
    public function getRows() {
        return $this->statement->rowCount();
    }
    
    /**
     * return array result of last executed query  
     */
    public function getResult() { 
        return $this->statement->fetchAll();
    }
    
} 

?>
