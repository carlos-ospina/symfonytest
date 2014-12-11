<?php

namespace Blog\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AuthorController
 *
 * @Route("/{_locale}/author", requirements={"_locale"="en|es"}, defaults={"_locale"="en"})
 */
class AuthorController extends Controller
{
    /**
     * Show post by Author
     *
     * @param string $slug
     *
     * @Route("/{slug}")
     * @Template()
     *
     * @throws NotFoundHttpException
     *
     * @return array
     */
    public function showAction($slug)
    {
        $author = $this->getAuthorManager()->findBySlug($slug);

        $posts = $this->getAuthorManager()->findPosts($author);

        return array(
            'author' => $author,
            'posts' => $posts
        );
    }

    /**
     * Get author manager
     *
     * @return AuthorManager
     */
    private function getAuthorManager()
    {
        return $this->get('authorManager');
    }

}
