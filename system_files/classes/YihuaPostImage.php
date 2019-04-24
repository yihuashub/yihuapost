<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 11/11/2017
 * Time: 11:10 PM
 */

class YihuaPostImage
{
    private $imageId;
    private $postId;
    private $db;

    private $filename;
    public function __construct($db) {
        (empty($db)) ? $this->db = new Database() : $this->db =$db;
    }

    public function getSingleImage($id)
    {
        $this->imageId = $id;

        $sql = "SELECT * FROM image_files WHERE id=$this->imageId";

        $result = $this->db->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->filename = $row['name'];
                return true;

            }
        }
        else {
            return false;
        }
    }

    public function getPostImageArray($pid)
    {
        $this->postId = $pid;

        $sql = "SELECT * FROM image_files WHERE pid=$this->postId";

        $array = array();
        $result = $this->db->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($array,$row['id']);
            }
            return $array;
        }
        else {
            return false;
        }
    }

    public function getFilename()
    {
        return rawurlencode($this->filename);
    }

    public function getFilePath()
    {
        $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";

        return     $rootUrl."upload/files/".$this->getFilename();
    }

    public function getThumbnailFilePath()
    {
        $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";

        return     $rootUrl."upload/files/thumbnail/".$this->getFilename();
    }

}