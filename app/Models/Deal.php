<?php
namespace App\Models;

class Deal
{
        
    /**
     * returns a deal which ID == $id
     *
     * @param  mixed $id
     * @return void
     */
    public static function selectById($id)
    {
        $data = array("ID" => $id);
        $result = webHookCall("crm.deal.get", $data);

        return $result['result'];
    }

}