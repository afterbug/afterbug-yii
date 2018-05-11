<?php

namespace AfterBug\AfterBugYii\Exceptions;

use Yii;
use AfterBug\AfterBugYii\AfterBug;
use yii\base\InvalidConfigException;

class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * @var string component ID for the AfterBug client.
     */
    public $clientId = 'afterbug';

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
        if (! Yii::$app->has($this->clientId)) {
            throw new InvalidConfigException(sprintf('AfterBugErrorHandler.componentID "%s" is invalid.', $this->clientId));
        }

        return Yii::$app->get($this->clientId);
    }
}
