<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Blog\ModelBundle\Entity\Comment;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixtures for the Comment Entity
 */
class Comments extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 20;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $posts = $manager->getRepository('ModelBundle:Post')->findAll();
        $comments = array(
            0 => 'Vestibulum ut diam felis. Nam a massa sed nisl pretium posuere in vitae orci. Aliquam quis fringilla tortor. Maecenas ac.',
            1 => 'Integer finibus purus sed nisi accumsan bibendum. Nulla tristique nunc in rutrum sodales. Mauris condimentum ultrices bibendum. Donec sit amet.',
            2 => 'Donec a metus ex. Duis maximus erat at dolor lacinia vulputate. Nam facilisis, lectus aliquet mollis efficitur, nunc velit feugiat.'
        );

        $i = 0;

        foreach ($posts as $post) {
            $comment = new Comment();
            $comment->setAuthorName('Someone');
            $comment->setBody($comments[$i++]);
            $comment->setPost($post);

            $manager->persist($comment);
        }

        $manager->flush();
    }
}