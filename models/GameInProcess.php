<?php
namespace Models;

class GameInProcess extends Database
{
    // SELECT GAMES LIST
    public function getGamesList()
    {
        return $this->select(
            'games', // table's name
            'id,date,nbrPoints', //columns' name 
            '?,?,?' // placeholders 
        );



    }
}