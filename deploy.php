<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/npm.php';

// Config

set('repository', 'git@gitlab.n2rtechnologies.com:nurulhasan/junglecrm.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('production')
    ->set('hostname','13.126.49.2' )
    ->set('branch', 'main')
    ->set('remote_user', 'ubuntu')
    ->set('deploy_path', '/var/www/crm');

host('staging')
    ->set('hostname','38.242.196.238' )
    ->set('branch', 'development')
    ->set('remote_user', 'root')
    ->set('deploy_path', '/var/www/php81/leadcrm')
    ->set('keep_releases', 1);

// Hooks

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:migrate',
    'npm:install',
    'npm:run:prod',
    'deploy:publish',
]);

task('npm:run:prod', function () {
    cd('{{release_or_current_path}}');
    run('composer install');
    run('npm run prod');
});

after('deploy:failed', 'deploy:unlock');
