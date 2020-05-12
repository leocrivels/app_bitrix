<h2>Contact Edition</h2>



<form action="/edit/contact" method="post">
    <label for="name">Name: </label>
    <input type="text" name="name" id="name" value="<?php echo $contact['NAME']; ?>">

    <label for="cpf">CPF: </label>
    <input type="text" name="cpf" id="cpf" placeholder="xx.xxx.xxx/xxxx-xx"
        value="<?php echo $contact['UF_CRM_CPF']; ?>">

    <label for="email">Email: </label>
    <input type="text" name="email" id="email" value="<?php echo $contact['EMAIL'][0]['VALUE']; ?>">

    <label for="phone">Phone: </label>
    <input type="text" name="phone" id="phone" value="<?php echo $contact['PHONE'][0]['VALUE']; ?>">

    <input type="hidden" name="id" value="<?php echo $contact['ID'] ?>">

    <input type="submit" value="Editar">
</form>