<?php


namespace App\Controller;


use App\Service\HomeService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/", name="backend_home_")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(Request $request, HomeService $homeService): Response
    {
        $projects = $homeService->getProjects($request->query->getInt('page', 1));

        return $this->render('backend/home/index.html.twig', [
            'projects' => $projects,
        ]);
    }
}