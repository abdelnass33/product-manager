@servers(['web' => 'sc2trpa3376@strategie.o2switch.net'])

@task('deploy')
    cd product-manager
    git pull origin main
    composer install
    php artisan migrate
    php artisan key:generate
    php artisan config:cache
    php artisan route:cache
@endtask
