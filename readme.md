# Sobre
Este projeto se trata de um CRUD que se comunica com um portal bitrix24 através de sua api REST e seus Webhooks de Entrada e de Saída. 
O CRUD é responsável por criar, consultar, atualizar e deletar Empresas e Contatos.
Também é capaz de interceptar eventos do tipo "Negócio atualizado" e, caso seja ganho, somar o valor do negócio à receita da empresa relacionada.

# Comportamento
## Tela inicial
Lista todas as Empresas com seus respectivos contatos, com ações para editá-los ou remove-los.

## Tela de cadastro
Ao se entrar na tela de cadastro são requisitados os campos nome, nome da empresa, email, telefone, cnpj e cpf.
É feita uma verificação se o CNPJ já existe. 
Caso exista a empresa será atualizada com os novos dados de nome da empresa, caso não exista ela é criada.
É feita uma verificação se o CPF já existe. 
Caso exista o contato será atualizado com os novos dados de nome, email e telefone, caso não exista ele é criado.
No fim do processo o Contato é adicionado à empresa e vice-versa.

## Telas de edição
Apresenta os dados atuais da empresa ou contato em campos para alteração.

---

# Estrutura do projeto

```bash
app_bitrix
│
├───app
|   └───Controllers
│       └───Controller.php
│       └───ContactController.php
|   └───Handlers
│       └───DealHandler.php
|   └───Models
│       └───Company.php
│       └───Contact.php
│       └───Deal.php
|   └───Views
│       └───company.create.php
│       └───company.edit.php
│       └───company.index.php
│       └───contact.edit.php
│       └───template.php
|   └───helpers.php
|   └───View.php
│
├───composer.json
├───composer.lock
├───index.php
├───init.php
├───README.md
│
```
---
# WebHooks
Webhooks são utilizados para enviar e receber requisições do bitrix24.

## Webhook de Entrada
Webhooks de entrada permitem o acesso à api do bitrix24, cujas funções utilizadas foram:

Contatos | Empresas | Negócios
:---: | :---: | :---:
crm.contact.list | crm.company.list | crm.deal.get
crm.contact.get | crm.company.get 
crm.contact.add | crm.company.add 
crm.contact.update | crm.company.update
crm.contact.delete | crm.company.delete
crm.contact.company.add | crm.company.contact.add
crm.contact.userfield.list | crm.company.userfield.list
crm.contact.userfield.add  | crm.company.userfield.add
                            | crm.company.contact.items.get |

## Webhook de Saída
Webhooks de saída foram utilizados para criar um event listener para negócios atualizdos.
Caso o negócio seja ganho soma o valor do negócio à receita da empresa relacionada.

---
