<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 10/29/2017
 * Time: 3:15 AM
 */

class HouseOptionSystem
{

    private $id;
    private $optionName;
    private $optionValue;
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

    public function addIndex($optionName, $optionValue, $optionCN, $optionEN)
    {
        $this->optionName = $optionName;
        $this->optionValue = $optionValue;
        $this->optionCN = $optionCN;
        $this->optionEN = $optionEN;

        $checkIfHas = $this->checkIfHas();
        if ($checkIfHas) {
            $this->errorMessage = $this->errorMessage." 重复错误。";
            return false;
        }


        $sql = "INSERT INTO web_house_options (`ID`, `ord`, `option_name`, `value`, `name_cn`, `name_en`) VALUES (null,  '0','$this->optionName', '$this->optionValue','$this->optionCN','$this->optionEN')"; // MYSQL query that: Update in db_table Order with value $order where rows id equals $item. $item is the number in index.php file: item-3.

        if ($this->db->query($sql) === TRUE) {
            return true;
        } else {
            $this->errorMessage = "数据库错误 " . $this->db->error();

            return false;

        }


    }

    public function deleteIndex($index)
    {
        $sql = "DELETE FROM web_house_options WHERE ID ='$index' "; // MYSQL query that: Update in db_table Order with value $order where rows id equals $item. $item is the number in index.php file: item-3.

        if ($this->db->query($sql) === TRUE) {
            return true;
        } else {
            return false;

        }
    }

    public function updateIndex($array_items)
    {
        $order = 0; //order number set to 0;
        $result = true;

        // IF CONNECTED run foreach loop

        foreach ($array_items as $item) {

            $update = "UPDATE web_house_options SET ord = '$order' WHERE ID='$item' "; // MYSQL query that: Update in db_table Order with value $order where rows id equals $item. $item is the number in index.php file: item-3.

            if ($this->db->query($update) === TRUE) {
                $order++; //increment order value by one;
            } else {
                $result = false;

            }
        }

        return $result;
    }

    public function getSelectOptions()
    {
        $sql = "SELECT * FROM web_house_options";
        $result = $this->db->query($sql);

        $resultRow = array();

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result))
            {
                array_push($resultRow,$row['option_name']);
            }
        }
        else{
            return false;
        }

        return array_unique($resultRow);
    }

    public function getOptionsArray($optionsString)
    {
        $result = $this->db->query("SELECT * FROM `web_house_options` WHERE `option_name` LIKE '$optionsString' ORDER BY `web_house_options`.`ord` ASC");

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

        $sql = "SELECT * FROM web_house_options WHERE `option_name` LIKE '$this->optionName'";
        $resultRow = $this->db->query($sql);
        $result = false;
        if ($resultRow && mysqli_num_rows($resultRow) > 0) {

            while ($row = mysqli_fetch_assoc($resultRow))
            {
                $mValue = $row['value'];
                $mOptionValue = $this->optionValue;

                if(strcmp($mValue,$mOptionValue) == 0)
                {
                    $this->errorMessage = "项目已被添加，请勿重复添加。";
                    $result = true;
                }
            }
        }


        return $result;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

}