# Athernos

### Um projeto de controle de estoque feito para um trabalho de faculdade.

## Membros:

- João Vitor Neves Marques
- Danilo do Prado Souza [https://github.com/Daanilooo]

## Linguagens Utilizadas:

- HTML
- PHP
- JavaScript
  - Jquery
  - Chart.js (Criação dos Graficos)
- Bootstrap (Para geração de Modais)
- SASS (Pré processador CSS)

## Requisitos:

- Pasta `arquivos` contém o banco de dados, arquivos CSV para importação junto com login e senha para o sistema.

## Como Utilizar:

- Abrindo o sistema irá cair na tela de login, preencher com os dados para acesso disponivel na pasta `arquivos`.
- Logando no sistema irá cair na tela inicial, onde contém um dashboard com a quantidade de produtos cadastrados, quantidade de produtos por categoria e um resumo das últimas entradas e saídas.
- Em todas as páginas haverá um menu lateral, com os links de navegação:
  - **Dashboard**, tela inicial onde já estará.
  - **Produtos** (com 6 submenus):
    - **Listar Produtos**. Uma tela onde mostrará uma listagem de todos os produtos cadastrados com: ID, Código, Nome, Categorias, Quantidade, Custo Unitário, Menor Validade, Maior Validade, um botão de editar (que ira abrir uma página onde irá alterar os dados do produto especifico) e um '+' para visualizar os lotes de entrada daquele produto em específico, junto com um input de filtro e um botão de limpar filtro
    - **Importar Planilha**. Uma tela onde você pode importar planilhas de produtos (tem exemplos de planilhas disponível na pasta `arquivos`).
    - **Cadastrar Produtos**. Uma tela onde você poderá cadastrar novos produtos com Código (do fornecedor), Nome e sua respectiva categoria, tendo um botão '+' onde poderá cadastrar novas categorias.
    - **Entrada de Produtos**. Uma tela onde poderá dar entrada de lotes nos produtos já cadastrados, inserindo valores como: O produto que quer dar entrada, Custo Unitário, Quantidade e Validade.
    - **Saída de Produtos**. Uma tela onde você insere o produto por ID, e consequentemente ele completará com os dados dele (Código e Nome), ai só escolher o lote que deseja dar baixa e a quantidade da baixa.
    - **Relatório de Entrada/Saída**. Uma tela onde mostra todas as entradas e saídas do sistema, com o Tipo da Transação, ID do Produto, Nome, ID do lote, Quantidade e Data da transação.
  - **Usuarios** (com 2 submenus):
    - **Listar Usuarios**. Uma tela onde mostrará uma listagem de todos os usuarios cadastrados no sistema com: ID, Email, Nome, Nível (Administrador, Editor e Normal) e um botão para editar as informações.
    - **Cadastrar Usuario**. Uma tela onde você poderá cadastrar novos usuarios com Email, Nome, senha e o tipo de usuario que é.
  - Na parte de baixo do menu lateral tem opção de _minha conta_ onde poderá editar os dados da conta até como redefinir senha, e um botão de _logout_.

OBS: Todas essas telas são relacionadas ao nível Administrador. Algumas telas não aparecem devido ao nível do usuario.
