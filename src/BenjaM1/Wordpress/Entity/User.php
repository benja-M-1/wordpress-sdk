<?php

namespace BenjaM1\Wordpress\Entity;

/**
 * User
 *
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */
class User extends AbstractEntity
{
    /**
     * Configure the properties of an entity.
     *
     * @return mixed
     */
    protected function configure()
    {
        $this
            ->addProperty('user_id')
            ->addProperty('username')
            ->addProperty('first_name')
            ->addProperty('last_name')
            ->addProperty('bio')
            ->addProperty('email')
            ->addProperty('nickname')
            ->addProperty('nicename')
            ->addProperty('url')
            ->addProperty('display_name')
            ->addProperty('registered')
            ->addProperty('roles')
        ;
    }

    public function __toString()
    {
        return (string) $this->getIdentifier();
    }

    public function getIdentifier()
    {
        return $this->get('user_id');
    }
}
