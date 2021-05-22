# Initial setup
```
docker network create --subnet 172.18.18.0/24 abcd
docker-compose --project-directory . -f docker/docker-compose.yml build
```

# Reset data

```
rm -rf docker/logs/* docker/mysql/data/*
```

# Start containers

```
docker-compose --project-directory . -f docker/docker-compose.yml up
```
