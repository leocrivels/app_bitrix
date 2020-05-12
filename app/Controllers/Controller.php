<?php 
namespace App\Controllers;

use \App\Models\Company;
use \App\Models\Contact;

class Controller
{
    /**
     * Lists All Companies
     *
     * @return void
     */
    public function index()
    {
        $Company = new Company;
        $Contact = new Contact();

        \App\View::make('Company.index', ['Company' => $Company,'Contact' => $Contact]);

    }


    /**
     * Shows Company Creation Form
     *
     * @return void
     */
    public function create()
    {
        \App\View::make('Company.create');
    }


    /**
     * Process Company Creation Form
     * If CPF already exists respective contact will be updated;
     * If CNPJ already exists respective company will be updated;
     * Else they are created;
     * 
     * Also add contact to company;
     * 
     * @return void
     */
    public function store()
    {
        // get form data
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $companyName = isset($_POST['companyName']) ? $_POST['companyName'] : null;
        $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
        $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
        $cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : null;

        $contact = Contact::selectByCPF($cpf)[0];
        $company = Company::selectByCNPJ($cnpj)[0];

        $companyId = isset($company["ID"])? $company["ID"] : null;
        $contactId = isset($contact["ID"])? $contact["ID"] : null;

        if($contactId){
            $result = Contact::update($contactId, $contact["UF_CRM_CPF"], $name, $email, $phone);
        } else{
            $contactId = Contact::save($name, $email, $phone, $cpf);
        }

        if($companyId){
            $result = Company::update($companyId, $company["UF_CRM_CNPJ"], $companyName, $company["REVENUE"]);
        } else{
            $companyId = Company::save($companyName, $cnpj);
        }

        if ($contactId) {
            if ($companyId) {
                Contact::addCompany($contactId, $companyId);
                header('Location: /');
                exit;
            }
        }

    }


    /**
     * Show company/contact edition form
     *
     * @param  mixed $id
     * @return void
     */
    public function edit($id)
    {
        $company = Company::selectById($id);

        \App\View::make('Company.edit', [
            'company' => $company,
        ]);
    }


    /**
     * Process company/contact edition form
     * And update company
     * 
     * @return void
     */
    public function update()
    {
        // pega os dados do formuário
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $companyName = isset($_POST['companyName']) ? $_POST['companyName'] : null;
        $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
        $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
        $cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : null;

        if (Company::update($id, $cnpj, $companyName)) {
            header('Location: /');
            exit;
        }
    }


    /**
     * remove company which ID == $id
     *
     * @param  mixed $id
     * @return void
     */
    public function remove($id)
    {
        if (Company::remove($id)) {
            header('Location: /');
            exit;
        }
    }
}