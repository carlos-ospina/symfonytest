<?php

namespace Blog\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AuthorController
 */
class AuthorController extends Controller
{
    /**
     * Show post by Author
     *
     * @param string $slug
     *
     * @Route("/author/{slug}")
     * @Template()
     *
     * @throws NotFoundHttpException
     *
     * @return array
     */
    public function showAction($slug)
    {
        $author = $this->getDoctrine()->getRepository('ModelBundle:Author')->findOneBy(
            array(
                'slug' => $slug
            )
        );

        if (null == $author) {
            throw $this->createNotFoundException('author was not found');
        }


        $posts = $this->getDoctrine()->getRepository('ModelBundle:Post')->findBy(
            array(
                'author' => $author
            )
        );

        return array(
            'author' => $author,
            'posts' => $posts
        );
    }

}