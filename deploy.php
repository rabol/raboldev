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

// Hooks

after('deploy:failed', 'deploy:unlock');
