<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 11/13/2017
 * Time: 8:33 PM
 */

class YihuaPostArticleController
{
    private $lang;
    private $postId;
    private $db;
    private $langCode;

    private $totalCount;
    private $totalPageCount;
    private $currentPageIndex;
    private $postContent;
    private $postLang;
    private $postStatus;
    private $postSummaryText;
    private $postAuthor;
    private $postCate;
    private $postDate;

    public function __construct($lang, $db)
    {
        (empty($db)) ? $this->db = new Database() : $this->db = $db;
        $this->lang = $lang;

        $this->totalCount = 0;
        $this->totalPageCount = 0;
        $this->currentPageIndex = 0;

        if (strcmp($lang, 'zh') == 0) {
            $this->langCode = 0;
        } else {
            $this->langCode = 1;
        }
    }

    public function getArticleListByPage($pageIndex, $maxCount)
    {
        $page = !empty($pageIndex) ? $pageIndex : 1;        //获取当前页码 没有的话 就是第一页
        if (!preg_match('/^\d+$/', $page) || $page < 1) $page = 1;        //如果输入的不是数字  或者小于1 默认第一页

        $pageSize = $maxCount;        //每页多少条

        $getPostCount = "SELECT COUNT(*) AS count FROM yihua_posts WHERE post_lang = $this->langCode AND `post_status` = 1";
        $query_pag_num = $this->db->query($getPostCount);

        if ($query_pag_num && mysqli_num_rows($query_pag_num) > 0) {
            $count = 0;
            while ($rows = mysqli_fetch_assoc($query_pag_num)) {
                $count = $rows['count'];        //返回记录总条数
            }

            $no_of_paginations = ceil($count / $pageSize);        //计算出总页数
            $start = ($page - 1) * $pageSize;        //sql查询起始位置

            $getPostByPage = "SELECT * FROM yihua_posts WHERE post_lang = $this->langCode AND `post_status` = 1 ORDER BY ID DESC LIMIT $start, $pageSize";
            $result = $this->db->query($getPostByPage);

            $articleList = array();
            if ($result && mysqli_num_rows($result) > 0) {
                while ($rows = mysqli_fetch_assoc($result)) {
                    array_push($articleList,$rows['ID']);
                }

                $this->totalCount = $count;
                $this->totalPageCount = $no_of_paginations;
                $this->currentPageIndex = $page;

                return $articleList;
            }
            return false;
        }
        return false;
    }

    public function getArchive()
    {
        $getArchive = "SELECT YEAR(post_date) as year, MONTH(post_date) as month, COUNT(ID) as countpost 
FROM yihua_posts  WHERE post_lang = $this->langCode AND `post_status` = 1 GROUP BY YEAR(post_date), MONTH(post_date)";
        $result = $this->db->query($getArchive);
        $archiveArray = array();

        if ($result && mysqli_num_rows($result) > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $resultArray = array("year" => $rows['year'], "month" => $rows['month'], "countpost" => $rows['countpost']);
                $archive = new YihuaPostArticleArchive($this->lang, $resultArray);
                array_push($archiveArray, $archive);
            }
            return $archiveArray;
        }
        return false;
    }

    public function getRecentPost($limit)
    {
        $recentPost = "SELECT * FROM yihua_posts WHERE post_lang = $this->langCode AND `post_status` = 1 ORDER BY ID DESC LIMIT $limit";
        $result = $this->db->query($recentPost);

        $articleList = array();
        if ($result && mysqli_num_rows($result) > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $mArticle = new YihuaPostArticle($this->db);
                if($mArticle->createDataById($rows['ID']))
                {
                    array_push($articleList,$mArticle);
                }
            }
            return $articleList;
        }
        return false;
    }

    public function getPostType()
    {
        $sql = "SELECT * FROM yihua_posts_types WHERE lang = $this->langCode ORDER BY `ord` ASC";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            $types = array();
            while ($rows = mysqli_fetch_assoc($result)) {
                $mCategory = new YihuaPostArticleType($this->lang,$this->db);
                $mCategory->createById($rows['ID']);
                array_push($types,$mCategory);
            }
            return $types;
        }

        return false;
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