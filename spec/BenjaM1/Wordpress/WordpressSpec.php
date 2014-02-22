<?php

namespace spec\BenjaM1\Wordpress;

use BenjaM1\Wordpress\Entity\Post;
use BenjaM1\Wordpress\Entity\User;
use BenjaM1\Wordpress\Hydrator\HydratorManager;
use fXmlRpc\ClientInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WordpressSpec extends ObjectBehavior
{
    function let(ClientInterface $client, HydratorManager $hm)
    {
        $this->beConstructedWith(
            'http://www.example.com/xmlrpc.php',
            $client,
            $hm
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('BenjaM1\Wordpress\Wordpress');
    }

    function it_should_retrieve_the_current_user(ClientInterface $client, HydratorManager $hm, User $user)
    {
        $method = 'wp.getProfile';
        $this->connect('benjaming', 'foo');

        $user->get('username')->willReturn('foo');
        $user->get('username')->willReturn('benjaming');

        $client->prependParams(Argument::type('array'))->shouldBeCalled();
        $client->call($method, Argument::type('array'))->willReturn([$user]);
        $hm->hydrate($method, Argument::type('array'))->willReturn($user);

        $user = $this->getCurrentUser();
        $user->get('username')->shouldReturn('benjaming');
    }

    function it_should_retrieve_every_users(ClientInterface $client, HydratorManager $hm, User $user)
    {
        $method = 'wp.getUsers';
        $client->prependParams(Argument::type('array'))->shouldBeCalled();
        $client->call($method, Argument::type('array'))->willReturn([$user, $user]);
        $hm->hydrate($method, Argument::type('array'))->willReturn([$user, $user]);

        $this->getUsers()->shouldHaveCount(2);
    }

    function it_should_retrieve_a_post(ClientInterface $client, HydratorManager $hm, Post $post)
    {
        $client->prependParams(Argument::type('array'))->shouldBeCalled();
        $client->call(Argument::type('string'), Argument::type('array'))->shouldBeCalled()->willReturn([]);
        $hm->hydrate('wp.getPost', Argument::type('array'))->willReturn($post);

        $this->getPost(1)->shouldReturn($post);
    }
}
