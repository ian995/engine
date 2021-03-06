<?php

namespace Minds\Controllers\Cli;

use Minds\Core;
use Minds\Core\Di\Di;
use Minds\Cli;
use Minds\Interfaces;
use Minds\Entities;

class RateLimits extends Cli\Controller implements Interfaces\CliControllerInterface
{
    public function __construct()
    {
        $minds = new Core\Minds;
        $minds->start();
    }

    public function help($command = null)
    {
        $this->out('TBD');
    }
    
    public function exec()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        session_start();
        Core\Security\ACL::$ignore = true;
        \Minds\Core\Events\Defaults::_();
        while (true) {
            echo ".";
            $scanner = new Core\Security\RateLimits\Scanner();
            $scanner->run();
            sleep(1); //sleep for 1 second
        }
    }

    public function manual()
    {
        Core\Security\ACL::$ignore = true;
        \Minds\Core\Events\Defaults::_();

        $user = new Entities\User('sillysealion');
        $manager = new Core\Security\RateLimits\Manager();
        $manager->setInteraction('subscribe')
            ->setUser($user)
            ->impose();

        var_dump($manager->isLimited());
    }
}
