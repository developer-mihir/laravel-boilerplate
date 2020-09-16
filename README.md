# [Laravel](https://laravel.com) Boilerplate

This is a simple laravel boilerplate which provides CRUD operation.

## Installation using [Composer](https://getcomposer.org/)

Use below commands step by step to get started.

> Update composer to get all packages
```bash
composer update
```
> Generate app key, migrate db to your local setup and seed example data
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

> Install laravel ui and start with bootstrap
```bash
composer require laravel/ui:^2.4
php artisan ui bootstrap
php artisan ui bootstrap --auth
```

> Install node modules and initialize it
```bash
npm install
npm run dev
```

**User List**

[![User List](https://user-images.githubusercontent.com/15919490/93351717-aa3a1d80-f857-11ea-94ea-764ab89588cc.png)]()

**Car List**

[![Car List](https://user-images.githubusercontent.com/15919490/93351755-b58d4900-f857-11ea-89a5-942b2c56aac1.png)]()

## License
[MIT](https://choosealicense.com/licenses/mit/)