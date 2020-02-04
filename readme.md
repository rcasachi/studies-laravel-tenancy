# Studies Laravel Tenancy

The goals will be: Separate accounts by subdomain, Separate account content, Separate account databases, Allow for new user creation, Provide a subscription service to access, Define user roles, Implement a simple service example.

## Installing it

-  Create a database user that has privileges to CREATE DATABASE:
```
CREATE DATABASE IF NOT EXISTS studies_laravel_tenancy;
CREATE USER IF NOT EXISTS studies_tenancy@localhost IDENTIFIED BY 'tenancy_123';
GRANT ALL PRIVILEGES ON *.* TO studies_tenancy@localhost WITH GRANT OPTION;
```

- Copy ```.env.example``` file to ```.env``` and open it up to add in the environment variables referenced in the new system connection:
```
DB_CONNECTION=system
TENANCY_HOST=127.0.0.1
TENANCY_PORT=3306
TENANCY_DATABASE=studies_tenancy
TENANCY_USERNAME=studies_tenancy
TENANCY_PASSWORD=tenancy_123
```

- Install composer dependencies:
```
composer install
```

- Generate app key:
```
php artisan key:generate
```

