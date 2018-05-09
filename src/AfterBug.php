<?php

namespace AfterBug\AfterBugYii;

use AfterBug\AfterBugYii\Callbacks\User;
use AfterBug\AfterBugYii\Events\ClientEvent;
use AfterBug\AfterBugYii\Requests\YiiRequest;
use AfterBug\Client;
use AfterBug\Config;
use yii\base\Component;
use Yii;

class AfterBug extends Component
{
    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     * Set to `false` in development environment to skip collecting errors
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
        $excludeDirectories = [Yii::getAlias('@vendor')];

        $dirs = array_filter(glob(Yii::getAlias('@app').'/*'), 'is_dir');

        foreach ($excludeDirectories as $directory) {
            if (($key = array_search($directory, $dirs)) !== false) {
                unset($dirs[$key]);
            }
        }

        return $dirs;
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
                'version' => static::VERSION
            ])
            ->setApplicationPaths($this->applicationPaths())
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

        $this->trigger('beforeCapture', $event);

        $this->client->catchException($exception);
    }
}
