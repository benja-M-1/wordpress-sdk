<?php

namespace BenjaM1\Wordpress\Entity;

/**
 * Post
 *
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */
class Post extends AbstractEntity
{
    /**
     * Configure the properties of an entity.
     *
     * @return mixed
     */
    protected function configure()
    {
        $this
            ->addProperty('post_id')
            ->addProperty('post_title')
            ->addProperty('post_date')
            ->addProperty('post_status')
            ->addProperty('post_author')
            ->addProperty('post_password')
            ->addProperty('post_content')
        ;
    }

    public function getIdentifier()
    {
        return $this->get('post_id');
    }
}
