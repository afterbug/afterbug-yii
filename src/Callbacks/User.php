<?php

namespace AfterBug\AfterBugYii\Callbacks;

use Yii;
use AfterBug\Config;

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

            $config->setUser(
                array_intersect_key($user, array_flip((array) Yii::$app->afterBug->userAttributes))
            );
        }
    }
}
