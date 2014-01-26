<?php

namespace BenjaM1\Wordpress\Hydrator;

use BenjaM1\Wordpress\Entity\AbstractEntity;
use BenjaM1\Wordpress\Entity\Post;
use BenjaM1\Wordpress\Entity\User;

/**
 * HydratorManager
 *
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */
class HydratorManager
{
    /**
     * @var array
     */
    private $hydrators;

    public function __construct()
    {
        $this->hydrators = [
            'wp.getUsers' => 'hydrateUsers',
            'wp.getPost'  => 'hydratePost',
        ];
    }

    /**
     * @param $call
     * @param $data
     */
    public function hydrate($call, $data)
    {
        if (isset($this->hydrators[$call])) {
            return $this->{$this->hydrators[$call]}($data);
        }

        return $data;
    }

    /**
     * @param $data
     * @return array
     */
    private function hydrateUsers($data)
    {
        $users = [];
        foreach ($data as $user) {
            $users[] = $this->hydrateUser($user);
        }

        return $users;
    }

    /**
     * @param $data
     * @return User
     */
    private function hydrateUser($data)
    {
        return $this->hydrateProperties($data, new User());
    }

    /**
     * @param $data
     * @return Post
     */
    private function hydratePost($data)
    {
        return $this->hydrateProperties($data, new Post());
    }

    /**
     * @param $data
     * @param  AbstractEntity $entity
     * @return AbstractEntity
     */
    private function hydrateProperties($data, AbstractEntity $entity)
    {
        foreach ($data as $property => $value) {
            $entity->set($property, $value);
        }

        return $entity;
    }
}
