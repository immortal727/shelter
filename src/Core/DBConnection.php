<?php

namespace Ifmo\Web\Core;

use PDO;

class DBConnection
{
    private $connection;
    private static $instance;

    private function __construct(){}
    // внутри ститичесикх методов нельзя обращаться
    // к нестатическим свойствам и
    // вызывать нестатические методы
    public static function getInstance(){
        if (self::$instance === null){
            self::$instance = new DBConnection();
        }
        return self::$instance;
    }

    public function getConnection() :PDO{
        return $this->connection;
    }

    public function initConnection(array $settings){
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE =>
                PDO::FETCH_ASSOC // данные из бд получаем в виде ассоциативного массива
        ];
        $this->connection = $this->connect(
            $settings['server'],
            $settings['dbname'],
            $settings['user'],
            $settings['pass'],
            $settings['charset'],
            $options
        );
    }

    private function connect(
        $server, $dbname, $user, $pwd, $charset,
        array $options=[])
    {
        $dsn = "mysql:host=$server;dbname=$dbname;charset=$charset";

        return new PDO($dsn, $user, $pwd, $options);
    }

    public function queryAll($sql){
        $statement = $this->connection->query($sql);
        if (!$statement) return false;
        return $statement->fetchAll();
    }

    public function exec($sql){
        return $statement = $this->connection->exec($sql);
    }

    public function execute($sql, $params, $all = true){
        // Если $all=false - одна запись, true - много записей
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);

        if (!$all){
            return $statement->fetch();
        }
        return $statement->fetchAll();
    }

    public function executeSql($sql, $params){
        $statement = $this->connection->prepare($sql);
        return $statement->execute($params);
    }


}