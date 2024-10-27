git clone https://github.com/Erikkou/WEBTopd4.git
Uses XAMPP Apache. 
composer install
Wait untill done. 
If the database hasn't been created yet automatically: php bin/console doctrine:database:create
Fill the database with tables: php bin/console doctrine:schema:update --force
Fill it with data: php bin/console doctrine:fixtures:load --no-interaction


