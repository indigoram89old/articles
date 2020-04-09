## Installation

Follow the next steps:

1. Clone this repository.
2. Copy .env.example to .env.
3. Fill in DB_DATABASE, NUXT_APP_URL, NUXT_API_URL.
4. Install the application:

```bash
composer install
php artisan migrate
php artisan install
cd client && npm install
npm run dev
```

5. Open the next link in you browser: http://localhost:3000/articles