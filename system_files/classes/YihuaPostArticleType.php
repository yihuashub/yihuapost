<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 11/17/2017
 * Time: 2:46 PM
 */

class YihuaPostArticleType
{

    private $postId;
    private $categoryId;
    private $categoryName;
    private $postCount;


    private $lang;
    private $langCode;
    private $db;


    public function __construct($lang,$db)
    {
        (empty($db)) ? $this->db = new Database() : $this->db = $db;
        $this->lang = $lang;

        if (strcmp($lang, 'zh') == 0) {
            $this->langCode = 0;
        } else {
            $this->langCode = 1;
        }
    }

    public function createById($Id)
    {
        $this->categoryId = $Id;
        $this->queryData();
        $this->queryCount();
    }

    public function getName()
    {
        return $this->categoryName;
    }

    public function getCategoryCount()
    {
        return $this->postCount;
    }

    public function getUrlLink()
    {
        return "#";
    }

    private function queryData()
    {
        $sql = "SELECT * FROM yihua_posts_types WHERE ID = $this->categoryId";
        $result = $this->db->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $this->categoryName = $rows['name'];
                return true;
            }
        }
        return false;
    }



    private function queryCount()
    {
        $postCountSql = "SELECT COUNT(ID) as countpost FROM yihua_posts  WHERE post_category = $this->categoryId AND `post_status` = 1 ";
        $postCount = $this->db->query($postCountSql);

        if ($postCount && mysqli_num_rows($postCount) > 0) {
            while ($postRows = mysqli_fetch_assoc($postCount)) {
                $this->postCount = $postRows['countpost'];
                return true;
            }
        }
        return false;
    }
}


