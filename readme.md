# Ampliffy Chanllenge 

### Slim, Micro-Framework

### **Setup instructions**

**Prerequisites:** 

* Docker

**Installation steps:** 

1. git clone https://github.com/villalbaezequiel/ampliffy
2. docker-compose up -d
3. echo "127.0.0.1 ::1 ampliffy.challenge.es" | sudo tee -a /etc/hosts
3. docker exec -it mysql bash # import db dump
4. docker exec -it app bash 
    ```
    $ composer install
    ```

### Endpoint:

- Get Repositories: http://ampliffy.challenge.es/api/v1/repositories
- Get Branches: http://ampliffy.challenge.es/api/v1/branches/{id_repository}
- Get Commits: localhost:8080/api/v1/commits/{id_branch}

### Command:

- Save tracking git commits: composer commands git:pre-commit