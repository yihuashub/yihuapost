<?php

function getGoableSiteName($siteLanguage)
{
    $db = new Database();
    $options = (getLangCode($siteLanguage) == 0) ? 'site_name' : 'site_name_en';

    $sql = "SELECT * FROM site_profile WHERE config_name LIKE '$options'";

    $result = $db->query($sql);


    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['config'];
        }

    }
}

function getSiteKeywords($siteLanguage)
{
    $db = new Database();
    $options = (getLangCode($siteLanguage) == 0) ? 'keywords' : 'keywords_en';

    $sql = "SELECT * FROM site_profile WHERE config_name LIKE '$options'";

    $result = $db->query($sql);


    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['config'];
        }

    }}

function getSiteDescription($siteLanguage)
{
    $db = new Database();
    $options = (getLangCode($siteLanguage) == 0) ? 'description' : 'description_en';

    $sql = "SELECT * FROM site_profile WHERE config_name LIKE '$options'";

    $result = $db->query($sql);


    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['config'];
        }

    }
}

function getChatJS()
{
    $db = new Database();

    $sql ="SELECT * FROM site_profile WHERE config_name LIKE 'chat_js'";

    $result = $db->query($sql);


    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            echo $row['config'];
        }

    }
}

function getCopyright($siteLanguage)
{
    $db = new Database();
    $options = (getLangCode($siteLanguage) == 0) ? 'copyright' : 'copyright_en';

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

function getLocation()
{
    $db = new Database();

    $sql ="SELECT * FROM site_profile WHERE config_name LIKE 'location'";

    $result = $db->query($sql);


    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            return $row['config'];
        }

    }
}

function getAboutus($siteLanguage)
{
    $db = new Database();

    $sql ="SELECT * FROM site_profile WHERE config_name LIKE 'aboutus'";

    $result = $db->query($sql);


    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            return $row['config'];
        }

    }
}

function getPhone()
{
    $db = new Database();

    $sql ="SELECT * FROM site_profile WHERE config_name LIKE 'phone'";

    $result = $db->query($sql);


    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            return $row['config'];
        }

    }
}

function getLangCode($lang)
{
    if(strcmp($lang,'zh') == 0)
    {
        return 0;
    }
    else{
        return 1;
    }
}