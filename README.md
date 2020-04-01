# email-campaigns

## Contributing

### Setting up the project locally

1. Clone the repository
   ```
   git clone https://github.com/ColoredCow/email-campaigns.git
   ```

1. Switch to project root directory
	```
	cd email-campaigns
	```

1. Install PHP and JavaScript dependencies
	```
	composer install
   yarn
	```

1. Setup environment variables
   ```
   cp .env.example .env
   php artisan key:generate
   ```

1. Setup database
   ```
   php artisan migrate
   php artisan db:seed
   ```

1. Setup virtual host
   ```
   valet link email-campaigns
   valet secure email-campaigns
   ```
