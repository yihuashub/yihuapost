<?php

if( isset($_POST['item']) ){ // secure script, works only if POST was made

    /*
    * Connect to Your databes
    */
    include('../../../config/config.php');

    $array_items = $_POST['item']; //array of items in the Unordered List
    $order = 0; //order number set to 0;
    $result = true;

    // IF CONNECTED run foreach loop

    $db = new Database();
    $finaldata = array();

    foreach ( $array_items as $item) {

        $update = "UPDATE web_index SET ord = '$order' WHERE ID='$item' "; // MYSQL query that: Update in db_table Order with value $order where rows id equals $item. $item is the number in index.php file: item-3.

        if ($db->query($update) === TRUE)
        {
            $order++; //increment order value by one;
        }
        else
        {
            $result = false;

        }
    }

    header('Access-Control-Allow-Credentials:false');
    header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
    header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
    header('Access-Control-Allow-Origin:*');
    header('Cache-Control:no-store, no-cache, must-revalidate');
    header('Content-Type: application/json');

    $finaldata= array("result" => $result);

    print json_encode($finaldata);

}
else
{
    echo "Powered by YIHUA POST";
}



