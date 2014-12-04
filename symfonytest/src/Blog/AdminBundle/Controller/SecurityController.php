<?php


namespace Blog\AdminBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class SecurityController
 */
class SecurityController extends Controller
{
    /**
     * Login
     *
     * @return Response
     *
     * @Route("/login")
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        //Get de login error if ther is one

        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'AdminBundle:Author/Security:login.html.twig',
            array(
                //Last username netered by de user
                'last_username' => $session->get(SecurityContextInterface::LAST_USERNAME),
                'error' => $error
            )
        );
    }

    /**
     * Login check
     *
     * @Route("/login_check")
     */
    public function loginCheckAction()
    {

    }
}