<?php 
namespace App\Models;

class Contact
{
    /**
     * Gets all Contacts
     *
     * @return void
     */
    public static function selectAll()
    {
        $data = array(
            'filter' => array(),
            'select' => array("ID", "NAME", "UF_CRM_CPF", "EMAIL", "PHONE")
        );

        $result = webHookCall('crm.contact.list.json', $data);

        return $result['result'];
    }

    /**
     * returns Contacts which ID == $id
     *
     * @param  mixed $id
     * @return void
     */
    public static function selectById($id)
    {
        $data = array('ID' => $id);

        $result = webHookCall('crm.contact.get.json', $data);

        return $result['result'];
    }

    /**
     * returns company which CPF == $cpf
     *
     * @param  mixed $cpf
     * @return void
     */
    public static function selectByCPF($cpf)
    {
        $data = array(
            'filter' => array("UF_CRM_CPF" => $cpf),
            'select' => array("ID", "NAME", "UF_CRM_CPF", "EMAIL", "PHONE")
        );

        $result = webHookCall('crm.contact.list.json', $data);

        return $result['result'];
    }

    /**
     * saves contact on bitrix
     *
     * @param  mixed $name
     * @param  mixed $email
     * @param  mixed $phone
     * @param  mixed $cpf
     * @return void
     */
    public static function save($name, $email, $phone, $cpf)
    {
        self::addCPFfield();

        $data = array(
            'fields' => array(
                "NAME" => $name,
                "EMAIL" => array(array("VALUE" => $email, "VALUE_TYPE" => "WORK")),
                "PHONE" => array(array("VALUE" => $phone, "VALUE_TYPE" => "WORK")),
                "UF_CRM_CPF" => $cpf,
                "OPENED" => "Y",
                "ASSIGNED_BY_ID" => 1,
                "TYPE_ID" => "CLIENT",
                "SOURCE_ID" => "SELF",
            ),
            'params' => array("REGISTER_SONET_EVENT" => "Y")
        );

        $result = webHookCall('crm.contact.add.json', $data);

        return $result['result'];
    }



    /**
     * updates contact which ID == $id;
     * Can change any of it's attributes;
     * 
     * @param  mixed $id
     * @param  mixed $cpf
     * @param  mixed $name
     * @param  mixed $email
     * @param  mixed $phone
     * @return void
     */
    public static function update($id, $cpf = null, $name = null, $email = null, $phone = null)
    {
        $data = array(
            "ID" => $id,
            "fields" => array()
        );

        if ($name) {
            $data["fields"]["NAME"] = $name;
        }

        if ($cpf) {
            $data["fields"]["UF_CRM_CPF"] = $cpf;
        }

        if ($email) {
            $data["fields"]["EMAIL"] = $email;
        }

        if ($phone) {
            $data["fields"]["PHONE"] = $phone;
        }

        writeToLog($data, "DATA");

        $result = webHookCall('crm.contact.update.json', $data);

        return $result['result'];
    }


    /**
     * removes contact which ID==$id from bitrix
     *
     * @param  mixed $id
     * @return void
     */
    public static function remove($id)
    {
        $data = array('ID' => $id);

        $result = webHookCall('crm.contact.delete.json', $data);

        return $result;
    }

    /**
     * adds a company to a Contact, with their respective IDs
     *
     * @param  mixed $id
     * @param  mixed $companyId
     * @return void
     */
    public static function addCompany($id, $companyId)
    {
        writeToLog($id . ' ' . $companyId, '$contactId,$companyId');
        $data = array(
            'id' => $id,
            'fields' => array(
                "COMPANY_ID" => $companyId,
            )
        );
        webHookCall('crm.contact.company.add.json', $data);
    }


    /**
     * Check if the field CPF already exists on bitrix
     * if not it will be created
     * @return void
     */
    private static function addCPFfield()
    {
        $data = array(
            "order" => array("SORT" => "ASC"),
            "filter" => array("FIELD_NAME" => "UF_CRM_CPF")
        );
        $result = webHookCall("crm.contact.userfield.list.json", $data);
        if (!$result['result']) {
            $data = array(
                "fields" => array(
                    "FIELD_NAME" => "CPF",
                    "EDIT_FORM_LABEL" => "CPF",
                    "LIST_COLUMN_LABEL" => "CPF",
                    "USER_TYPE_ID" => "string",
                    "XML_ID" => "CPF",
                    "SETTINGS" => array("DEFAULT_VALUE" => "")
                )
            );
            webHookCall("crm.contact.userfield.add.json", $data);
        }
    }
}