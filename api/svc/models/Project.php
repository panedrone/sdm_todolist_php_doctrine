<?php

// Code generated by a tool. DO NOT EDIT.
// https://sqldalmaker.sourceforge.net/

namespace svc\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="projects")
 */
class Project
{
    /**
     * @ORM\Column(name="p_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @var int
     */
    private $p_id;
    /**
     * @ORM\Column(name="p_name", type="string", length=256)
     * @var string
     */
    private $p_name;

    public function get_p_id()
    {
        return $this->p_id;
    }

    public function set_p_id($value)
    {
        $this->p_id = $value;
    }

    public function get_p_name()
    {
        return $this->p_name;
    }

    public function set_p_name($value)
    {
        $this->p_name = $value;
    }
}
