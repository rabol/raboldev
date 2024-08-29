<?php
namespace Deployer;

require 'recipe/statamic.php';
require 'contrib/npm.php';
// Config

set('repository', 'git@github.com:rabol/raboldev.git');
//set('writable_mode', 'chown');
set('writable_recursive', 'true');
set('writable_chmod_mode', '0755');
set('writable_use_sudo','true');
add('shared_files', []);
add('shared_dirs', ['public/assets','public/cached-img']);
//add('writable_dirs', ['content','users','bootstrap/cache']);

// Hosts

host('rabol.dev')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '/var/www/raboldev');


desc('Build you assets');
task('npm:build', function () {
    run("cd {{release_path}} && {{bin/npm}} run build");
});

desc('Set Statamic parmission');
task('statamic:permission', function () {
    run("sudo chown -R www-data:www-data {{deploy_path}}/current/storage");
    run("sudo chown -R www-data:www-data {{deploy_path}}/current/content");
    run("sudo chown -R www-data:www-data {{deploy_path}}/current/bootstrap/cache");
    run("sudo chown -R www-data:www-data {{deploy_path}}/current/public");
});

// Hooks
before('deploy:publish','npm:install');
after('npm:install', 'npm:build');
after('deploy:failed', 'deploy:unlock');
after('deploy:publish', 'statamic:permission');
