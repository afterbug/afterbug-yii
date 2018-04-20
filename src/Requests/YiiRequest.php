<?php

namespace AfterBug\AfterBugYii\Requests;

use AfterBug\Request\Contracts\RequestInterface;
use Yii;

class YiiRequest implements RequestInterface
{
    /**
     * Get the session data.
     *
     * @return array
     */
    public function getSession()
    {
        $session = [];
        foreach (Yii::$app->session as $key => $value) {
            $session[$key] = $value;
        }

        return $session;
    }

    /**
     * Get the cookies.
     *
     * @return array
     */
    public function getCookies()
    {
        $cookies = [];
        foreach (Yii::$app->request->cookies as $key => $cookie) {
            $cookies[$cookie->name] = $cookie->value;
        }

        return $cookies;
    }

    /**
     * Get the headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return Yii::$app->request->headers->toArray();
    }

    /**
     * Get server variable
     *
     * @return array
     */
    public function getServer()
    {
        return $_SERVER;
    }

    /**
     * Get the request formatted as meta data.
     *
     * @return array
     */
    public function getMetaData()
    {
        $data = [
            'url' => Yii::$app->request->absoluteUrl,
            'method' => Yii::$app->request->method,
            'params' => $_REQUEST,
            'clientIp' => Yii::$app->request->userIP,
        ];

        if ($agent = Yii::$app->request->headers->get('User-Agent')) {
            $data['userAgent'] = $agent;
        }

        return $data;
    }

    /**
     * Get the request ip.
     *
     * @return string|null
     */
    public function getRequestIp()
    {
        return Yii::$app->request->userIP;
    }
}
