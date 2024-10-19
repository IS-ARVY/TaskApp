<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

       return view("Home/index.php");

    }

    public function testEmail()
    {
        $email = service('email');
        
        $email->setTO('montalvanmarvin1@gmail.com');

        $email->setSubject('TaskAppNotification');
        
        $email->setMessage('<h1>Hello word</h1>');

        if ($email->send())
        {
            echo "Que pro si se envio";
        } else{
            echo $email->printDebugger();
        }
    }
}
