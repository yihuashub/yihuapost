<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 2017-06-13
 * Time: 3:06 PM
 */


function echoSwiper($db)
{
    echo "
        <div id=\"banner-swiper\" class=\"swiper-container\">
        <div class=\"swiper-wrapper\" >";

    $sql = "SELECT * FROM img_banner";

    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            getBannerItem($db,$row['img_ID'],$row['url'],$row['text']);
        }

    }
    echo "</div>
        <!-- Add Pagination -->
        <div class=\"swiper-pagination\"></div>
    </div>
    ";
}

function getBannerItem($db,$imgID, $url,$text)
{


    $sql = "SELECT name FROM image_files WHERE id = $imgID";
    $imgName = "./upload/files/";

    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $imgName = $imgName.$row['name'];

            echo " 
    		<div class=\"swiper-slide\" style=\"width: 100%; height: 100%;background-image:url($imgName)\">
			    <a href=\"$url\" style=\"color:#fff;width:100%;height:300px;display:block\" target=\"_blank\">$text</a>
			</div>
            ";
        }

    }



}