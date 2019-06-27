<?php
namespace Minds\Core\ThirdPartyNetworks;

use Minds\Core\Di\Di;
use Minds\Core\Events\Dispatcher;
use Minds\Core\Events\Event;
use Minds\Traits\Logger;

class Events
{
    use Logger;

    /**
     * Register Third-Party Networks events
     * @return void
     */
    public function register()
    {
        Dispatcher::register('social', 'dispatch', function (Event $event) {
            $params = $event->getParameters();
            $entity = $params['entity'];
            $services = $params['services'] ?: [];

            if (!$entity) {
                return;
            }

            $results = [];

            foreach ($services as $service => $enabled) {
                $results[$service] = false;

                if ($enabled) {
                    try {
                        $handler = Factory::build($service);

                        $handler->getApiCredentials();
                        $results[$service] = $handler->post($entity);
                    } catch (\Exception $e) {
                        // Let's just fail silently
                        $this->logger()->error($e);
                    }
                }
            }

            $event->setResponse($results);
        });
    }
}
