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
     * @param bool $validate
     * @return integer|false user id
     * @throws \InvalidArgumentException
     */
    public function getIdFromUserdata($userdata, $validate = true)
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
            if ($validate)
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
     * @param UserModel|string|integer|array $userdata
     * @return integer|false user id
     * @throws \InvalidArgumentException
     */
    public function getUsernameFromUserdata($userdata)
    {
        if ($userdata instanceof User && $userdata = $userdata->user_id ?: $userdata->username)
        {
            return $this->getUsernameFromUserdata($userdata);
        }
        elseif (is_object($userdata) && $userdata = @$userdata->user_id ?: @($userdata->id ?: $userdata->username) )
        {
            return $this->getUsernameFromUserdata($userdata);
        }
        elseif (is_array($userdata) && $userdata = $userdata['username'] ?: ($userdata['id'] ?: $userdata['user_id']))
        {
            return $this->getUsernameFromUserdata($userdata);
        }
        elseif (is_numeric($userdata))
        {
            if ($id = $this->getIdFromUserdata($userdata))
            {
                return $this->app['api']->people->getInfoById($id)->user->username;
            }
        }
        elseif (is_string($userdata))
        {
            return $userdata;
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