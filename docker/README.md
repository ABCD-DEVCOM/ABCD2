docker network create --subnet 172.18.18.0/24 abcd
docker-compose --project-directory . -f docker/docker-compose.yml build
docker-compose --project-directory . -f docker/docker-compose.yml up
