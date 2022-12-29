# AdminKit Laravel

Starter kit to accelerate develop internal web app in Universitas Udayana.
Build with [AdminKit](https://adminkit.io/) in Laravel + integrate with [Single Sign On](https://github.com/ristekusdi/sso-laravel) Universitas Udayana.

## Frameworks + Tools

- PHP version >= 8.0.2
- Laravel 9.x + [ViteJS](https://laravel.com/docs/9.x/vite)
- [Livewire 2.x](https://laravel-livewire.com/)
- [AlpineJS](https://alpinejs.dev/start-here)
- [Boostrap 5](https://getbootstrap.com/) [without jQuery])(https://blog.getbootstrap.com/2021/05/05/bootstrap-5/#javascript)
- [RistekUSDI SSO Laravel](https://github.com/ristekusdi/sso-laravel)
- [RistekUSDI RBAC Connector](https://github.com/ristekusdi/rbac-connector/)

## Installation

Run command below.

> For non-production ready please add flag `--stability=dev` as below.

```
composer create-project --stability=dev ristekusdi/adminkit-laravel example-app
```

> Note: if you install with the command above, you don't need to run php artisan key:generate because it already take care by the composer scripts. :)

1. Create database with the name of your application then update your database configuration in `.env` file.

2. Copy KEYCLOAK_* environment value for SSO and RBAC_CONNECTOR_HOST_URL for get list of users and client roles from your client in IMISSU2 and copy it to `.env` file.

> Note: imissu2-dev for development and imissu2 for production.

3. Run `php artisan migrate`.

4. Run `php artisan db:seed` to run seeder for menus, permissions, and roles.

5. Run `npm install` to install JavaScript dependencies that need for this starter kit.

6. Run `php artisan serve` in currrent command tab and `npm run dev` in another command tab.

**Notes**

1. Command `php artisan serve` is for running application on PHP development server.
2. Command `npm run dev` is for generate CSS and JavaScript assets for application.
3. If you use another port except default port (8000) from Laravel, you may run `php artisan serve --port=<port-number>` command.
4. if you use custom domain `.test` with Laravel Valet or Traefik, you need to change the value of APP_URL because its related with generate CSS and JavaScript assets in your development server.