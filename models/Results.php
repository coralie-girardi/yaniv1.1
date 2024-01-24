<?php

// -- NAMESPACE MODELS --
namespace Models;

class Results
{
    // -- CREATION CHAINE TOKEN --
    public function generateChaineAleatoire(int $lenght = 10)
    {
        return substr(str_shuffle(str_repeat($code = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', ceil($lenght / strlen($code)))), 1, $lenght);

    }
}