<?php

// --- NAMESPACE MODEL---
namespace Models;

class Game extends Database
{
    // -- INSERT INTO FUNCTION --
    public function addNbrPoints(array $data)
    {
        $this->addOne(
            'games',
            //table's name
            'nbrPoints',
            //columns' name
            '?',
            //placeholders
            $data //data array
        );
    }
    public function getGamesInfo(string $id)
    {

        return $this->findAll(
            'SELECT games.date, games.nbrPoints,
                            playersingame.players_id,
                            players.username

                    FROM games

                    INNER JOIN playersingame
                        ON games.id = playersingame.games_id
                            INNER JOIN players
                        ON players.id = playersingame.players_id


                    WHERE games.id=?',
            [$id]
        );
    }

    public function sendPoints(array $data)
    {
        $this->addOne(
            'coursegame',
            // table's name
            'id_players, id_games, points',
            // columns' name
            '?,?,?',
            $data
        );
    }
    public function getScores(array $data)
    {
        return $this->findAll(
            'SELECT points

            FROM coursegame
            WHERE id_players = ?
            AND id_games = ?'

            ,
            $data
        );


    }
    public function TotalScores(array $data)
    {
        return $this->findAll(
            'SELECT
            SUM(points)

            FROM coursegame
            WHERE id_players = ?
            AND id_games = ?'


            ,
            $data
        );


    }
    public function sendTotalPoints(array $data)
    {
        $this->addOne(
            'totalPoints',
            // table's name
            'players_id, id_games, totalPts',
            // columns' name
            '?,?,?',
            $data
        );
    }
    public function getTotalScores(array $data)
    {
        return $this->findAll(
            'SELECT Max(totalPts)
            FROM totalPoints
            WHERE players_id = ?
            AND id_games = ?'
            ,
            $data
        );
    }



}