<?php
namespace Deployer;

require 'recipe/statamic.php';

// Config

set('repository', 'git@github.com:rabol/raboldev.git');
set('writable_mode', 'chown');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('rabol.dev')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/raboldev');


desc('Installs npm packages');
task('npm:build', function () {
    run("cd {{release_path}} && {{bin/npm}} run build");
});

// Hooks
before('deploy:publish','npm:install');
after('npm:install', 'npm:build');
after('deploy:failed', 'deploy:unlock');
