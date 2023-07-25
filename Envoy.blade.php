@servers(['localhost' => '127.0.0.1'])

@story('deploy', ['on' => 'localhost'])
    composer 
    migrate
@endstory


@task('composer')
    composer install
@endtask

@task('migrate')
    php artisan migrate
@endtask
