<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Form extends AbstractController
{
    public function index()
    {
        return $this->render('form.html.twig');
    }
}