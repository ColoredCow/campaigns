@servers(['staging' => '', 'production' => ''])

@task('staging-deployment')
    php artisan down
    git pull origin main
    composer install --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist --optimize-autoloader
    composer dump-autoload
    php artisan migrate
    php artisan optimize:clear
    php artisan up
@endtask


