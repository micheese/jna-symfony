<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 14-11-19
 * Time: 18:20
 */

namespace Jna\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Jna\MainBundle\Repository\WorkTypeRepository")
 */
class WorkType {

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
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @var string
     *
     */
    private $machine_name;

    /**
     * @ORM\OneToMany(targetEntity="Project", mappedBy="id", cascade={"persist"})
     */
    private $projects;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function addProject(Project $project)
    {
        // Si l'objet fait déjà partie de la collection on ne l'ajoute pas
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
        }
    }

    public function getMachineName()
    {
        $type = $this->type;
        $this->machine_name = str_replace(' ' , '-' , $type);
        return $this->machine_name;
    }

} 