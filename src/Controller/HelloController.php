<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HelloController extends Controller
{
    public function index()
    {
        // return $this->render('hello.html.twig');

        $prenom1 = "Etienne";
        $prenom2 = "Alex";
        return $this->render('_hello_prenom.html.twig', array(
          "prenom1" => $prenom1,
          "prenom2" => $prenom2,
        ));
    }

    public function index_perso($prenom, $age)
    {
      return $this->render('_helloperso.html.twig', array(
        "prenom" => $prenom,
        "age" => $age,
      ));
    }
}

?>
