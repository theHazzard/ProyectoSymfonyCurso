<?php

namespace Hazzard\Bundle\CursoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
    * @Route("/", name="home")
    * @Template()
    */
    public function indexAction()
    {
        return $this->render('HazzardCursoBundle:Default:index.html.twig');
    }
    
    /**
     * 
     * @Route("/about")
     * @Template()
     */
    public function aboutAction()
    {
        return $this->render('HazzardCursoBundle:Default:about.html.twig');
    }
}
