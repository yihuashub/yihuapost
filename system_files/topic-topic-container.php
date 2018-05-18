<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 6/29/2017
 * Time: 1:26 AM
 */

function echoTopicContainer($topicId,$db)
{
    echoTopicIconContainer($topicId,$db);
    echo "<hr>";
}


function echoTopicIconContainer($topicId,$db){

    $sql = "SELECT img_ID, url FROM web_course_list WHERE topic_id = 1";

    $result = mysqli_query($db, $sql);

    echo "
    <div class=\"container-fluid text-center\">
    <div class=\"row\">
        <div class=\"col-lg-8 col-md-offset-2\">";

    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $url = $row["url"];
            $imgID = $row["img_ID"];

            echo echoTopicIconItem($db,$imgID, $url);
        }
    }

    echo "        </div>
    </div>
</div>";

}

function echoTopicIconItem($db,$imgID, $url){


    $sql = "SELECT * FROM image_files WHERE id = $imgID";

    $result = mysqli_query($db, $sql);

    echo "
        <div class=\"col-lg-6 col-xs-12 topic-show\">
            <a href=\"".$url."\">";
    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $name = "upload/files/".$row['name'];

            echo "<img src=\" $name \" alt=\"Cinque Terre\" />";

        }
    }
    echo "
            </a>
        </div>";
}

