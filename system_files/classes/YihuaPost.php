<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/11/2017
 * Time: 3:57 PM
 */

class YihuaPost
{
    private $lang;
    private $phone;
    private $size;
    private $db;

    public function __construct() {
        $this->lang = "en";
        $this->db = new Database();
    }

    public function getCurrentDB()
    {
        return $this->db;
    }

    public function getRewriteUrlModel($url)
    {
        $sql = "SELECT * FROM `site_rewrite_url` WHERE `url` LIKE '$url'";

        $result = $this->db->query($sql);
        $resultModel = "";

        if ($result && mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $resultModel = $row['rewrite'];
                $this->size = $row['rewrite_size'];
            }
        }
        else{
            return false;
        }
        return $resultModel;
    }

    public function getRewriteSize()
    {
        return $this->size;
    }
}