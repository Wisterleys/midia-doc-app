# Sistema de Gerenciamento de Documentos

Este projeto é uma solução robusta e eficiente para o gerenciamento de documentos, desenvolvida em Laravel 12 com o auxílio do Laravel Sail para orquestração de containers Docker. O sistema foi concebido para atender aos requisitos de um teste técnico desafiador, com foco na criação, edição, visualização e download seguro de termos de responsabilidade personalizados.

## Propósito do Sistema

O principal objetivo deste sistema é simplificar e automatizar o processo de emissão de termos de responsabilidade para equipamentos, como notebooks e seus acessórios. Ele permite que usuários cadastrados gerenciem seus próprios documentos, garantindo a privacidade e a integridade dos dados. A funcionalidade de geração dinâmica de documentos em formatos DOCX e PDF, preenchidos com informações específicas do usuário e do equipamento, é um diferencial que otimiza a operação e reduz a carga administrativa.

## Funcionalidades Implementadas

Com base nos requisitos do teste técnico e nas melhorias contínuas, as seguintes funcionalidades foram implementadas:

*   **Autenticação e Autorização de Usuários**: Sistema completo de cadastro, login e logout de usuários, garantindo que cada usuário acesse apenas os documentos que criou.
*   **Gerenciamento de Documentos**: Interface intuitiva para visualizar, adicionar, editar e remover documentos. Cada documento está associado a um usuário específico e a um equipamento (notebook) com seus respectivos acessórios.
*   **Geração Dinâmica de Termos de Responsabilidade**: Capacidade de gerar termos de responsabilidade preenchidos automaticamente a partir de um modelo (`Anexo1.docx`). As informações do usuário (nome, função, CPF) e do equipamento (marca, modelo, número de série, processador, memória, disco, preço) são inseridas dinamicamente no documento.
*   **Download em Múltiplos Formatos**: Os termos de responsabilidade podem ser baixados tanto em formato DOCX (Word) quanto em PDF, oferecendo flexibilidade ao usuário. A conversão de DOCX para PDF é realizada internamente, garantindo a fidelidade do layout.
*   **Gestão de Acessórios e Periféricos**: Adição dinâmica de uma tabela no termo de responsabilidade para listar acessórios e periféricos entregues junto ao notebook, conforme solicitado como requisito diferencial.
*   **Filtros de Pesquisa Avançados**: Implementação de filtros de pesquisa na listagem de documentos por nome, função e CPF, facilitando a localização de informações específicas.
*   **Modelagem de Banco de Dados**: Design cuidadoso do esquema de banco de dados para suportar as entidades de usuários, documentos, notebooks e acessórios, garantindo a integridade e a escalabilidade dos dados.
*   **Testes Unitários para Repositórios**: Cobertura de testes unitários para a camada de repositórios, assegurando a confiabilidade e a robustez das operações de persistência de dados.
*   **Validação e Tratamento de Erros**: Implementação de validações robustas para os dados de entrada e tratamento adequado de erros para garantir a estabilidade do sistema e uma experiência de usuário consistente.
*   **Interface Responsiva**: Componentes de UI responsivos para garantir uma boa experiência de usuário em diferentes dispositivos.





## Tecnologias Utilizadas

*   **Laravel 12**: Framework PHP para desenvolvimento web.
*   **Laravel Sail**: Ambiente de desenvolvimento Docker para Laravel.
*   **Docker**: Plataforma para desenvolvimento, envio e execução de aplicações em containers.
*   **PHPWord**: Biblioteca para leitura e escrita de documentos Word (.docx).
*   **DomPDF**: Biblioteca para conversão de HTML para PDF.
*   **MySQL**: Sistema de gerenciamento de banco de dados relacional.

## Instalação e Execução do Projeto

Para configurar e executar este projeto em seu ambiente local, siga os passos abaixo:

### Pré-requisitos

Certifique-se de ter os seguintes softwares instalados em sua máquina:

*   **Docker Desktop**: Inclui Docker Engine, Docker CLI, Docker Compose e Kubernetes (opcional).
    *   [Download Docker Desktop](https://www.docker.com/products/docker-desktop)
*   **Git**: Para clonar o repositório.
    *   [Download Git](https://git-scm.com/downloads)

### Passos para Instalação

1.  **Clone o Repositório**:

    Abra seu terminal ou prompt de comando e execute o seguinte comando para clonar o projeto:

    ```bash
    git clone <URL_DO_SEU_REPOSITORIO>
    cd <nome_do_seu_repositorio>
    ```

2.  **Configurar o Laravel Sail**:

    O Laravel Sail utiliza o Docker para criar um ambiente de desenvolvimento isolado. Execute o comando `sail up` para iniciar os containers Docker. Se esta for a primeira vez que você executa o Sail, ele construirá as imagens Docker, o que pode levar alguns minutos.

    ```bash
    ./vendor/bin/sail up -d
    ```

    O `-d` no final do comando executa os containers em segundo plano.

3.  **Instalar Dependências do Composer**:

    Com os containers do Docker em execução, você pode instalar as dependências do PHP via Composer. Execute o Composer dentro do container `laravel.test`:

    ```bash
    ./vendor/bin/sail composer install
    ```

4.  **Configurar o Arquivo `.env`**:

    Copie o arquivo de exemplo `.env.example` para `.env`:

    ```bash
    cp .env.example .env
    ```

    Abra o arquivo `.env` e configure as variáveis de ambiente, especialmente as de banco de dados. O Laravel Sail já configura as variáveis de banco de dados para você, mas é bom verificar. Certifique-se de que `DB_HOST` esteja apontando para o serviço de banco de dados do Docker (geralmente `mysql`).

    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=sail
    DB_PASSWORD=password
    ```

5.  **Gerar a Application Key**:

    Execute o comando para gerar a chave da aplicação Laravel:

    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

6.  **Executar Migrações e Seeders (Opcional)**:

    Para criar as tabelas no banco de dados e popular com dados de exemplo (se houver seeders), execute as migrações:

    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```

7.  **Acessar a Aplicação**:

    A aplicação estará disponível em `http://localhost` (ou a porta configurada no seu `.env`).

    Você pode acessar o painel de administração ou a tela de login para começar a usar o sistema.

## Modelagem de Banco de Dados

A modelagem do banco de dados foi realizada com base nos requisitos do teste técnico, visando uma estrutura clara e eficiente para o gerenciamento de documentos, usuários, notebooks e acessórios. As principais entidades e seus relacionamentos são:

*   **Users**: Tabela padrão de usuários do Laravel, com campos para autenticação.
*   **Employees**: Relacionado a `Users`, armazena informações detalhadas do funcionário (nome, CPF, função) que será o responsável pelo termo.
*   **Notebooks**: Armazena os dados dos notebooks (marca, modelo, número de série, processador, memória, disco, preço).
*   **Accessories**: Armazena os dados dos acessórios (nome, descrição, marca).
*   **Documents**: Tabela central que representa o termo de responsabilidade. Contém campos como `employee_id`, `notebook_id`, `local`, `date` e se relaciona com `Accessories` através de uma tabela pivô (`document_accessory`) para gerenciar os acessórios associados a cada documento.

Essa estrutura permite uma gestão flexível e escalável dos dados, facilitando a recuperação e a associação de informações para a geração dos termos.

## Testes Unitários

Foram desenvolvidos testes unitários para a camada de repositórios, garantindo a correta manipulação e persistência dos dados. Os testes cobrem as operações CRUD (Create, Read, Update, Delete) para as entidades principais, assegurando que as interações com o banco de dados funcionem conforme o esperado e que as regras de negócio sejam respeitadas. Para executar os testes, utilize o comando:

```bash
./vendor/bin/sail artisan test
```