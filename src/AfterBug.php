<?php

namespace AfterBug\AfterBugYii;

use Yii;
use AfterBug\Client;
use AfterBug\Config;
use yii\base\Component;
use AfterBug\AfterBugYii\Callbacks\User;
use AfterBug\AfterBugYii\Events\ClientEvent;
use AfterBug\AfterBugYii\Requests\YiiRequest;

class AfterBug extends Component
{
    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '1.0.1';

    /**
     * Set to `false` in development environment to skip collecting errors.
     *
     * @var bool
     */
    public $enabled = true;

    /**
     * @var string API Key to use when connecting to AfterBug.
     */
    public $apiKey;

    /**
     * @var array user attributes to send to AfterBug.
     */
    public $userAttributes = ['id', 'email', 'username', 'name'];

    /**
     * @var array exception class to exclude.
     */
    public $excludeExceptions = [];

    /**
     * @var Client
     */
    protected $client;

    /**
     * Return application paths.
     *
     * @return array
     */
    private function applicationPaths()
    {
        $basePaths = array_filter(glob(Yii::getAlias('@app').'/*'), 'is_dir');

        $excludePaths = [
            Yii::getAlias('@vendor'),
            Yii::getAlias('@runtime'),
        ];

        return array_diff($basePaths, $excludePaths);
    }

    /**
     * Initialize Component.
     */
    public function init()
    {
        $config = new Config($this->apiKey);

        $this->client = (new Client($config, null, new YiiRequest()))
            ->setSdk([
                'name' => 'afterbug-yii',
                'version' => static::VERSION,
            ])
            ->setApplicationPaths($this->applicationPaths())
            ->setExcludeExceptions($this->excludeExceptions)
            ->setEnvironment(YII_ENV)
            ->registerDefaultCallbacks()
            ->registerCallback(new User());
    }

    /**
     * Capture Exception.
     *
     * @param \Exception|\Throwable $exception
     */
    public function catchException($exception)
    {
        $event = (new ClientEvent())->setClient($this->client);

        $this->trigger('beforeNotify', $event);

        $this->client->catchException($exception);

        $this->trigger('afterNotify', $event);
    }
}
