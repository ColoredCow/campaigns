@servers(['localhost' => '127.0.0.1', 'staging' => '', 'production' => ''])

@task('installation', ['on' => 'localhost'])
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
@endtask

{{-- Running Command --}}

{{-- php vendor/bin/envoy run installation --}}

