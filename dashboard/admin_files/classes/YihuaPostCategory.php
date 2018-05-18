<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/17/2017
 * Time: 12:37 PM
 */

class YihuaPostCategory
{
    private $db;
    private $id;
    private $typeName;
    private $lang;
    private $optionCN;
    private $optionEN;
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

    public function addIndex($typeName,$lang)
    {
        $this->typeName = $typeName;
        $this->lang = $lang;

        $checkIfHas = $this->checkIfHas();
        if ($checkIfHas) {
            $this->errorMessage = $this->errorMessage." 重复错误。";
            return false;
        }


        $sql = "INSERT INTO yihua_posts_types (`ID`, `name`, `lang`) VALUES (null, '$typeName', '$lang')";

        if ($this->db->query($sql) === TRUE) {
            return true;
        } else {
            $this->errorMessage = "数据库错误 " . $this->db->error();
            return false;
        }
    }

    public function deleteIndex($categoryId)
    {

        if($this->initCategory($categoryId))
        {
            $sql = "DELETE FROM yihua_posts_types WHERE ID ='$categoryId' ";

            if ($this->db->query($sql) === TRUE) {
                return true;
            } else {
                $this->errorMessage = $this->errorMessage." 系统错误删除失败。";

                return false;
            }
        }else{
            return false;
        }
    }

    private function initCategory($categoryId)
    {
        $update = "UPDATE yihua_posts SET post_category = 0 WHERE post_category='$categoryId' ";

        if ($this->db->query($update) === TRUE) {
            return true;
        } else {
            $this->errorMessage = $this->errorMessage." 系统错误重置文章分类失败。";
            return false;
        }
    }

    public function updateIndex($array_items)
    {
        $order = 0; //order number set to 0;
        $result = true;

        // IF CONNECTED run foreach loop

        foreach ($array_items as $item) {

            $update = "UPDATE yihua_posts_types SET ord = '$order' WHERE ID='$item' ";

            if ($this->db->query($update) === TRUE) {
                $order++; //increment order value by one;
            } else {
                $result = false;

            }
        }

        return $result;
    }

    public function getCategoryTypes()
    {

    }

    public function getOptionsArray($lang)
    {
        $result = $this->db->query("SELECT * FROM `yihua_posts_types` WHERE `lang` = '$lang'  ORDER BY `ord` ASC");

        $resultRow = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result))
            {
                array_push($resultRow,$row);
            }
        }

        return $resultRow;
    }

    private function checkIfHas()
    {
        $result = false;

        $sql = "SELECT * FROM yihua_posts_types WHERE `name` LIKE '$this->typeName'";
        $resultRow = $this->db->query($sql);
        if ($resultRow && mysqli_num_rows($resultRow) > 0) {

            $this->errorMessage = "分类已经添加，请勿重复添加。";
            $result = true;
        }
        else{
            $result = false;
        }

        return $result;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

}