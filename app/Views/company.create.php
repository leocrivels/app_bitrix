<h2>Company/Contact Register</h2>



<form action="/add" method="post">
    <label for="name">Nome: </label>
    <input type="text" name="name" id="name">

    <label for="companyName">Nome da Empresa: </label>
    <input type="text" name="companyName" id="companyName">

    <label for="email">Email: </label>
    <input type="text" name="email" id="email">

    <label for="phone">Phone: </label>
    <input type="text" name="phone" id="phone">

    <label for="cnpj">CNPJ: </label>
    <input type="text" name="cnpj" id="cnpj" placeholder="xx.xxx.xxx/xxxx-xx">

    <label for="cpf">CPF: </label>
    <input type="text" name="cpf" id="cpf" placeholder="xxx.xxx.xxx-xx" required>

    <input type="submit" value="Cadastrar">
</form>