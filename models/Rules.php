<?php

namespace Models;

class Rules extends Database
{

    public function getRules(array $data)
    {
        return $this->findAll(
            'SELECT rules,id

            FROM rules
            WHERE players_ID = ?',
            $data
        );


    }
    public function sendRules(array $data)
    {
        $this->addOne(
            'rules',
            // table's name
            'rules,players_ID',
            // column's name
            '?,?',
            // placeholder
            $data
        );

    }
    public function updateRule(array $data)
    {
        $this->Update(
            'rules',
            // table name 
            'rules',
            // column name 
            // plceholders
            'id',
            // location WHERE CLAUSE
            $data
        );
    }

    public function DeleteRule(array $data)
    {
        $this->Delete(
            'rules',
            // table's name 
            'id',
            // column name 
            $data
        );

    }
}