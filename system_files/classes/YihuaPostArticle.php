<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 11/13/2017
 * Time: 8:03 PM
 */

class YihuaPostArticle
{
    private $imageId;
    private $postId;
    private $db;

    private $id;
    private $postTitle;
    private $author;
    private $postMainImage;
    private $postContent;
    private $postLang;
    private $postStatus;
    private $postSummaryText;
    private $postAuthor;
    private $postCate;
    private $postDate;

    public function __construct($db) {
        (empty($db)) ? $this->db = new Database() : $this->db =$db;
    }

    public function createDataById($id)
    {
        $this->id = $id;
        return $this->selectDataById();
    }

    public function createDataByTitle($title)
    {
        $this->postTitle = $title;
        return $this->selectDataByTitle();
    }

    private function selectDataByTitle()
    {
        $getPost = "SELECT * FROM yihua_posts WHERE `post_status` = 1 AND `post_title` LIKE '$this->postTitle'";
        $result = $this->db->query($getPost);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $this->id = $rows['ID'];
                $this->postTitle = $rows['post_title'];
                $this->postMainImage = $rows['post_main_image'];
                $this->postContent = $rows['post_content'];
                $this->postLang = $this->$rows["post_lang"];
                $this->postStatus = $rows['post_status'];
                $this->postSummaryText = $rows['post_summary'];
                $this->postAuthor = $rows['post_author'];
                $this->postCate = $rows['post_category'];
                $this->postDate = $rows['post_date'];
            }
            return true;
        }
        return false;
    }

    private function selectDataById()
    {
        $getPost = "SELECT * FROM yihua_posts WHERE `post_status` = 1 AND `ID` = $this->id";
        $result = $this->db->query($getPost);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $this->postTitle = $rows['post_title'];
                $this->postMainImage = $rows['post_main_image'];
                $this->postContent = $rows['post_content'];
                $this->postLang = $this->$rows["post_lang"];
                $this->postStatus = $rows['post_status'];
                $this->postSummaryText = $rows['post_summary'];
                $this->postAuthor = $rows['post_author'];
                $this->postCate = $rows['post_category'];
                $this->postDate = $rows['post_date'];
            }
            return true;
        }
        return false;
    }

    public function getPostTitle()
    {
        return $this->postTitle;
    }

    public function getMainPic()
    {
        return $this->postMainImage;
    }

    public function getPostContent()
    {
        return $this->postContent;
    }

    public function getPostCategory()
    {
        $mCate= new YihuaPostArticleType($this->postLang,$this->db);

        $mCate->createById($this->postCate);

        return $mCate->getName();
    }

    public function getPostSummaryText()
    {
        return $this->postSummaryText;
    }

    public function getPostDate()
    {
        return $this->postDate;
    }

    public function getPostAuthor()
    {
        return $this->postAuthor;
    }

    public function getUrlLink()
    {
        $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";

        return $rootUrl."article/".$this->getPostTitle();
    }




}