<?php

namespace AfterBug\AfterBugYii\Callbacks;

use AfterBug\Config;
use Yii;

class User
{
    /**
     * Execute user callback.
     *
     * @param Config $config
     * @return void
     */
    public function __invoke(Config $config)
    {
        if (! Yii::$app->user->isGuest) {
            $user = (array) Yii::$app->user->getIdentity();
            $config->setUser($user);
        }
    }
}
