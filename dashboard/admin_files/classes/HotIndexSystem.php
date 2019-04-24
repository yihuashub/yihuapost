<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 10/24/2017
 * Time: 4:55 PM
 */

define("MAX_HOT_INDEX_NUMBER", 4);

class HotIndexSystem
{
    private $id;
    private $errorMessage;

    public function __construct()
    {
        $this->db = new Database();

    }

    public function withContainerID($id)
    {
        if ($id > 0) {
            $this->id = $id;
        } else {
            $this->errorMessage = "$id must be > 0";
        }
    }

    public function addIndex()
    {
        if($this->checkIfHas())
        {
            $this->errorMessage = "项目已被添加，请勿重复添加。";
            return false;
        }

        if($this->countTotal())
        {
            if($this->countTotal() >= MAX_HOT_INDEX_NUMBER)
            {
                $this->errorMessage = "项目数量已达到最大值。";
                return false;
            }
        }


        $sql = "INSERT INTO web_index (`ID`, `container_id`, `ord`) VALUES (null, '$this->id', '0')"; // MYSQL query that: Update in db_table Order with value $order where rows id equals $item. $item is the number in index.php file: item-3.

        if ($this->db->query($sql) === TRUE) {
            return true;
        } else {
            $this->errorMessage = "数据库错误 ".$this->db->error();

            return false;

        }


    }

    public function deleteIndex($index)
    {
        $sql = "DELETE FROM web_index WHERE ID ='$index' "; // MYSQL query that: Update in db_table Order with value $order where rows id equals $item. $item is the number in index.php file: item-3.

        if ($this->db->query($sql) === TRUE) {
            return true;
        } else {
            return false;

        }
    }


    private function countTotal()
    {
        $sql = "SELECT COUNT(ID) AS total FROM web_index"; // MYSQL query that: Update in db_table Order with value $order where rows id equals $item. $item is the number in index.php file: item-3.
        $result = $this->db->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($array = mysqli_fetch_assoc($result)) {
                return $array['total'];
            }
        }

        return false;
    }


    private function checkIfHas()
    {
        $sql = "SELECT * FROM web_index WHERE container_id = '$this->id'";
        $result = $this->db->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return true;
        }

        return false;
    }

    public function deleteSelf()
    {
        $deleteSql = "TRUNCATE TABLE `web_index`";

        if (!$this->db->query($deleteSql)) {
            return false;
        }

        return true;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }


}


