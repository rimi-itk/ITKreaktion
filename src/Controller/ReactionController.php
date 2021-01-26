<?php

namespace App\Controller;

use App\Entity\Reaction;
use App\Form\ReactionType;
use App\Repository\ReactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reaction")
 */
class ReactionController extends AbstractController
{
    /**
     * @Route("/", name="reaction_index", methods={"GET"})
     */
    public function index(ReactionRepository $reactionRepository): Response
    {
        return $this->render('reaction/index.html.twig', [
            'reactions' => $reactionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reaction_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reaction = new Reaction();
        $form = $this->createForm(ReactionType::class, $reaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reaction);
            $entityManager->flush();

            return $this->redirectToRoute('reaction_index');
        }

        return $this->render('reaction/new.html.twig', [
            'reaction' => $reaction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reaction_show", methods={"GET"})
     */
    public function show(Reaction $reaction): Response
    {
        return $this->render('reaction/show.html.twig', [
            'reaction' => $reaction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reaction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reaction $reaction): Response
    {
        $form = $this->createForm(ReactionType::class, $reaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            return $this->redirectToRoute('reaction_index');
        }

        return $this->render('reaction/edit.html.twig', [
            'reaction' => $reaction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reaction_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reaction $reaction): Response
    {
        if (
            $this->isCsrfTokenValid(
                'delete' . $reaction->getId(),
                $request->request->get('_token')
            )
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reaction_index');
    }
}
