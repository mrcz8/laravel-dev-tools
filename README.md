# Laravel Dev Tools
A Laravel package providing artisan commands to improve security and maintainability:

- `list:policies` → Lists all registered policies.
- `model:relations {model}` → Lists all relationships in a model.
- `route:missing-authorization` → Finds routes without authorization middleware or policies.

---
## Installation from GitHub
If you want to install directly GitHub repository:

1. Add this repository to your Laravel project's composer.json:
    ```repo
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mrcz8/laravel-dev-tools"
        }
    ]
    ```
2. Require the package:
    ```composer
    composer require tawin/laravel-dev-tools:main
    ```
---
## Usage
After installation, you can run the commands:
```bash
php artisan list:policies
php artisan model:relations App\Models\User
php artisan route:missing-authorization
```
> You can replace `App\Models\User` with any other model to see its relationships.

These commands help you inspect policies, model relations, and routes missing authorization in your Laravel application.