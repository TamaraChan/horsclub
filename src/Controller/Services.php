<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Services extends AbstractController
{
    public function index()
    {
        return $this->render('services.html.twig');
    }
}