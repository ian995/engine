<?php
/**
 *
 */

namespace Minds\Controllers\api\v2\payments\stripe;

use Minds\Api\Factory;
use Minds\Common\Cookie;
use Minds\Core\Di\Di;
use Minds\Core\Config;
use Minds\Core\Session;
use Minds\Interfaces;
use Minds\Core\Payments\Stripe;

class connect implements Interfaces\Api
{
    public function get($pages)
    {
        $user = Session::getLoggedInUser();

        $connectManager = new Stripe\Connect\Manager();

        $account = $connectManager->getByUser($user);

        return Factory::response([
            'account' => $account->export(),
        ]);
    }

    public function post($pages)
    {
        return Factory::response([]);
    }

    public function put($pages)
    {
        return Factory::response([]);
    }

    public function delete($pages)
    {
        $user = Session::getLoggedInUser();

        $account = new Stripe\Connect\Account();
        $account->setUserGuid($user->getGuid())
            ->setUser($user)
            ->setId($user->getMerchant()['id']);

        $connectManager = new Stripe\Connect\Manager();
        $connectManager->delete($account);
        return Factory::response([]);
    }
}
