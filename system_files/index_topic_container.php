<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 2017-06-13
 * Time: 3:26 PM
 */


function echoBannerAuto($topicId,$db){
    $db = new Database();


    $sql = "SELECT ID, title,price, auto_kilometre,auto_transmission,main_pic,status FROM web_auto LIMIT 4";

    $result = $db->query($sql);




    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $autoTitle = $row["title"];
            $autoPrice = $row["price"];
            $autoKilometre = $row["auto_kilometre"];
            $autoTransmission = $row['auto_transmission'];
            $autoSatus = 'For Sale';

            if($row['status'] != 1)
            {
                $autoSatus = 'status code';
            }

            $mainPic = getMainPic($row['main_pic']);


            if($mainPic)
            {
                echo "                <div class=\"card no-paddding margin-bottom-30\">
                    <div class=\"col-xs-6 col-md-5 no-paddding\">
                        <img src=\"./upload/files/$mainPic\" class=\"img-responsive card-img\" alt=\"Responsive image\">
                    </div>
                    <div class=\"col-xs-6 col-md-7 pull-right  margin-top-20\">";




                echo "
                        <a href=\"detail.html\"><h3>$autoTitle</h3></a>
                        <div class=\"margin-top-20\">          
                            <strong>Status: $autoSatus</strong></br>
                            <strong>Price: $autoPrice</strong></br>
                            <strong>Transmission: $autoTransmission</strong></br>
                            <strong>Kilometre: $autoKilometre</strong></br>";
                echo "<hr>";



                echo "                        </div>
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

