<?php

// Code generated by a tool. DO NOT EDIT.
// https://sqldalmaker.sourceforge.net/

namespace dao;

include_once __DIR__ . '/../models/Project.php';
include_once __DIR__ . '/../models/ProjectLi.php';

use models\Project;
use models\ProjectLi;

class ProjectsDao
{
    /**
     * @var \DataStore
     */
    protected $ds;

    public function __construct($ds)
    {
        $this->ds = $ds;
    }

    /**
     * (C)RUD: projects
     * Generated/AI values are passed to $p param
     * @param Project $p
     * @return void
     * @throws \Exception
     */
    public function create_project($p)
    {
        $this->ds->create($p);
    }

    /**
     * C(R)UD: projects
     * @return Project[]
     * @throws \Exception
     */
    public function read_project_list()
    {
        return $this->ds->readAll(Project::class);
    }

    /**
     * C(R)UD: projects
     * @param int $p_id
     * @return Project|FALSE on failure
     * @throws \Exception
     */
    public function read_project($p_id)
    {
        return $this->ds->read(Project::class, array("p_id" => $p_id));
    }

    /**
     * CR(U)D: projects
     * @param Project $p
     * @throws \Exception
     */
    public function update_project($p)
    {
        return $this->ds->update($p);
    }

    /**
     * CRU(D): projects
     * @param int $p_id
     * @throws \Exception
     */
    public function delete_project($p_id)
    {
        return $this->ds->delete(Project::class, array("p_id" => $p_id));
    }

    /**
     * @return ProjectLi[]
     * @throws \Exception
     */
    public function get_projects()
    {
        $sql = "select p.*,"
            . "\n (select count(*) from tasks where p_id=p.p_id) as p_tasks_count"
            . "\n from projects p"
            . "\n order by p.p_id";
        $res = array();
        $_map_cb = function ($row) use (&$res) {
            $obj = new ProjectLi();
            $obj->set_p_id($row["p_id"]); // q <- q
            $obj->set_p_name($row["p_name"]); // q <- q
            $obj->set_p_tasks_count($row["p_tasks_count"]); // q <- q
            array_push($res, $obj);
        };
        $this->ds->queryRowList($sql, array(), $_map_cb);
        return $res;
    }

    /**
     * @return array of object p_id
     * @throws \Exception
     */
    public function get_project_ids()
    {
        $sql = "select p.*,"
            . "\n (select count(*) from tasks where p_id=p.p_id) as p_tasks_count"
            . "\n from projects p"
            . "\n order by p.p_id";
        return $this->ds->queryList($sql, array());
    }

    /**
     * @param string $g_name
     * @param string $g_id
     * @return int the affected rows count
     * @throws \Exception
     */
    public function rename_project($g_name, $g_id)
    {
        $sql = "update projects set p_name=? where p_id=?";
        return $this->ds->execDML($sql, array($g_name, $g_id));
    }
}
