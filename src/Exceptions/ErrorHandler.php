<?php

namespace AfterBug\AfterBugYii\Exceptions;

use AfterBug\AfterBugYii\AfterBug;
use AfterBug\Client;
use yii\base\InvalidConfigException;
use Yii;

class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * @var string component ID for the AfterBug client.
     */
    public $clientId = 'afterBug';

    /**
     * Logs the given exception.
     *
     * @param \Exception $exception the exception to be logged
     */
    public function logException($exception)
    {
        $this->getAfterBugClient()->catchException($exception);

        parent::logException($exception);
    }

    /**
     * Return the AfterBug Client instance.
     *
     * @return AfterBug
     * @throws InvalidConfigException
     */
    protected function getAfterBugClient()
    {
        if (!Yii::$app->has($this->clientId)) {
            throw new InvalidConfigException(sprintf('AfterBugErrorHandler.componentID "%s" is invalid.', $this->clientId));
        }

        return Yii::$app->get($this->clientId);
    }
}
