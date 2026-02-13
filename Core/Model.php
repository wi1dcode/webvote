<?php

namespace Core;

class Model
{
    protected $db;

    public function __construct()
    {
        if (!$this->db) {
            $infos = simplexml_load_file(__DIR__ . '/config.xml');

            $host = (string)$infos->host;
            $db = (string)$infos->db;
            $user = (string)$infos->user;
            $password = (string)$infos->password;
            $port = isset($infos->port) ? trim((string)$infos->port) : '';

            $dsn = 'mysql:host=' . $host . ';dbname=' . $db;
            if ($port !== '') {
                $dsn .= ';port=' . $port;
            }

            try {
                $this->db = new \PDO(
                    $dsn,
                    $user,
                    $password,
                    [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                    ]
                );
            } catch (\PDOException $e) {
                exit('Erreur de connexion : ' . $e->getMessage());
            }
        }
    }

    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }
}
