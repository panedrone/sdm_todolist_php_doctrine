<?php

namespace dal;

include_once 'GroupEx.php';

use \dal\GroupEx;

// This code was generated by a tool. Don't modify it manually.
// http://sqldalmaker.sourceforge.net

class GroupsTestDao
{
    protected $ds;

    public function __construct($ds)
    {
        $this->ds = $ds;
    }

    /**
     * @return GroupEx[]
     */
    public function get_groups()
    {
        $sql = "select g.*, "
            . "\n (select count(*) from tasks where g_id=g.g_id) as tasks_count"
            . "\n from groups g"
            . "\n order by g.g_id";
        $res = array();
        $_map_cb = function ($row) use (&$res) {
            $obj = new GroupEx();
            $obj->setGId($row["g_id"]); // q <- q
            $obj->setGName($row["g_name"]); // q <- q
            $obj->setGComments($row["g_comments"]); // q <- q
            $obj->setTasksCount($row["tasks_count"]); // q <- q
            array_push($res, $obj);
        };
        $this->ds->queryRowList($sql, array(), $_map_cb);
        return $res;
    }

    /**
     * @param string $g_id
     * @return GroupEx|FALSE on failure
     */
    public function get_group($g_id)
    {
        $sql = "select g.*, "
            . "\n (select count(*) from tasks where g_id=g.g_id) as tasks_count"
            . "\n from groups g"
            . "\n where g.g_id=?";
        $row = $this->ds->queryRow($sql, array($g_id));
        if ($row) {
            $obj = new GroupEx();
            $obj->setGId($row["g_id"]); // q <- q
            $obj->setGName($row["g_name"]); // q <- q
            $obj->setGComments($row["g_comments"]); // q <- q
            $obj->setTasksCount($row["tasks_count"]); // q <- q
            return $obj;
        }
        return FALSE;
    }

    /**
     * @return array of object g_id
     */
    public function get_groups_ids()
    {
        $sql = "select g.*, "
            . "\n (select count(*) from tasks where g_id=g.g_id) as tasks_count"
            . "\n from groups g"
            . "\n order by g.g_id";
        return $this->ds->queryList($sql, array());
    }

    /**
     * @param string $g_id
     * @return mixed object g_id or FALSE on failure
     */
    public function get_group_id($g_id)
    {
        $sql = "select g.*, "
            . "\n (select count(*) from tasks where g_id=g.g_id) as tasks_count"
            . "\n from groups g"
            . "\n where g.g_id=?";
        return $this->ds->query($sql, array($g_id));
    }

    /**
     * @param string $g_name
     * @param string $g_id
     * @return int the affected rows count
     */
    public function rename_group($g_name, $g_id)
    {
        $sql = "update groups set g_name=? where g_id=?";
        return $this->ds->execDML($sql, array($g_name, $g_id));
    }

}
