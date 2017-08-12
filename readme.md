<h2 align="center">Automated Laravel Admin Panel</h2>


## Installation

1. Set database configuration in .env and make sure you've created a blank database and given privilages with user
2. Command → composer install
3. Command → php artisan key:generate
4. Command → php artisan migrate

5. Set your default user name and password in <code> database/seeds/user_table_seeder.php </code>

6. Command → php artisan db:seed
7. Command → php artisan serve

8. Change tables configuration in <code> storage/app/table_config/tables.json </code> according your needs.

9. Change columns configuration in <code> storage/app/table_config/tablename_columns.json </code> according your needs.

10. Go to http://127.0.0.1:8000/login

11. Done...! :-)