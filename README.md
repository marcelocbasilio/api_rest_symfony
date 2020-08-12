# api_rest_symfony

- symfony new minhaPrimeiraApiRest
- symfony serve (com TLS) **
- symfony serve --no-tls (sem TLS)

- composer req maker
- composer req orm
- composer req serializer

- php bin/console make:entity
- php bin/console doctrine:database:create ***
- php bin/console make:migration
- php bin/console doctrine:migrations:migrate

- php bin/console make:controller

- php bin/console debug:route ****

** Se você tiver o certificado TLS, terá que instalar o suporte ao TLS antes de dar START ao SERVER com o seguinte comando: symfony server:ca:install
*** Antes de executar este comando atualize seu arquivo .env com os dados do seu banco 
**** Informa as rotas cadastradas
