<?php

namespace Blog\CoreBundle\Services;
use Doctrine\ORM\EntityManager;

/**
 * Class PostManager
 */
class PostManager
{
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Find all posts
     *
     * @return array
     */
    public function findAll()
    {
        $posts = $this->em->getRepository('ModelBundle:Post')->findAll();

        return $posts
    }


}