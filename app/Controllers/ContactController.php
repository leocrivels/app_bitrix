<?php 
namespace App\Controllers;

use \App\Models\Company;
use \App\Models\Contact;

class ContactController
{
    /**
     * Show contact edition form
     *
     * @param  mixed $id
     * @return void
     */
    public function edit($id)
    {
        $contact = Contact::selectById($id);

        \App\View::make('Contact.edit', [
            'contact' => $contact,
        ]);
    }


    /**
     * Process contact edition form
     * And update contact
     * 
     * @return void
     */
    public function update()
    {
        // gets form data
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
        $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;

        if (Contact::update($id, $cpf, $name, $email, $phone)) {
            header('Location: /');
            exit;
        }
    }


    /**
     * remove contact which ID == $id
     *
     * @param  mixed $id
     * @return void
     */
    public function remove($id)
    {
        if (Contact::remove($id)) {
            header('Location: /');
            exit;
        }
    }
}