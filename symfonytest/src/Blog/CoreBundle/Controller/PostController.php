<?php

namespace Blog\CoreBundle\Controller;

use Blog\CoreBundle\Services\PostManager;
use Blog\ModelBundle\Entity\Comment;
use Blog\ModelBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class PostController
 *
 * @ @Route("/{_locale}", requirements={"_locale"="en|es"}, defaults={"_locale"="en"})
 */
class PostController extends Controller
{
    /**
     * Show the post index
     *
     * @Route("/")
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        $posts = $this->getPostManager()->findAll();
        $latestPosts = $this->getPostManager()->findLatest(5);

        return array(
            'posts' => $posts,
            'latestPost' => $latestPosts
        );
    }

    /**
     * Show a post
     *
     * @param string $slug
     *
     * @return array
     *
     * @Route("/{slug}")
     * @Template()
     */
    public function showAction($slug)
    {
        $post = $this->getPostManager()->findBySlug($slug);

        $form = $this->createForm(new CommentType());

        return array(
            'post' => $post,
            'form' => $form->createView()
        );
    }

    /**
     * Create comment
     *
     * @param Request $request
     * @param string  $slug
     *
     * @Route("{slug}/create-comment")
     * @Method("POST")
     * @Template("CoreBundle:Post:Show.html.twig")
     *
     * @return array
     */
    public function createCommentAction(Request $request, $slug)
    {
        $post = $this->getPostManager()->findBySlug($slug);
        $form = $this->getPostManager()->createComment($post, $request);

        if (true === $form) {
             $this->get('session')->getFlashBag()->add('succes', 'your comment was submited successfuly');

            return $this->redirect($this->generateUrl('blog_core_post_show', array('slug' => $post->getSlug())));
        }

        return array(
            'post' => $post,
            'form' => $form->createView()
        );

        return array();
    }

    /**
     * Get pos manager
     *
     * @return PostManager
     */
    private function getPostManager()
    {
        return $this->get('post_manager');
    }
}
