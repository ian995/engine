<?php

namespace Minds\Core\Media\YouTubeImporter;

use Minds\Core\Di\Provider as DiProvider;

class Provider extends DiProvider
{
    public function register()
    {
        $this->di->bind('Media\YouTubeImporter\Controller', function ($di) {
            return new Controller();
        });

        $this->di->bind('Media\YouTubeImporter\Manager', function ($di) {
            return new Manager();
        });

        $this->di->bind('Media\YouTubeImporter\Client', function ($di) {
            return new GoogleClient();
        }, ["useFactory" => true]);
    }
}