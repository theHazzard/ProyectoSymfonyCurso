<?php

namespace Hazzard\Bundle\CursoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alumno
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Hazzard\Bundle\CursoBundle\Entity\AlumnoRepository")
 */
class Alumno
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=55)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=55)
     */
    private $apellido;

    /**
     * @var integer
     *
     * @ORM\Column(name="dni", type="integer")
     */
    private $dni;

    /**
     * 
     * @ORM\ManyToMany(targetEntity="Materia", inversedBy="alumnos")
     * JoinTable(name="cursos_alumno",
     *      joinColumns={@JoinColumn(name="alumno_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="curso_id", referencedColumnName="id")}
     *      )
     */
    private $cursos;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Alumno
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Alumno
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set dni
     *
     * @param integer $dni
     * @return Alumno
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    
        return $this;
    }

    /**
     * Get dni
     *
     * @return integer 
     */
    public function getDni()
    {
        return $this->dni;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cursos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add cursos
     *
     * @param \Hazzard\Bundle\CursoBundle\Entity\Materia $cursos
     * @return Alumno
     */
    public function addCurso(\Hazzard\Bundle\CursoBundle\Entity\Materia $cursos)
    {
        $this->cursos[] = $cursos;
    
        return $this;
    }

    /**
     * Remove cursos
     *
     * @param \Hazzard\Bundle\CursoBundle\Entity\Materia $cursos
     */
    public function removeCurso(\Hazzard\Bundle\CursoBundle\Entity\Materia $cursos)
    {
        $this->cursos->removeElement($cursos);
    }

    /**
     * Get cursos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCursos()
    {
        return $this->cursos;
    }
}