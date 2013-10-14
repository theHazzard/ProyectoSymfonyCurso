<?php

namespace Hazzard\Bundle\CursoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Hazzard\Bundle\CursoBundle\Entity\Alumno;
use Hazzard\Bundle\CursoBundle\Form\Registro\AlumnoType as RegistroType;
use Hazzard\Bundle\CursoBundle\Form\AlumnoType;
use Symfony\Component\Security\Core\SecurityContext;


/**
 * Alumno controller.
 *
 * @Route("/alumno")
 */
class AlumnoController extends Controller
{
    /**
     * Registro de Alumno
     * 
     * @Route("/registrar/", name="alumno_registro")
     */
    public function registerAction() 
    {
        $peticion = $this->getRequest();
        $usuario = new Alumno();
        
        $form = $this->createForm(new RegistroType(), $usuario);
        
        if ($peticion->getMethod() == 'POST')
        {
            $form->bind($peticion);
            
            if ($form->isValid())
            {
                $encoder = $this->get('security.encoder_factory')
                                ->getEncoder($usuario);
                $usuario->setSalt(md5(time()));
                $passwordCodificado = $encoder->encodePassword(
                        $usuario->getPassword(),
                        $usuario->getSalt()
                );
                $usuario->setPassword($passwordCodificado);
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($usuario);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('info',
                        'Registrado Correctamente!'
                );
                return $this->redirect($this->generateUrl('home'));
            }
        }
        return $this->render(
                'HazzardCursoBundle:Alumno:registro.html.twig', 
                array('formulario' => $form->createView()));
    }
    
    /**
     * Login de usuario
     * 
     * @Route("/login/", name="alumno_login")
     * 
     */
     public function loginAction()
     {
         $peticion = $this->getRequest();
         $sesion = $peticion->getSession();
         
         $error = $peticion->attributes->get(
                 SecurityContext::AUTHENTICATION_ERROR,
                 $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
         );
         
         return $this->render('HazzardCursoBundle:Alumno:login.html.twig', array(
             'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
             'error'         => $error
         ));
     }

    /**
     * Lists all Alumno entities.
     *
     * @Route("/", name="alumno")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HazzardCursoBundle:Alumno')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Alumno entity.
     *
     * @Route("/", name="alumno_create")
     * @Method("POST")
     * @Template("HazzardCursoBundle:Alumno:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Alumno();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('alumno_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Alumno entity.
    *
    * @param Alumno $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Alumno $entity)
    {
        $form = $this->createForm(new AlumnoType(), $entity, array(
            'action' => $this->generateUrl('alumno_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Alumno entity.
     *
     * @Route("/new", name="alumno_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Alumno();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Alumno entity.
     *
     * @Route("/{id}", name="alumno_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HazzardCursoBundle:Alumno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/{id}/edit", name="alumno_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HazzardCursoBundle:Alumno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Alumno entity.
    *
    * @param Alumno $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Alumno $entity)
    {
        $form = $this->createForm(new AlumnoType(), $entity, array(
            'action' => $this->generateUrl('alumno_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Alumno entity.
     *
     * @Route("/{id}", name="alumno_update")
     * @Method("PUT")
     * @Template("HazzardCursoBundle:Alumno:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HazzardCursoBundle:Alumno')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('alumno_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Alumno entity.
     *
     * @Route("/{id}", name="alumno_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HazzardCursoBundle:Alumno')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Alumno entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('alumno'));
    }

    /**
     * Creates a form to delete a Alumno entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('alumno_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
