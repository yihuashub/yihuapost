<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 11/13/2017
 * Time: 8:52 PM
 */

class YihuaPostArticleArchive
{
    private $lang;
    private $langCode;

    private $year;
    private $month;
    private $countPost;


    public function __construct($lang,$variables) {
        $this->lang = $lang;

        $this->year = $variables['year'];
        $this->month = $variables['month'];
        $this->countPost = $variables['countpost'];

        if(strcmp($lang,'zh') == 0)
        {
            $this->langCode = 0;
        }
        else{
            $this->langCode = 1;
        }
    }

    public function getMonth()
    {
        if($this->langCode == 0)
        {
            setlocale(LC_TIME, 'zh_CN.UTF-8');
            return strftime('%B', mktime(0, 0, 0, $this->month));

        }

        return strftime('%B', mktime(0, 0, 0, $this->month));
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getPostCount()
    {
        return $this->countPost;
    }
}