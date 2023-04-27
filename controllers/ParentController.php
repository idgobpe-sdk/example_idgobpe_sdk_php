<?php

namespace Controllers;

use Arrilot\DotEnv\DotEnv;
use Philo\Blade\Blade;
use PCM\Idgobpe\Common\Constants;
use PCM\Idgobpe\IDGobPeClient;

/**
 * Created by Miguel Pazo <https://miguelpazo.com>.
 */
class ParentController
{
    protected $blade;

    /**
     * ParentController constructor.
     */
    public function __construct()
    {
        DotEnv::load(__DIR__ . '/../.env.php');

        $views = __DIR__ . '/../resources/views';
        $cache = __DIR__ . '/../resources/cache';

        $this->blade = new Blade($views, $cache);
    }

    protected function getClient()
    {
        $oClient = new IDGobPeClient(__DIR__ . '/../config/idgobpe_config.json');
        $state = base64_encode(random_bytes(10));

        $oClient->setRedirectUri(DotEnv::get('BASE_URL') . '/auth-endpoint');
        $oClient->setState($state);

        $oClient->setAcr(Constants::ACR_CERTIFICATE_DNIE);

        $oClient->addScope(Constants::SCOPE_PROFILE);

        return $oClient;
    }
}