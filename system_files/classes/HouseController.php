<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/12/2017
 * Time: 12:11 AM
 */

class HouseController
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

    public function getNewListing($limit)
    {
        $sql = "SELECT ID FROM `web_house` WHERE (`type` > 1) AND `status` = 1 ORDER BY `type` DESC, `ID` DESC , `update_date` DESC LIMIT $limit";

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

    public function getHouseListByPage($pageIndex, $maxCount)
    {
        $totalPageSql= "SELECT COUNT(*) AS count FROM `web_house` WHERE `status` = 1";
        $singPageSql = "SELECT * FROM `web_house` WHERE `status` = 1 ORDER BY `type` DESC, `ID` DESC ";

        return $this->pagesController($pageIndex, $maxCount,$totalPageSql,$singPageSql);
    }

    public function getHouseListByHighToLow($pageIndex, $maxCount)
    {
        $totalPageSql= "SELECT COUNT(*) AS count FROM `web_house` WHERE (`type` > 1) AND `status` = 1";
        $singPageSql = "SELECT * FROM `web_house` WHERE (`type` > 1) AND `status` = 1 ORDER BY `price` DESC ";

        return $this->pagesController($pageIndex, $maxCount,$totalPageSql,$singPageSql);
    }

    public function getHouseListByLowToHigh($pageIndex, $maxCount)
    {
        $totalPageSql= "SELECT COUNT(*) AS count FROM `web_house` WHERE (`type` > 1) AND `status` = 1";
        $singPageSql = "SELECT * FROM `web_house` WHERE (`type` > 1) AND `status` = 1 ORDER BY `price` ASC ";

        return $this->pagesController($pageIndex, $maxCount,$totalPageSql,$singPageSql);
    }

    public function getHouseListBySold($pageIndex, $maxCount)
    {
        $totalPageSql= "SELECT COUNT(*) AS count FROM `web_house` WHERE `type` = 1 AND `status` = 1";
        $singPageSql = "SELECT * FROM `web_house` WHERE `type` = 1 AND `status` = 1 ORDER BY `update_date` DESC ";

        return $this->pagesController($pageIndex, $maxCount,$totalPageSql,$singPageSql);
    }

    public function getHouseListByOnSale($pageIndex, $maxCount)
    {
        $totalPageSql= "SELECT COUNT(*) AS count FROM `web_house` WHERE (`type`=3) AND `status` = 1";
        $singPageSql = "SELECT * FROM `web_house`  WHERE (`type`=3) AND `status` = 1 ORDER BY `ID` DESC  ";

        return $this->pagesController($pageIndex, $maxCount,$totalPageSql,$singPageSql);
    }

    public function getHouseListBySellListing($pageIndex, $maxCount)
    {
        $totalPageSql= "SELECT COUNT(*) AS count FROM `web_house` WHERE (`type` > 1) AND `status` = 1";
        $singPageSql = "SELECT * FROM `web_house`  WHERE (`type` > 1) AND `status` = 1 ORDER BY `type` DESC,`ID` DESC  ";

        return $this->pagesController($pageIndex, $maxCount,$totalPageSql,$singPageSql);
    }

    private function pagesController($pageIndex, $maxCount,$totalPageSql,$singPageSql)
    {
        $page = !empty($pageIndex) ? $pageIndex : 1;        //获取当前页码 没有的话 就是第一页
        if (!preg_match('/^\d+$/', $page) || $page < 1) $page = 1;        //如果输入的不是数字  或者小于1 默认第一页

        $pageSize = $maxCount;        //每页多少条

        $getPostCount = $totalPageSql;
        $query_pag_num = $this->db->query($getPostCount);

        if ($query_pag_num && mysqli_num_rows($query_pag_num) > 0) {
            $count = 0;
            while ($rows = mysqli_fetch_assoc($query_pag_num)) {
                $count = $rows['count'];        //返回记录总条数
            }

            $no_of_paginations = ceil($count / $pageSize);        //计算出总页数
            $start = ($page - 1) * $pageSize;        //sql查询起始位置

            $getPostByPage = $singPageSql." LIMIT $start, $pageSize";
            $result = $this->db->query($getPostByPage);

            $houseList = array();
            if ($result && mysqli_num_rows($result) > 0) {
                while ($rows = mysqli_fetch_assoc($result)) {
                    array_push($houseList,$rows['ID']);
                }

                $this->totalCount = $count;
                $this->totalPageCount = $no_of_paginations;
                $this->currentPageIndex = $page;

                return $houseList;
            }
            return false;
        }
        return false;
    }

    public function getRandomSoldList($limit)
    {
        $sql = "SELECT ID FROM `web_house` WHERE `type` = 1 AND `status` = 1 ORDER BY RAND() LIMIT $limit";

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

    public function getNewSoldList($limit)
    {
        $sql = "SELECT ID FROM `web_house` WHERE `type` = 1 AND `status` = 1 ORDER BY `update_date` DESC LIMIT $limit";

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

    public function getRelatedList($agent,$houseType,$limit)
    {
        if(empty($agent))
        {
            $agent = 1;
        }

        $sql = "SELECT ID FROM `web_house` WHERE (`type` > 1) AND `status` = 1 AND `house_type` = $houseType AND `author` = $agent ORDER BY RAND() LIMIT $limit";

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


    public function getAgentForSaleList($agent)
    {
        if(empty($agent))
        {
            $agent = 1;
        }

        $sql = "SELECT ID FROM `web_house` WHERE (`type` > 1) AND `status` = 1 AND `author` = $agent ORDER BY type DESC ";

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

    public function getAgentForSoldList($agent,$limit)
    {
        if(empty($agent))
        {
            $agent = 1;
        }

        $sql = "SELECT ID FROM `web_house` WHERE `type` = 1 AND `status` = 1 AND `author` = $agent ORDER BY update_date DESC LIMIT $limit ";

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

    public function getAllList($limit)
    {

        $sql = "SELECT ID FROM `web_house` WHERE `status` = 1 ORDER BY `type` DESC LIMIT $limit";

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

    public function getTotalCount()
    {
        return $this->totalCount;
    }

    public function getTotalPageCount()
    {
        return $this->totalPageCount;
    }

    public function getCurrentPageIndex()
    {
        return $this->currentPageIndex;
    }

}