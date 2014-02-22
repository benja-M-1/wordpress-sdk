<?php

namespace BenjaM1\Wordpress;

use Buzz\Browser;
use fXmlRpc\Client;
use fXmlRpc\ClientInterface;
use fXmlRpc\Transport\BuzzBrowserBridge;
use BenjaM1\Wordpress\Entity\Post;
use BenjaM1\Wordpress\Entity\User;
use BenjaM1\Wordpress\Hydrator\HydratorManager;

/**
 * Wordpress
 *
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */
class Wordpress
{
    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var \fXmlRpc\Client
     */
    private $client;

    /**
     * @var Hydrator\HydratorManager
     */
    private $hm;

    /**
     * @var int
     */
    private $blog;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @param $endpoint
     * @param ClientInterface $client
     * @param HydratorManager $hm
     */
    public function __construct($endpoint, ClientInterface $client = null, HydratorManager $hm = null)
    {
        $this->endpoint = $endpoint;
        $this->client   = $client ?: new Client($endpoint, new BuzzBrowserBridge(new Browser()));
        $this->hm       = $hm ?: new HydratorManager();
        $this->blog     = 0;
    }

    /**
     * @param string $username
     * @param string $password
     */
    public function connect($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param $blog
     */
    public function setBlogId($blog)
    {
        $this->blog = $blog;
    }

    /**
     * @param $method
     * @param  array             $parameters
     * @return mixed|null|string
     */
    public function call($method, array $parameters = [])
    {
        $this->client->prependParams([$this->blog, $this->username, $this->password]);

        return $this->hm->hydrate($method, $this->client->call($method, $parameters));
    }

    /**
     * @return User
     */
    public function getCurrentUser()
    {
        return $this->call('wp.getProfile');
    }

    /**
     * @return mixed|null|string
     */
    public function getUsers()
    {
        return $this->call('wp.getUsers');
    }

    /**
     * @param  Post $post
     * @param  bool $refresh
     * @return Post
     */
    public function createPost(Post $post, $refresh = false)
    {
        $post->setApi($this);
        $postId = $this->call('wp.newPost', ['content' => $post->getProperties()]);

        $post->set('post_id', $postId);

        if ($refresh) {
            $post->refresh();
        }

        return $post;
    }

    /**
     * @param $id
     * @return Post
     */
    public function getPost($id)
    {
        return $this->call('wp.getPost', [$id]);
    }
}
