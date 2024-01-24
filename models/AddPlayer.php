<?php

// -- NAMESPACE --

namespace Models;

class Addplayer extends Database
{
    public function getPlayerUsername()
    {

        // SELECT USERNAME DB
        return $this->select(
            'players',
            // table's name
            'id,username', // column's name

        );
    }


    public function getPlayers()
    {
        return $this->select(
            'players',
            // table's name
            '*' // column's name
        );
    }
    public function getPlayersInGame( $id)
    {
        return $this->findAll(
            '   SELECT  playersingame.players_id,
                        players.username
                FROM playersingame
                INNER JOIN players
                    ON playersingame.players_id = players.id
                WHERE games_id=?',
            // table's name
            [$id] //column's name

        );
    }


    // INSERT ID AND PLAYERS USERNAME TO BDD
    public function addPlayerAndId(array $data)
    {
        $this->addOne(
            'playersingame',
            // table's name
            'players_id,games_id',
            // columns' name
            '?,?', //placeholder
            $data // data array
        );
    }


}