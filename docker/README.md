# Initial setup
```
# create a subnet for ABCD
docker network create --subnet 172.18.18.0/24 abcd

# build the ABCD containers
docker-compose --project-directory . -f docker/docker-compose.yml build

# ensure www-data user is owner of the example database
chown -R 33:33 ./www/bases-examples_Linux
```

# Reset data

```
rm -rf docker/logs/* docker/mysql/data/*
```

# Start containers

```
docker-compose --project-directory . -f docker/docker-compose.yml up
```
