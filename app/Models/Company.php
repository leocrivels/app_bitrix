<?php 
namespace App\Models;


class Company
{ 

    /**
     * Gets all Companies
     *
     * @return void
     */
    public static function selectAll()
    {
        $data = array(
            'filter' => array(),
            'select' => array("ID", "TITLE", "UF_CRM_CNPJ", "REVENUE")
        );

        $result = webHookCall('crm.company.list.json', $data);

        return $result['result'];
    }
    
    /**
     * returns company which ID == $id
     *
     * @param  mixed $id
     * @return void
     */
    public static function selectById($id)
    {
        $data = array('ID' => $id);

        $result = webHookCall('crm.company.get.json', $data);

        return $result['result'];
    }
    
    /**
     * returns company which CNPJ == $cnpj
     *
     * @param  mixed $cnpj
     * @return void
     */
    public static function selectByCNPJ($cnpj)
    {
        $data = array(
            'filter' => array("UF_CRM_CNPJ" => $cnpj),
            'select' => array("ID", "TITLE", "UF_CRM_CNPJ", "REVENUE")
        );

        $result = webHookCall('crm.company.list.json', $data);

        return $result['result'];
    }


    /**
     * saves company on bitrix
     *
     * @param  mixed $companyName
     * @param  mixed $cnpj
     * @return void
     */
    public static function save($companyName, $cnpj)
    {
        self::addCNPJfield();

        $data = array(
            'fields' => array(
                "TITLE" => $companyName,
                "OPENED" => "Y",
                "ASSIGNED_BY_ID" => 1,
                "SOURCE_ID" => "SELF",
                "UF_CRM_CNPJ" => $cnpj,
                "CURRENCY_ID" => "BRL",
                "REVENUE" => "0.0"
            ),
            'params' => array("REGISTER_SONET_EVENT" => "Y")
        );

        $result = webHookCall('crm.company.add.json', $data);

        return $result['result'];
    }



    /**
     * updates company which ID == $id;
     * Can change any of it's attributes;
     *
     * @param  mixed $id
     * @param  mixed $cnpj
     * @param  mixed $companyName
     * @param  mixed $revenue
     * @return void
     */
    public static function update($id, $cnpj = null, $companyName = null, $revenue = null)
    {
        $data = array(
            "ID" => $id,
            "fields" => array()
        );

        if ($companyName) {
            $data["fields"]["TITLE"] = $companyName;
        }
        if ($revenue) {
            $data["fields"]["REVENUE"] = $revenue;
        }
        if ($cnpj) {
            $data["fields"]["UF_CRM_CNPJ"] = $cnpj;
        }

        $result = webHookCall('crm.company.update', $data);
        return $result['result'];
    }

    
    /**
     * removes company which ID==$id from bitrix
     *
     * @param  mixed $id
     * @return void
     */
    public static function remove($id)
    {
        $data = array('ID' => $id);

        $result = webHookCall('crm.company.delete.json', $data);

        return $result;
    }
    
    /**
     * adds a Contact to a company, with their respective IDs
     *
     * @param  mixed $id
     * @param  mixed $contactId
     * @return void
     */
    public static function addContact($CompanyId, $contactId)
    {
        $data = array(
            'id' => $CompanyId,
            'fields' => array(
                "CONTACT_ID" => $contactId,
            )
        );
        webHookCall('crm.company.contact.add.json', $data);
    }
    
    /**
     * Check if the field CNPJ already exists on bitrix
     * if not it will be created
     *
     * @return void
     */
    private static function addCNPJfield()
    {
        $data = array(
            "order" => array("SORT" => "ASC"),
            "filter" => array("FIELD_NAME" => "UF_CRM_CNPJ")
        );
        $result = webHookCall("crm.company.userfield.list.json", $data);
        if (!$result['result']) {
            $data = array(
                "fields" => array(
                    "FIELD_NAME" => "CNPJ",
                    "EDIT_FORM_LABEL" => "CNPJ",
                    "LIST_COLUMN_LABEL" => "CNPJ",
                    "USER_TYPE_ID" => "string",
                    "XML_ID" => "CNPJ",
                    "SETTINGS" => array("DEFAULT_VALUE" => "")
                )
            );
            webHookCall("crm.company.userfield.add.json", $data);
        }
    }
    
    /**
     * sums value to Company's revenue
     *
     * @param  mixed $id
     * @param  mixed $revenue
     * @return void
     */
    public static function sumRevenueToCompany($id, $revenue)
    {
        writeToLog($id, 'SUM ID');
        $company = self::selectById($id);
        writeToLog($company, 'SUM COMPANY');

        $revenue = floatval($revenue) + floatval($company["REVENUE"]);

        self::update($company['ID'], $company["UF_CRM_CNPJ"], $company["TITLE"], strval($revenue));
    }
    
    /**
     * get Contacts of a Company ID
     *
     * @param  mixed $id
     * @return void
     */
    public static function getContacts($id)
    {
        $data = array('ID'=>$id);

        $result = webHookCall('crm.company.contact.items.get',$data);

        return $result['result'];
    }
}