<?php
class Database
{
     
    private $host = "localhost";
    private $db_name = "kidscave";
    private $username = "root";
    private $password = "";
    private static $conn;
     
    public function dbConnection()
	{
     
	    if(static::$conn == null) {
            try {
                static::$conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                static::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            }
        }
        return static::$conn;
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
}
?>