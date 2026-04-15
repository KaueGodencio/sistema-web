Processo de Criação 

O projeto foi inicializado utilizando comando dos propio laravel versão 11 

composer create-project laravel/laravel sistema-web  "11.*"

Configuração de Dados: Criação do banco de dados relacional via phpMyAdmin com o nome (sistema_web).
Ambiente: Configuração do arquivo .env para apontar para a conexão local.

Banco de dados tabelas principais:

*   **`fornecedores`**: Armazena os dados das entidades que fornecem produtos.
    *   `nome`: Nome ou Razão Social.
    *   `cnpj`: Identificação fiscal.
    *   `email` / `telefone`: Dados de contato.
    *   `status`: Controla se o fornecedor está Ativo ou Inativo.
*   **`produtos`**: Catálogo de itens disponíveis para compra.
    *   `nome`: Nome comercial do produto.
    *   `descricao`: Detalhes técnicos ou adicionais.
    *   `codigo_interno`: Identificador único para controle de estoque/inventário.
    *   `status`: Ativo/Inativo.

*   **`pedidos`**: Registra as intenções de compra.
    *   `fornecedor_id`: Chave estrangeira ligando o pedido a um fornecedor específico.
    *   `data_pedido`: Data em que a ordem foi gerada.
    *   `status`: Ciclo de vida do pedido (Aberto, Processando, Concluído, Cancelado).
    *   `observacoes`: Campo de texto livre para anotações.

*   **`itens_pedido`**: Tabela de detalhes que compõe cada pedido (Relacionamento 1:N com Pedidos).
    *   `pedido_id`: Vinculação com o pedido pai.
    *   `produto_id`: Vinculação com o produto selecionado.
    *   `quantidade`: Quantidade do item no pedido.
    *   `valor_unitario`: Preço unitário no momento da compra.
    *   `valor_total`: Cálculo automático (`quantidade` * `valor_unitario`).

Relacionamentos tabelas:
 Criei a tabela `fornecedor_produto` para permitir que um produto seja vinculado a vários fornecedores e vice-versa 
 Um fornecedor possui muitos pedidos; um pedido possui muitos itens.


Estrutura MVC 

Models 
Eloquent ORM para abstrair as queries SQL. Foram definidos relacionamentos como `belongsTo`, `hasMany` e `belongsToMany` 

Controllers 
Os controladores gerenciam a lógica

Views 
As views foram construídas com Blade
Usado o CSS (Bootstrap 4.6), FontAwesome


Fluxo de Desenvolvimento


Primeiro, definimos os caminhos de URL .
Criação das tabelas no banco de dados via migrations para receber informações.
Criei as interfaces visuais primeiro 
Implemenação da lógica nos controladores.
Optei por utilizar os próprios recursos de filtro das tabelas (via JavaScript e DataTables/Bootstrap), sem criar controladores específicos para simplificar 

Decisões de Design e UX

Bootstrap 4.6 pois tenho mais agilidade nas class.
Sidebar com Menu Hambúrguer pensando em responsividade
Useiícones da sidebar e estados ativos para criar uma identidade visual coerente e premium.


Cálculos Dinâmicos com JavaScript Puro mesmo no cadastro de pedidos, para calcular o valor total de cada item e o valor geral do pedido em tempo real.







