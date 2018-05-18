<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/7/2017
 * Time: 1:49 PM
 */

class YihuaPostTime
{
    private $db;
    private $timezone;
    private $error;


    public function __construct()
    {
        $this->db = new Database();

        if($this->initTimeZone())
        {
            return true;
        }

        return false;
    }

    private function initTimeZone()
    {
        $sql = "SELECT * FROM `site_profile` WHERE `config_name` LIKE 'time_zone'";
        $result = $this->db->query($sql);

        if (!$result) {
            $this->error = $this->db->error();
            return false;
        }

        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                $this->timezone = $row['config'];
                return true;
            }
        }

        $this->error = "No config_name from DB";

        return false;

    }

    public function getTimezone()
    {
        return $this->timezone;
    }

    public function getDate($format)
    {
        date_default_timezone_set("$this->timezone");
        $date = date($format);

        return $date;
    }

    public function error()
    {
        return $this->error;
    }



}