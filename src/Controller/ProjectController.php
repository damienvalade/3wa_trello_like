<?php


namespace App\Controller;


use App\Entity\Project;
use App\Entity\User;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjectController
 *
 * @Route("/project", name="backend_project_")
 */
class ProjectController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/new", name="new")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $project->setUserProject($user);
            $this->em->persist($project);
            $this->em->flush();

            return $this->redirectToRoute('backend_user_profile');
        }

        return $this->render('backend/project/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}