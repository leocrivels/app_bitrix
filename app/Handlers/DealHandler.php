<?php
namespace App\Handlers;

use App\Models\Deal;
use App\Models\Company;

class DealHandler
{    
    /**
     * Handles all deal updates, if won it'll add
     * the opportunity to the related company revenue
     *
     * @param  mixed $request
     * @return void
     */
    public static function dealUpdated($request)
    {
        $token = "d823ruem0j6aw7j5zze2jgo432vq58fm";

        $authorized = $_REQUEST["auth"]["application_token"] == $token;

        if (($_REQUEST["event"] == "ONCRMDEALUPDATE") && $authorized) {

            $id = $_REQUEST["data"]["FIELDS"]["ID"];

            $deal = Deal::selectById($id);
            
            if ($deal["STAGE_ID"] == "WON") {
                Company::sumRevenueToCompany($deal["COMPANY_ID"], $deal["OPPORTUNITY"]);
            }
        }

    }
}