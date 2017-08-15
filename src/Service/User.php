<?php

namespace Instapp\Service;

use Instapp\Instapp;
use InstagramAPI\Response\Model\User as UserModel;

class User
{
    /**
     * @var Instapp
     */
    protected $app;

    public function __construct(Instapp $app)
    {
        $this->app = $app;
    }

    /**<
     * @param UserModel|string|integer|array $userdata
     * @return integer|false user id
     * @throws \InvalidArgumentException
     */
    public function getIdFromUserdata($userdata)
    {
        if ($userdata instanceof User && $userdata = $userdata->user_id ?: $userdata->username)
        {
            return $this->getIdFromUserdata($userdata);
        }
        elseif (is_object($userdata) && $userdata = @$userdata->user_id ?: @($userdata->id ?: $userdata->username) )
        {
            return $this->getIdFromUserdata($userdata);
        }
        elseif (is_array($userdata) && $userdata = $userdata['username'] ?: $userdata['id'])
        {
            return $this->getIdFromUserdata($userdata);
        }
        elseif (is_numeric($userdata)) // maybe id
        {
            if (!$this->app['api']->people->getInfoById($userdata)->isUser())
                return false;

            return $userdata;
        }
        elseif (is_string($userdata)) // maybe username
        {
            try {
                return $this->app['api']->people->getUserIdForName($userdata);
            } catch (\Exception $e) {
                return;
            }
        }

        throw new \InvalidArgumentException("Invalid argument for getting user id");
    }

    /**
     * @param mixed $user
     * @return string username
     */
    public function getUsername($user)
    {
        return $this->app['api']->people->getInfoById($this->getIdFromUserdata($user))->user->username;
    }
}