<?php

namespace application\core;

use PDO;

class Model
{
    protected $connection;
    protected $pdo;
    protected $tableName;

    function __construct()
    {
        $this->connection = new DbConnector();
        $this->pdo = $this->connection->connect();
    }

    public function insert($data, $count)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->tableName} (query_string, date, count) VALUES (:data, :date, :count)");
        $stmt->execute([
            'data' => $data,
            'date' => date("Y-m-d H:i:s"),
            'count' => $count
        ]);
    }

    public function all()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName}");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function paginate($page)
    {
        $limit = 10;
        $startFrom = ($page - 1) * $limit;

        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} ORDER BY id ASC LIMIT {$startFrom}, {$limit}");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}