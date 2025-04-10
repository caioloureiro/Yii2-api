GET /api/produtos           - Lista todos produtos ativos
GET /api/produtos/1         - Mostra detalhes do produto com ID 1
POST /api/produtos          - Cria novo produto (enviar JSON no body)
PUT /api/produtos/1         - Atualiza produto com ID 1
PATCH /api/produtos/1       - Atualização parcial do produto
DELETE /api/produtos/1      - Soft delete (marca como inativo)
GET /api/produtos/inativos  - Lista produtos inativos
POST /api/produtos/1/ativar - Reativa um produto

Testando a API

Você pode testar usando cURL ou Postman:

Criar produto:

curl -X POST "http://localhost/Yii2-api/web/api/produtos" \
     -H "Content-Type: application/json" \
     -d '{"nome":"Novo Produto","quantidade":10,"categoria":1}'

Listar produtos ativos:

curl -X GET "http://localhost/Yii2-api/web/api/produtos"

Soft delete:

curl -X DELETE "http://localhost/Yii2-api/web/api/produtos/1"

Reativar produto:

curl -X POST "http://localhost/Yii2-api/web/api/produtos/1/ativar"


Categorias:

GET    /api/categorias          - Lista todas categorias ativas
GET    /api/categorias/1        - Mostra detalhes da categoria com ID 1
POST   /api/categorias          - Cria nova categoria
PUT    /api/categorias/1        - Atualiza categoria completa
PATCH  /api/categorias/1        - Atualização parcial da categoria
DELETE /api/categorias/1        - Soft delete (marca como inativa)
GET    /api/categorias/inativos - Lista categorias inativas
POST   /api/categorias/1/ativar - Reativa uma categoria

curl -X POST "http://localhost/Yii2-api/web/api/categorias" \
     -H "Content-Type: application/json" \
     -d '{"name":"Eletrônicos","ativo":"1"}'

curl -X GET "http://localhost/Yii2-api/web/api/categorias"

curl -X DELETE "http://localhost/Yii2-api/web/api/categorias/1"

curl -X GET "http://localhost/Yii2-api/web/api/categorias/1?expand=produtos"