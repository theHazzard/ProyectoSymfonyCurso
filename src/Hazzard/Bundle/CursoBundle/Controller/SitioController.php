<?php

namespace Hazzard\Bundle\CursoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SitioController extends Controller
{
    /**
     * @Route("/sitio/{pagina}/")
     * @Template()
     */
    public function estaticaAction($pagina)
    {
        return $this->render('HazzardCursoBundle:Sitio:'.$pagina.'.html.twig');
    }

}
