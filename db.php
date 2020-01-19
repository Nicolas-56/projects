<?php


class DB
{

    private $host = 'localhost';
    private $username= 'root';
    private $password = '';
    private $dbname = 'project_test';
    private $pdo = null;
    public function __construct()
    {
        $this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->username,$this->password);
    }

    
    public function fetchAll($table, $where = '')
    {
        try
        {
            $data = $this->pdo->query("SELECT * FROM ".$table.(!empty($where) ? ' WHERE '.$where : ''))->fetchAll();
            return $data;
        }
        catch (PDOException $e) 
        {
            throw new Exception($e->getMessage());
        }
    }
    //Поиск в базе пользователя с указанным email
    public function  find($email)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email= :email AND del= :del");
        $stmt->execute(array(":email"=>$email,":del"=>'0')); 
        $user = $stmt->fetch();
        return $user;
    }

    public function query($action,$query,$args)
    {
        try
        {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($args);
            if ($action == "insert")
            {
                $insert_id = $this->pdo->lastInsertId();
                return $insert_id;
            }
        } catch (PDOException $e) 
        {
            throw new Exception($e->getMessage());
        }
    }

}




