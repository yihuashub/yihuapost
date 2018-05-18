<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 11/4/2017
 * Time: 10:00 PM
 */

class YihuaPost
{
    private $db;
    private $options;
    private $check;
    private $ID;
    private $errorMsg;
    private $message;

    public function __construct()
    {
        $this->db = new Database();
        $this->ID = 0;
        $this->check = true;
        $this->errorMsg = array();
        $this->options = array(
            "ID" => 0,
            "postTitle" => "",
            "postText" => "",
            "postSummaryText" => "",
            "postLang" => "",
            "postCate" => 0,
            "postStatus" => 1,
            "postAuthor" => 0,
            "postMainImage" => 0
        );
    }


    public function getPostType($lang)
    {
        $mLang = $this->getLangCode($lang);

        $sql = "SELECT * FROM yihua_posts_types WHERE lang = $mLang";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            $types = array();

            while ($rows = mysqli_fetch_assoc($result)) {
                    array_push($types,array('value'=>$rows['ID'],'name'=>$rows['name']));
            }
            return $types;
        }

        return false;
    }

    public function createPost($newOptions)
    {

        $mOptions = array(
            "postTitle" => "",
            "postText" => "",
            "postSummaryText" => "",
            "postLang" => "cn",
            "postCate" => 0,
            "postStatus" => 1,
            "postAuthor" => 0,
            "postMainImage" => 0
        );

        if (empty($newOptions["postTitle"])) {
            array_push($this->errorMsg, "请输入标题");
            $this->check = false;
        } else {
            $mOptions["postTitle"] = $this->limitLength($newOptions["postTitle"], 80);
        }

        if ($newOptions["postMainImage"] == 0) {
            $mOptions["postMainImage"] = 0;
            array_push($this->errorMsg, "请上传封面照片");
            $this->check = false;
        } else {
            $mOptions["postMainImage"] = $newOptions["postMainImage"];
        }

        if (empty($newOptions["postText"])) {
            array_push($this->errorMsg, "文章内容不能为空。");
            $this->check = false;
        } else {
            $mOptions["postText"] = $newOptions["postText"];
        }

        if (empty($newOptions["postAuthor"])) {
            array_push($this->errorMsg, "无法获取作者信息。");
            $this->check = false;
        } else {
            $mOptions["postAuthor"] = $newOptions["postAuthor"];
        }

        if (($newOptions["postCate"])==null) {
            array_push($this->errorMsg, "无法获取文章分类");
            $this->check = false;
        } else {
            $mOptions["postCate"] = $newOptions["postCate"];
        }

        $mOptions["postLang"] = $newOptions["postLang"];
        $mOptions["postStatus"] = $newOptions["postStatus"];

        if (empty($newOptions["postSummaryText"])) {
            $mOptions["postSummaryText"] = $this->limitLength(strip_tags($newOptions["postText"]), 150);
        } else {
            $mOptions["postSummaryText"] = $this->limitLength($newOptions["postSummaryText"], 150);
        }

        if ($this->check) {
            $this->options = $mOptions;
            return $this->saveToDB($mOptions);
        }
        else{
            $this->options = $mOptions;
            array_push($this->errorMsg, "系统错误，存储失败。");
            return false;
        }
    }

    private function saveToDB($mOptions)
    {
        $value1 = $mOptions["postTitle"];
        $value2 = $mOptions["postMainImage"];
        $value3 = $this->db->mysqli_real_escape_string($mOptions["postText"]);
        $value4 = $this->getLangCode($mOptions["postLang"]);
        $value5 = $mOptions["postStatus"];
        $value6 = $mOptions["postSummaryText"];
        $value7 = $mOptions["postAuthor"];
        $value8 = $mOptions["postCate"];

        $time = "";

        $getTime = new YihuaPostTime();

        if ($getTime) {
            $time = $getTime->getDate("Y-m-d H:i:s");
        }


        $sql = "INSERT INTO `yihua_posts` (`ID`, `post_author`, `post_date`, 
`post_content`, `post_main_image`, `post_title`, `post_summary`, `post_status`, `post_password`, `post_lang`, 
`post_name`,`post_category`) VALUES (NULL, '$value7', '$time', '$value3', '$value2', '$value1', '$value6', '$value5', '', '$value4', '',$value8);
";


        if ($this->db->query($sql) === TRUE) {
            $last_id = $this->db->insert_id();
            $this->message = "文章编号：" . $last_id . " 文章标题：" . $value1 . " 创建成功。";
            return true;
        } else {
            array_push($this->errorMsg, "$sql");
            array_push($this->errorMsg, $this->db->error());
            return false;
        }
    }

    public function updatePost($newOptions,$mID)
    {
        $mOptions = array(
            "postTitle" => "",
            "postText" => "",
            "postSummaryText" => "",
            "postLang" => "cn",
            "postCate" => 0,
            "postStatus" => 1,
            "postAuthor" => 0,
            "postMainImage" => 0
        );

        if ($mID == null) {
            array_push($this->errorMsg, "文章ID错误");
            $this->check = false;
        } else {
            $this->ID = $mID;
        }

        if (empty($newOptions["postTitle"])) {
            array_push($this->errorMsg, "请输入标题");
            $this->check = false;
        } else {
            $mOptions["postTitle"] = $this->limitLength($newOptions["postTitle"], 80);
        }

        if ($newOptions["postMainImage"] == 0) {
            $mOptions["postMainImage"] = 0;
            array_push($this->errorMsg, "请上传封面照片");
            $this->check = false;
        } else {
            $mOptions["postMainImage"] = $newOptions["postMainImage"];
        }

        if (empty($newOptions["postText"])) {
            array_push($this->errorMsg, "文章内容不能为空。");
            $this->check = false;
        } else {
            $mOptions["postText"] = $newOptions["postText"];
        }

        if (empty($newOptions["postAuthor"])) {
            array_push($this->errorMsg, "无法获取作者信息。");
            $this->check = false;
        } else {
            $mOptions["postAuthor"] = $newOptions["postAuthor"];
        }

        if (($newOptions["postCate"])==null) {
            array_push($this->errorMsg, "无法获取文章分类");
            $this->check = false;
        } else {
            $mOptions["postCate"] = $newOptions["postCate"];
        }

        $mOptions["postLang"] = $newOptions["postLang"];
        $mOptions["postStatus"] = $newOptions["postStatus"];

        if (empty($newOptions["postSummaryText"])) {
            $mOptions["postSummaryText"] = $this->limitLength(strip_tags($newOptions["postText"]), 150);
        } else {
            $mOptions["postSummaryText"] = $this->limitLength($newOptions["postSummaryText"], 150);
        }

        if ($this->check) {
            $this->options = $mOptions;
            return $this->updateToDB($mOptions);
        }
        else{
            $this->options = $mOptions;
            array_push($this->errorMsg, "系统错误，存储失败。");
            return false;
        }

    }

    private function updateToDB($mOptions)
    {
        $value1 = $mOptions["postTitle"];
        $value2 = $mOptions["postMainImage"];
        $value3 = $this->db->mysqli_real_escape_string($mOptions["postText"]);
        $value4 = $this->getLangCode($mOptions["postLang"]);
        $value5 = $mOptions["postStatus"];
        $value6 = $mOptions["postSummaryText"];
        $value8 = $mOptions["postCate"];


        $time = "";

        $getTime = new YihuaPostTime();

        if ($getTime) {
            $time = $getTime->getDate("Y-m-d H:i:s");
        }

        $sql ="UPDATE `yihua_posts` SET `post_category` = '$value8', `post_content`
 = '$value3', `post_main_image` = '$value2', `post_title` = '$value1', `post_summary` = '$value6', `post_status` = '$value5',
  `post_lang` = '$value4', `update_date` = '$time' WHERE ID = $this->ID";


        if ($this->db->query($sql) === TRUE) {
            $last_id = $this->db->insert_id();
            $this->message = "文章编号：" . $last_id . " 文章标题：" . $value1 . " 修改成功。";
            return true;
        } else {
            array_push($this->errorMsg, "$sql");
            array_push($this->errorMsg, $this->db->error());
            return false;
        }
    }

    public function getOptions()
    {
        return $this->options;
    }

    private function limitLength($orgString, $limit)
    {
        $mString = $orgString;
        if (strlen($mString) > $limit) {
            $mString = substr($mString, 0, $limit);
        }

        return $mString;
    }

    public function getErrorMessage()
    {
        return $this->errorMsg;
    }

    public function getMessage()
    {
        return $this->message;
    }


    private function getLangCode($lang)
    {
        if(strcmp($lang,'cn') == 0)
        {
            return $mLang = 0;
        }
        else if(strcmp($lang,'en') == 0)
        {
            return $mLang = 1;
        }
    }

    private function getDeLangCode($lang)
    {
        if($lang == 0)
        {
            return "cn";
        }
        else if($lang == 1)
        {
            return "en";
        }
    }


    //get functions

    public function getPostList()
    {
        $getAllPost = "SELECT * FROM yihua_posts";
        $result = $this->db->query($getAllPost);

        $postArray = array();
        if (mysqli_num_rows($result) > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $mOptions = array();
                $mOptions["ID"] = $rows['ID'];
                $mOptions["postTitle"] = $rows['post_title'];
                $mOptions["postMainImage"] = $rows['post_main_image'];
                $mOptions["postText"] = $rows['post_content'];
                $mOptions["postLang"] = $this->getDeLangCode($rows["post_lang"]);
                $mOptions["postStatus"] = $rows['post_status'];
                $mOptions["postSummaryText"] = $rows['post_summary'];
                $mOptions["postAuthor"] = $rows['post_author'];
                $mOptions["postCate"] = $rows['post_category'];
                $mOptions["postDate"] = $rows['post_date'];

                array_push($postArray, $mOptions);
            }

            return $postArray;
        }
        return false;
    }

public function newPostById($mId)
{
    $getPost = "SELECT * FROM yihua_posts WHERE ID = $mId";
    $result = $this->db->query($getPost);

    if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
            $this->options["ID"] = $rows['ID'];
            $this->options["postTitle"] = $rows['post_title'];
            $this->options["postText"] = $rows['post_content'];
            $this->options["postSummaryText"] = $rows['post_summary'];
            $this->options["postCate"] = $rows['post_category'];
            $this->options["postStatus"] = $rows['post_status'];
            $this->options["postAuthor"] = $rows['post_author'];
            $this->options["postMainImage"] = $rows['post_main_image'];
            $this->options["postDate"] = $rows['post_date'];
            $this->options["postLang"] = $this->getDeLangCode($rows["post_lang"]);
        }
        return true;
    }
    return false;
}

public function getPosId()
    {
        return $this->options["ID"];
    }

    public function getTitle()
    {
        return $this->options["postTitle"];
    }


    public function getLangString($langCode)
    {
        return $this->getDeLangCode($langCode);
    }


    private function deleteImages()
    {
        $result = true;
        $imageID = $this->options['postMainImage'];

        $sql = "SELECT * FROM image_files WHERE id = $imageID";

        $sqlResult = $this->db->query($sql);

        if (mysqli_num_rows($sqlResult) > 0) {
            while ($row = mysqli_fetch_assoc($sqlResult)) {

                $result = $this->deleteImg($row['name']);
                if($result)
                {
                    $deleteSql = "DELETE FROM image_files WHERE id =$imageID";

                    if (!$this->db->query($deleteSql))
                    {
                        $result = false;
                    }
                }

            }
        }
        return $result;

    }

    private function deleteImg($file)
    {
        $result = $this->deleteSystemImg('../../../upload/files/',$file);
        if($result)
        {
            return $this->deleteSystemImg('../../../upload/files/thumbnail/',$file);
        }
        return $result;
    }

    private function deleteSystemImg($path,$file)
    {
        $result = true;
        $filename = $path.$file;
        if(file_exists($filename))
        {
            if(!unlink($filename))
            {
                $result = false;
            }
        }
        else{
            $result = false;
        }
        return $result;
    }

    public function deleteSelf()
    {
        $result = $this->deleteImages();
        $postID = $this->options['ID'];

        if ($result) {
            $deleteSql = "DELETE FROM yihua_posts WHERE ID =$postID";

            if (!$this->db->query($deleteSql)) {
                $result = false;
            }
        }

        return $result;
    }
}