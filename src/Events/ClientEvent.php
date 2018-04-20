<?php

namespace AfterBug\AfterBugYii\Events;

use AfterBug\Client;
use yii\base\Event;

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
