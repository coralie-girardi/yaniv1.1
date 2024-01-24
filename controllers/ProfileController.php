<?php
// --- NAMESPACE : CONTROLLERS --- 
namespace Controllers;

class ProfileController
{
    public function displayProfile()
    {
        $template = 'profile.phtml';
        include_once 'views/layout.phtml';
    }
}