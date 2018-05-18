<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 11/11/2017
 * Time: 8:49 PM
 */

class HomeClass
{
    private $lang;
    private $db;

    public function __construct($lang,$db) {
        (empty($db)) ? $this->db = new Database() : $this->db =$db;
        $this->lang = $lang;
    }

    public function getHotIndex()
    {
        $select = "SELECT * FROM web_index ORDER BY ord ASC"; // select every element in the table in order by order column

        $mResult = $this->db->query($select);
        $dataArray = array();

        if ($mResult && mysqli_num_rows($mResult) > 0)
        {
            while ($array = mysqli_fetch_assoc($mResult))
            {
                $mHouse = new House($this->lang,$this->db);

                if($mHouse->createDataById($array['container_id']))
                {
                    array_push($dataArray,$mHouse);
                }
            }

            return $dataArray;
        }
        else{
            return false;
        }
    }
}