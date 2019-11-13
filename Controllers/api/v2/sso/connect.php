<?php
/**
 * connect
 * @author edgebal
 */

namespace Minds\Controllers\api\v2\sso;

use Minds\Api\Factory;
use Minds\Core\Di\Di;
use Minds\Core\SSO\Manager;
use Minds\Interfaces;
use Zend\Diactoros\ServerRequest;

class connect implements Interfaces\Api, Interfaces\ApiIgnorePam
{
    /** @var ServerRequest */
    public $request;

    /**
     * Equivalent to HTTP GET method
     * @param array $pages
     * @return mixed|null
     */
    public function get($pages)
    {
        return Factory::response([]);
    }

    /**
     * Equivalent to HTTP POST method
     * @param array $pages
     * @return mixed|null
     */
    public function post($pages)
    {
        $origin = $this->request->getServerParams()['HTTP_ORIGIN'] ?? '';

        if (!$origin) {
            return Factory::response([
                'status' => 'error',
                'message' => 'No HTTP Origin header'
            ]);
        }

        $domain = parse_url($origin, PHP_URL_HOST);

        /** @var Manager $sso */
        $sso = Di::_()->get('SSO');
        $sso
            ->setDomain($domain);

        if (!$sso->isAllowed()) {
            return Factory::response([
                'status' => 'error',
                'message' => 'HTTP Origin not allowed'
            ]);
        }

        return Factory::response([
            'token' => $sso->generateToken()
        ]);
    }

    /**
     * Equivalent to HTTP PUT method
     * @param array $pages
     * @return mixed|null
     */
    public function put($pages)
    {
        return Factory::response([]);
    }

    /**
     * Equivalent to HTTP DELETE method
     * @param array $pages
     * @return mixed|null
     */
    public function delete($pages)
    {
        return Factory::response([]);
    }
}
