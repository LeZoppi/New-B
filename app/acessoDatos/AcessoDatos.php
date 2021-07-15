<?php
class AccesoDatos
{
    private static $objAccesoDatos;
    private $objetoPDO;

    private function __construct()
    {
        try {
   
            $this->objetoPDO = new PDO(
                'mysql:host=remotemysql.com:3306;dbname=FHw7KWqmJs;charset=utf8',
                'FHw7KWqmJs',
                '5i9QTeNy0t',
                [
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            );
            $this->objetoPDO->exec('SET CHARACTER SET utf8');
        } catch (PDOException $e) {
            print 'Error: ' . $e->getMessage();
            die();
        }
    }

    public static function obtenerInstancia()
    {
        if (!isset(self::$objAccesoDatos)) {
            self::$objAccesoDatos = new AccesoDatos();
        }
        return self::$objAccesoDatos;
    }

    public function prepararConsulta($sql)
    {
        return $this->objetoPDO->prepare($sql);
    }

    public function obtenerUltimoId()
    {
        return $this->objetoPDO->lastInsertId();
    }

    public function __clone()
    {
        trigger_error(
            'ERROR: La clonación de este objeto no está permitida',
            E_USER_ERROR
        );
    }
}