# Backend Challenge 20230105 by Coodesh

O projeto tem como objetivo dar suporte a equipe de nutricionistas da empresa Fitness Foods LC para que eles possam revisar de maneira rápida a informação nutricional dos alimentos que os usuários publicam pela aplicação móvel.

## Ferramentas utilizadas
* PHP 8.1
* Laravel 10
* MySQL

## Link para apresentação
https://www.loom.com/embed/ead901eff0924888a75682db337f3d89

## Instruções
Para esse projeto é necessário o PHP 8.1 e o MySQL versão 5.8 > e o gerenciador de dependências composer instalados na máquina.

1.  Rode o comando `cp .env.example .env` para criar o arquivo .env , ou copie manualmente o arquivo .env.example e renomeie-o para .env.
2. Cheque se a porta do MySQL no .env é a mesma porta do MySQL em sua máquina.
3. Rode o comando composer install para instalar as dependências do projeto.
4. Crie um novo banco chamado open_food.
5. Rode o comando php artisan migrate para migrar os scheemas necessários.
6. Rode o comando php artisan db:seed para rodar o seed da tabela external_clients.
7. Para utilizar o cron job localmente, abra um novo terminal e digite o seguinte comando: `php artisan schedule:work`.

Para utilizar a API Rest com um client HTTP como postman e insomnia crie um Bearer token e cole-o no header de autorização, com o seguinte comando:<br>
`php artisan token:generate testing`.
<br>
E não se esqueça de inicializar o servidor com o comando `php artisan serve`.
## Utilizando o cronjob
Para utilizar o cronjob você pode alterar o horário que ele deve ser executado diariamente no arquivo `.env` , ou você pode rodar o seguinte comando e já executar o import dos dados sem precisar esperar dar o horário do cronjob ser executado: <br>
`php artisan import:products`.<br>
Após a execução do import, você pode acompanhar os logs com informações no arquivo `storage/logs/product-imports.log`.

## Utilizando a Rest API

Para a utilização da API não se esqueça de colocar o Bearer Token gerado com o comando `php artisan token:generate testing` no header de cada request (Ou no header da coleção de requests se estiver no postman).

A seguir temos todos os endpoints disponíveis assim como seu parâmetros e payloads.

### Health da aplicação
Método: GET <br>
URL: http://127.0.0.1:8000/api <br>
<br>
### Listagem dos produtos importados
Método: GET <br>
URL: http://127.0.0.1:8000/api/products<br>
Parâmetros opcionais: perPage=`<ResultadosPorPágina>`
<br>
### Detalhes de um produto
Método: GET <br>
URL: http://127.0.0.1:8000/api/products/{codigoDoProduto} <br>

### Atualização de um produto
Método: PUT <br>
URL: http://127.0.0.1:8000/api/products/{codigoDoProduto} <br>
Payload exemplo: <br>
`{"status": "published",
   "url": "https://world.openfoodfacts.org/product/20221126",
   "name": "Madalenas quadradas",
   "brands": "La Cestera",
   "categories": "Lanches comida, Lanches doces, Biscoitos e Bolos, Bolos, Madalenas",
   "labels": "Contem gluten, Contém derivados de ovos, Contém ovos",
   "cities": "Braga",
   "purchasePlaces": "Braga,Portugal",
   "stores": "Lidl",
   "traces": "Frutos de casca rija,Leite,Soja,Sementes de sésamo,Produtos à base de sementes de sésamo",
   "nutriScore": 17,
   "nutriScoreGrade": "d",
   "mainCategory": "en:madeleines",
   "imageUrl": "https://static.openfoodfacts.org/images/products/20221126/front_pt.5.400.jpg"} `
<br>

## Inativar um produto
Método: DELETE <br>
URL: http://127.0.0.1:8000/api/products/{codigoDoProduto} <br>


Enjoy :)
