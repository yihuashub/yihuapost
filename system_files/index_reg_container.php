<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 2017-06-13
 * Time: 3:25 PM
 */

function echoRegContainer()
{
    $db = new Database();


    $sql = "SELECT auto_ID, title,price, auto_kilometre,auto_transmission,main_pic FROM web_auto WHERE status = 1 LIMIT 4";

    $result = $db->query($sql);




    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $autoID= $row["auto_ID"];
            $autoTitle = $row["title"];
            $autoPrice = $row["price"];
            $autoKilometre = $row["auto_kilometre"];
            $autoTransmission = $row['auto_transmission'];
            $autoSatus = 'For Sale';


            $mainPic = getMainPic($row['main_pic']);


            if($mainPic)
            {
                echo "                
                <div class=\"card no-paddding margin-bottom-30\">
                <a href=\"auto.php?auto=$autoID\">
                    <div class=\"col-xs-6 col-md-5 no-paddding\">
                        <img src=\"./upload/files/$mainPic\" class=\"img-responsive card-img\" alt=\"Responsive image\">
                    </div>
                </a>
                    <div class=\"col-xs-6 col-md-7 pull-right  margin-top-20\">";




                echo "
                        <a href=\"auto.php?auto=$autoID\"><h3>$autoTitle</h3></a>
                        <div class=\"margin-top-20\">          
                            <strong>Status: $autoSatus</strong></br>
                            <strong>Price: $autoPrice</strong></br>
                            <strong>Transmission: $autoTransmission</strong></br>
                            <strong>Kilometre: $autoKilometre</strong></br>";
                echo "<hr>";



                echo "                        
                        </div>
                    </div>
                </div>";

            }
            else{
                echo $mainPic;
            }



        }

    }

}


function getMainPic($id)
{
    $db = new Database();


    $sql = "SELECT * FROM image_files WHERE id = $id";

    $result = $db->query($sql);


    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            return $row['name'];
        }

    }

    return false;
}

function echoRegIcon($title,$imageID,$url,$price,$type,$db)
{
    echo "
       <div class=\"swiper-slide special-live-item item\">
            <a href=\"".$url."\">
                <div class=\"live-pic\">";

    getImageUrl($db,$imageID);
    if(strcmp($type,'NULL') == 0)
    {
        echo "             <div class=\"\">";
    }
    else{
        echo "             <div class=\"live-icon ".$type."\">";
    }

    
    echo "      </div>
                </div>
                <div class=\"live-detail\">
                    <p class=\"subject\">".$title."</p> <!---->
                    <p class=\"live-status live-price\">".$price."</p>
                </div>
            </a>
        </div>";
}


function echoRegTitle($topicTitle,$moreUrl)
{
    echo "
    
        <div class=\"col-lg-12 col-md-12\">
            <div class=\" col-lg-6 col-md-6 col-sm-6 col-xs-6 rock\">
                <h5>".$topicTitle."</h5>
            </div>
            <div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6 rock\">
                <h4>
                    <a href=\"".$moreUrl."\">
                        <div class=\"pull-right more-txt\">更多></div>
                    </a>
                </h4>
            </div>
        </div>
      ";
}


function getImageUrl($db,$imageID)
{
    $sql = "SELECT name FROM image_files WHERE id = '$imageID'";

    $result = mysqli_query($db, $sql);


    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            echo   "<img src=upload/files/".$row["name"].">";


        }

    }
}