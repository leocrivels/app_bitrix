<h2>Company Edition</h2>



<form action="/edit" method="post">
    <label for="companyName">Company Name: </label>
    <input type="text" name="companyName" id="companyName" value="<?php echo $company['TITLE']; ?>">

    <label for="cnpj">CNPJ: </label>
    <input type="text" name="cnpj" id="cnpj" placeholder="xx.xxx.xxx/xxxx-xx"
        value="<?php echo $company['UF_CRM_CNPJ']; ?>">

    <input type="hidden" name="id" value="<?php echo $company['ID'] ?>">

    <input type="submit" value="Editar">
</form>