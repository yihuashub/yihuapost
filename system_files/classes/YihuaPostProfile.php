<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/14/2017
 * Time: 12:08 PM
 */

class YihuaPostProfile
{
    private $lang;
    private $db;


    public function __construct($lang,$db) {
        (empty($db)) ? $this->db = new Database() : $this->db =$db;
        $this->lang = $lang;
    }

    public function getGoableSiteName()
    {
        $options = ($this->getLangCode($this->lang) == 0) ? 'site_name' : 'site_name_en';
        $sql = "SELECT * FROM site_profile WHERE config_name LIKE '$options'";
        $result = $this->db->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row['config'];
            }
        }
        return false;
    }

    public function getSiteKeywords()
    {
        $options = ($this->getLangCode($this->lang) == 0) ? 'keywords' : 'keywords_en';
        $sql = "SELECT * FROM site_profile WHERE config_name LIKE '$options'";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row['config'];
            }
        }
        return false;
    }

    public function getSiteDescription()
    {
        $options = ($this->getLangCode($this->lang) == 0) ? 'description' : 'description_en';
        $sql = "SELECT * FROM site_profile WHERE config_name LIKE '$options'";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row['config'];
            }
        }
        return false;
    }

    public function getChatJS()
    {
        $sql = "SELECT * FROM site_profile WHERE config_name LIKE 'chat_js'";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row['config'];
            }
        }
        return false;
    }

    public function getCopyright()
    {
        $db = new Database();
        $options = ($this->getLangCode($this->lang) == 0) ? 'copyright' : 'copyright_en';

        $sql ="SELECT * FROM site_profile WHERE config_name LIKE '$options'";

        $result = $db->query($sql);


        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                return $row['config'];
            }

        }
    }

    public function getLocation()
    {
        $sql = "SELECT * FROM site_profile WHERE config_name LIKE 'location'";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row['config'];
            }
        }
        return false;
    }

    public function getAddress()
    {
        $sql = "SELECT * FROM site_profile WHERE config_name LIKE 'address'";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row['config'];
            }
        }
        return false;
    }
    public function getAboutus()
    {
        $sql = "SELECT * FROM site_profile WHERE config_name LIKE 'aboutus'";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row['config'];
            }
        }
        return false;
    }

    public function getPhone()
    {
        $sql = "SELECT * FROM site_profile WHERE config_name LIKE 'phone'";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row['config'];
            }
        }
        return false;
    }

    public function getPhone2()
    {
        $sql = "SELECT * FROM site_profile WHERE config_name LIKE 'phone2'";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row['config'];
            }
        }
        return false;
    }

    public function getEmail()
    {
        $sql = "SELECT * FROM site_profile WHERE config_name LIKE 'email'";
        $result = $this->db->query($sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row['config'];
            }
        }
        return false;
    }

    private function getLangCode($lang)
    {
        if(strcmp($lang,'zh') == 0)
        {
            return 0;
        }
        else{
            return 1;
        }
    }
}