# Sobre o projeto
O projeto foi desenvolvido pensando na arquitetura MVC, seguindo os principios SOLID.
app é a pasta principal, onde se encontra todos os arquivos do backend.

#### Explicação das principais pastas
- config: Neste diretório, está os arquivos de configuração do projeto. No caso, há apenas o arquivo config/container.php, que se trata do container de injeção de dependencia.
- controller/http: Aqui se encontra todos os arquivos que irão tratar todas as requisições HTTP: Sempre que o frontend for fazer acesso ao backend, deve-se enviar uma requisição (acompanhada do verbo POST) para o arquivo controller/http/controller.php, nele será tratado os parâmetros e fará o retorno sempre no formato JSON, acompanhado do código HTTP apropriado. Observação: decidi optar por fazer as requisições para o backend utilizando somente formdata para facilitar a conversão, pode facilmente ser utilizado outros formatos, porém o recomendado é que se utilize formdata.
- database: Aqui se encontra os arquivos de conexão com o banco de dados. No caso, há apenas um arquivo, que faz conexão com o banco de dados do projeto utilizando PDO.
- domain: Este é o diretório que fica responsável por tratar de toda a lógica de negócio e entidades do projeto. As services, repositories e models ficam nele.

## Como instalar o projeto

O projeto foi desenvolvido com PHP 7.4.27, então pode ser que algumas funcionalidades não funcione em versões mais antigas.
O banco de dados utilizado é o MySQL, o sql de criação das entidades se encontra na pasta: dump

- Primeiramente, é necessário clonar o repositório. Acesse a pasta onde ficará o projeto, e execute o comando git: 
git clone https://github.com/FabioAugustoRodrigues/cardapio.git

- O projeto utiliza o Composer como gerenciador de pacotes, por isso deve se executar alguns comandos para instalar as dependências. (Caso não tenha o Composer instalado entre na documentação https://getcomposer.org/ e instale-o antes de prosseguir). Portanto, acesse a linha de comando e execute o seguinte comando: composer install
- Prontinho! Seu projeto já está pronto para ser executado, somente ligue o seu servidor php e acesse o link cardapio/login. Utilize os seguintes dados de acesso: 
login: admin
senha: senha123

## Bibliotecas utilizadas
Neste projeto utilizei somente a biblioteca PHP-DI, para containers de injeção de dependência. A documentação pode ser visualizada nesse link: https://php-di.org/doc/
