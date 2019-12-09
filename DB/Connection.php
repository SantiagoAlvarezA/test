<?php
class Connection
{
    private $user;
    private $password;
    private $host;
    private $conexion;
    private $DB;

    public function getConnection()
    {
        $this->user = 'root';
        $this->password = '';
        $this->host = 'localhost';
        $this->DB = 'my_test';

        try
        {
            $this->conexion = new PDO("mysql:host=$this->host;port=3306;dbname=$this->DB",$this->user,$this->password);
            $this->conexion->exec("SET CHARACTER SET UTF8");
            return $this->conexion;
        }catch (Exception $exc)
        {
            echo $exc->getTraceAsString();
        }
    }
}