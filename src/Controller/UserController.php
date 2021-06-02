<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 *
 * @Route("/user", name="backend_user_")
 */

class UserController extends AbstractController
{

    /**
     * Profile utilisateur
     *
     * @Route("/profile", name="profile", methods={"GET"})
     */
    public function index()
    {
        return $this->render('backend/user/profile.html.twig', ['user' => $this->getUser()]);
    }
}