<?php

// -- NAMESPACE MODEL --
namespace Models;

// -- REQUIRE CONFIG DB --
require('config/config.php');


class Database
{

    protected $bdd;

    // connexion to db
    public function __construct()
    {
        $this->bdd = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);

    }

    // fetch all
    protected function findAll(string $req, array $params = [])
    {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }
    // fetch
    protected function findOne(string $req, array $params = [])
    {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }
    //
    protected function find(string $req, string $choice = "fetch", array $params = [])
    {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        if ($choice == "fetch") {
            return $query->fetch();
        } else {
            return $query->fetchAll();
        }

    }

    // ----- CRUD ------


    // SELECT
    protected function select(string $table, string $columns)
    {
        $query = $this->bdd->prepare('SELECT ' . $columns . ' FROM ' . $table);
        $query->execute();
        return $query->fetchAll();

    }
    // ---- SELECT ONE ----

    //
    protected function selectOne(string $table, string $columns, string $location, string $id)
    {
        $query = $this->bdd->prepare('SELECT ' . $columns . ' FROM ' . $table . ' WHERE ' . $location . '=?');
        $query->execute([$id]);
        return $query->fetch();
    }
    // INSERT
    protected function addOne(string $table, string $columns, string $values, array $data)
    {
        $query = $this->bdd->prepare('INSERT INTO ' . $table . '(' . $columns . ') values (' . $values . ')');
        $query->execute($data);
        $query->closeCursor();
    }
    // UPDATE
    protected function Update(string $table, string $columns, string $location, array $data)
    {
        $query = $this->bdd->prepare('UPDATE ' . $table . ' SET ' . $columns . ' = ? WHERE ' . $location . ' = ?');
        $query->execute($data);
        $query->closeCursor();
    }
    // DELETE
    protected function Delete(string $table, string $column, array $data)
    {
        $query = $this->bdd->prepare('DELETE FROM ' . $table . ' WHERE ' . $column . ' = ?');
        $query->execute($data);
        $query->closeCursor();
    }
}