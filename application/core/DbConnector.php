<?php

namespace application\core;

class DbConnector
{
    protected $user = 'root';
    protected $password = '';
    protected $host = 'localhost';
    protected $database = 'framework_test';

    public function connect()
    {
        try {
            $pdo = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, $this->user, $this->password);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            die;
        }

        return $pdo;
    }

    public function getDBName()
    {
        return $this->database;
    }
}