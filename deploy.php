<?php
namespace Deployer;

require 'recipe/statamic.php';
require 'contrib/npm.php';
// Config

set('repository', 'git@github.com:rabol/raboldev.git');
set('writable_mode', 'chgrp');
set('writable_recursive', true);
set('writable_chmod_mode', '0775');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', ['content','users']);

// Hosts

host('rabol.dev')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '/var/www/raboldev');


desc('Installs npm packages');
task('npm:build', function () {
    run("cd {{release_path}} && {{bin/npm}} run build");
});

// Hooks
before('deploy:publish','npm:install');
after('npm:install', 'npm:build');
after('deploy:failed', 'deploy:unlock');
