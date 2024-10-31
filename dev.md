# SVN
svn co https://plugins.svn.wordpress.org/retrilhar-ecommerce/ wp-ecommerce

# Ambiente
cd wp-ecommerce
git clone https://github.com/nezhar/wordpress-docker-compose docker

## Abrir arquivo
docker/docker-compose.yml

### Adicionar linha em services.wp.volumes
- ../trunk/:/var/www/html/wp-content/plugins/retrilhar-ecommerce # Plugin development

cd docker
cp env.example .env

### Abrir o arquivo .env e trocar a porta para 82
docker compose up

## Apagar tudo
docker compose down -v

# Acesso
docker exec -it docker-wp-1 bash

# Commit
svn ci --username retrilhar -m "Comentário"

svn ci --username retrilhar -m "Adicionado filtros de posts"
