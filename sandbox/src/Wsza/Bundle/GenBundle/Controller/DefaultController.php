<?php

namespace Wsza\Bundle\GenBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GenBundle:Default:index.html.twig', array('name' => $name));
    }
}
