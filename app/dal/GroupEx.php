<?php

namespace dal;

// This code was generated by a tool. Don't modify it manually.
// http://sqldalmaker.sourceforge.net

class GroupEx
{
    /**
     * @var object
     */
    private $g_id;
    /**
     * @var object
     */
    private $g_name;
    /**
     * @var object
     */
    private $g_comments;
    /**
     * @var object
     */
    private $tasks_count;

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

    public function get_g_comments()
    {
        return $this->g_comments;
    }

    public function set_g_comments($value)
    {
        $this->g_comments = $value;
    }

    public function get_tasks_count()
    {
        return $this->tasks_count;
    }

    public function set_tasks_count($value)
    {
        $this->tasks_count = $value;
    }
}