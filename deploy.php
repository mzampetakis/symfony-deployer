<?php
namespace Deployer;

require 'recipe/symfony.php';

set('bin_dir', 'bin');
set('var_dir', 'var');

set('writable_use_sudo', false);

set('http_user', 'http_user');
set('http_group', 'http_group');

// Project name
set('application', 'my_app_name');

// Project repository
set('repository', 'https://my_git_repo.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', ["web/media", "var/logs", 'var/sessions']);
set('dump_assets', true);

// Writable dirs by web server
set('allow_anonymous_stats', false);


set('bin/php', "/usr/local/bin/ea-php71");

set('default_timeout', 3600);

task('deploy:cache:warmup', function () {

})->desc('No Warm up cache');



// Hosts
host('your_domain.com')
    ->user('ssh_user')
    ->port(ssh_port)
    ->set('default_timeout', 3600)
    ->set('branch', 'master')
    //->identityFile("pems/site.pem")
    ->set('deploy_path', '/home/user/public_html/);
//    ->set('ssh_multiplexing', false)
//    ->configFile('~/.ssh/config')
//    ->set('ssh_type', 'native')
//    ->addSshOption('UserKnownHostsFile', '/dev/null')
//    ->addSshOption('StrictHostKeyChecking', 'no');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

//before('deploy:symlink', 'database:migrate');

task('test', function () {
    runLocally("phpunit");
});

before('deploy', 'test');
