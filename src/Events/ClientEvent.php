<?php

namespace AfterBug\AfterBugYii\Events;

use yii\base\Event;
use AfterBug\Client;

class ClientEvent extends Event
{
    /**
     * @var Client
     */
    public $client;

    /**
     * @param Client $client
     * @return $this
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }
}
