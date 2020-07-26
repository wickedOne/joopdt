<?php

/*
 * This file is part of joopdt.nl.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer;

require_once 'recipe/common.php';

set('repository', 'git@github.com:wickedOne/joopdt.git');
set('git_tty', true);
set('allow_anonymous_stats', false);
set('bin_dir', 'bin');

set('bin/console', function () {
    return sprintf('{{release_path}}/%s/console', trim(get('bin_dir'), '/'));
});

set('console_options', function () {
    $options = '--no-interaction --env={{symfony_env}}';

    return 'prod' !== get('symfony_env') ? $options : sprintf('%s --no-debug', $options);
});

host('10.0.0.111')
    ->stage('production')
    ->set('symfony_env', 'prod')
    ->set('deploy_path', '/var/www/www.joopdt.nl/')
    ->user('legacy')
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->set('clear_paths', ['build'])
;

task('database:migrate', static function () {
    run('{{bin/php}} {{bin/console}} doctrine:migrations:migrate {{console_options}} --allow-no-migration');
});

task('deploy:upload', static function () {
    upload('.', '{{release_path}}');
});

task('deploy:cache:clear', static function () {
    run('{{bin/php}} {{bin/console}} cache:clear {{console_options}} --no-debug --no-warmup');
});

task('deploy:cache:warmup', static function () {
    run('{{bin/php}} {{bin/console}} cache:warmup {{console_options}}');
});

task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:upload',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:shared',
    'deploy:cache:clear',
    'deploy:cache:warmup',
    'database:migrate',
    'cleanup',
])->desc('Deploy joopdt');
