<?php

namespace Phuong\Bundle\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PhuongDemoBundle:Default:index.html.twig', array('name' => $name));
    }
}
