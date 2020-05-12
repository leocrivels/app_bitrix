<?php 
$companies = $Company->selectAll();
if (count($companies) > 0) :
    foreach ($companies as $company) : ?>


<table width="50%" border="1" cellpadding="2" cellspacing="0" style="margin-bottom: 20px;background-color: #f2f2f2;">

    <thead>

        <tr style="background-color: #cccccc;">

            <th colspan="6">Company</th>

        </tr>

    </thead>


    <tbody>
        <?php //foreach ($companies as $company): ?>
        <tr>

            <th>ID</th>

            <th colspan="2">Company Name </th>

            <th>CNPJ</th>

            <th>REVENUE</th>

            <th>Actions</th>

        </tr>

        <tr>
            <td><?php echo $company['ID']; ?></td>

            <td colspan="2"><?php echo $company['TITLE']; ?></td>

            <td><?php echo $company['UF_CRM_CNPJ']; ?></td>

            <td><?php echo $company['REVENUE']; ?></td>


            <td>
                <a href="/edit/<?php echo $company['ID']; ?>">Edit</a>
                <a href="/remove/<?php echo $company['ID']; ?>"
                    onclick="return confirm('This action deletes the Company permanently. Are you Sure?');">Delete</a>
            </td>

        </tr>

        <tr>
            <th colspan="6" style="background-color: #cccccc;">Company Contacts</th>
        </tr>

        <tr>

            <th>C_ID</th>

            <th>Name</th>

            <th>E-mail</th>

            <th>CPF</th>

            <th>Phone</th>

            <th>Actions</th>

        </tr>

        <?php 
        $contacts = $Company->getContacts($company['ID']);
        foreach ($contacts as $contact) :
            $contact = $Contact->selectById($contact['CONTACT_ID']); ?>

        <tr>
            <td><?php echo $contact['ID']; ?></td>

            <td><?php echo $contact['NAME']; ?></td>

            <td><?php echo $contact['EMAIL'][0]['VALUE']; ?></td>

            <td><?php echo $contact['UF_CRM_CPF']; ?></td>

            <td><?php echo $contact['PHONE'][0]['VALUE']; ?></td>


            <td>
                <a href="/edit/contact/<?php echo $contact['ID']; ?>">Edit</a>
                <a href="/remove/contact/<?php echo $contact['ID']; ?>"
                    onclick="return confirm('This action deletes the contact permanently. Are you Sure?');">Delete</a>
            </td>

        </tr>

        <?php endforeach; ?>
    </tbody>

</table>
<?php endforeach; ?>

<?php else : ?>



No Company Registered


<?php endif; ?>
<form action="/add">
    <input type="submit" value="Add Company/Contact" />
</form>