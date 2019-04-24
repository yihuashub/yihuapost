<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 11/22/2017
 * Time: 12:44 AM
 */

class AgentController
{
    private $lang;
    private $phone;
    private $db;

    private $totalCount;
    private $totalPageCount;
    private $currentPageIndex;

    public function __construct($db) {
        (empty($db)) ? $this->db = new Database() : $this->db =$db;

        $this->totalCount = 0;
        $this->totalPageCount = 0;
        $this->currentPageIndex = 0;
    }


    public function getRandomAgentList($limit)
    {
        $sql = "SELECT ID FROM `yihua_users_profile` WHERE `status` = 0 ORDER BY RAND() LIMIT $limit";

        $result = $this->db->query($sql);
        $resultArray = array();


        if ($result && mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                array_push($resultArray,$row['ID']);
            }
            return $resultArray;
        }
        else{
            return false;
        }
    }


    public function getAllList()
    {

        $sql = "SELECT ID FROM `yihua_users_profile` WHERE `status` = 0 ORDER BY `join_time`";

        $result = $this->db->query($sql);
        $resultArray = array();


        if ($result && mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                array_push($resultArray,$row['ID']);
            }
            return $resultArray;
        }
        else{
            return false;
        }
    }
}