<?php

// This code was generated by a tool. Don't modify it manually.
// http://sqldalmaker.sourceforge.net

namespace models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups")
 */
class Group
{
    /**
     * @ORM\Column(name="g_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @var int
     */
    private $g_id;
    /**
     * @ORM\Column(name="g_name", type="string", length=65535, unique=true)
     * @var string
     */
    private $g_name;

    public function get_g_id()
    {
        return $this->g_id;
    }

    public function set_g_id($value)
    {
        $this->g_id = $value;
    }

    public function get_g_name()
    {
        return $this->g_name;
    }

    public function set_g_name($value)
    {
        $this->g_name = $value;
    }
}
