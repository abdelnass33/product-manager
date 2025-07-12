<?php

@servers(['web' => 'user@strategie.o2switch.net'])go

@setup
    $repository = 'git@github.com/abdelnass33/product-manager.git';
    $releases_dir = '/var/www/product-manager/releases';
    $app_dir = '/var/www/product-manager';
    $release = date('YmdHis');
    $new_release_dir = $releases_dir . '/' . $release;
@endsetup

@story('deploy')
    clone_repository
    run_composer
    update_symlinks
@endstory

@task('clone_repository')
    echo "Clonage du dépôt dans {{ $new_release_dir }}";
    git clone {{ $repository }} {{ $new_release_dir }};
@endtask

@task('run_composer')
    echo "Installation des dépendances";
    cd {{ $new_release_dir }};
    composer install --no-interaction --prefer-dist --optimize-autoloader;
@endtask

@task('update_symlinks')
    echo "Mise à jour des liens symboliques";
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current;
    ln -nfs {{ $app_dir }}/.env {{ $new_release_dir }}/.env;
    cd {{ $new_release_dir }};
    php artisan migrate --force;
    php artisan config:cache;
    php artisan route:cache;
@endtask
