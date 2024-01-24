<?php


namespace Models;

class User extends Database
{

    public function getUserByEmail(string $email)
    {

        //request email bdd
        $req = "SELECT * FROM players WHERE email = ?";
        return $this->findOne($req, [$email]);

    }

    // function to add an user
    public function addNewUser(array $data)
    {
        $this->addOne(
            'players',
            // table's name
            ' email, password, username, lastname, firstname',
            // columns' name
            '?,?,?,?,?',
            // placeholders
            $data
        ); // data array



    }


}