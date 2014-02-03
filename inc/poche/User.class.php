<?php
/**
 * wallabag, self hostable application allowing you to not miss any content anymore
 *
 * @category   wallabag
 * @author     Nicolas Lœuillet <nicolas@loeuillet.org>
 * @copyright  2013
 * @license    http://www.wtfpl.net/ see COPYING file
 */

class User
{
    public $id;
    public $username;
    public $name;
    public $password;
    public $email;
    public $config;

    function __construct($user = array())
    {
        if ($user != array()) {
            $this->id = $user['id'];
            $this->username = $user['username'];
            $this->name = $user['name'];
            $this->password = $user['password'];
            $this->email = $user['email'];
            $this->config = $user['config'];
        }
    }

    public function getId() 
    {
        return $this->id;
    }

    public function getUsername() 
    {
        return $this->username;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getConfigValue($name) {
        return (isset($this->config[$name])) ? $this->config[$name] : FALSE;
    }
}