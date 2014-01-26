<?php

namespace BenjaM1\Wordpress\Entity;

use BenjaM1\Wordpress\Wordpress;

/**
 * AbstractEntity
 *
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */
abstract class AbstractEntity
{
    /**
     * @var array
     */
    protected $properties;

    /**
     * @var Wordpress
     */
    protected $api;

    public function __construct()
    {
        $this->properties = [];
        $this->configure();
    }

    /**
     * Configure the properties of an entity.
     *
     * @return mixed
     */
    abstract protected function configure();

    /**
     * @return mixed
     */
    abstract public function getIdentifier();

    /**
     * @param $name
     * @param  null  $default
     * @return $this
     */
    protected function addProperty($name, $default = null)
    {
        $this->properties[$name] = $default;

        return $this;
    }

    /**
     * @param $property
     * @param $value
     * @return $this
     */
    public function set($property, $value)
    {
        $this->properties[$property] = $value;

        return $this;
    }

    /**
     * @param $property
     * @return mixed
     */
    public function get($property)
    {
        return $this->properties[$property];
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this|mixed
     * @throws \BadMethodCallException
     */
    public function __call($name, $arguments)
    {
        $method = substr($name, 0, 3);
        $property = lcfirst(substr($name, 3));

        if ('get' == $method) {
            return $this->get($property);
        } elseif ('set' == $method) {
            $this->set($property, reset($arguments));

            return $this;
        }

        throw new \BadMethodCallException(sprintf('The method %s:%s does not exist', get_class($this), $name));
    }

    /**
     * @param \BenjaM1\Wordpress\Wordpress $api
     *
     * @return AbstractEntity
     */
    public function setApi($api)
    {
        $this->api = $api;

        return $this;
    }

    /**
     * @return \BenjaM1\Wordpress\Wordpress
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        $properties = [];

        foreach ($this->properties as $name => $property) {
            if (is_a($property, '\DateTime')) {
                //$property = $property->format();
            } elseif (is_object($property)) {
                $property = (string) $property;
            }

            $properties[$name] = $property;
        }

        return $properties;
    }

    /**
     * Refresh the entity.
     *
     * @return $this
     */
    public function refresh()
    {
        $entity = str_replace([__NAMESPACE__, '\\'], '', get_class($this));
        $post = $this->api->call('wp.get'.$entity, [$this->getIdentifier()]);

        foreach ($this->properties as $property => $value) {
            $this->set($property, $post->get($property));
        }

        return $this;
    }
}
