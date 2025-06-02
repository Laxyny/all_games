<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReviewController extends AbstractController
{
    #[Route('/review/{id}/form', name: 'app_review_form')]
    public function form(
        Game $game,
        Request $request,
        ReviewRepository $reviewRepository,
        Security $security,
        EntityManagerInterface $em
    ): Response {
        $user = $security->getUser();
        $review = $reviewRepository->findOneBy(['game' => $game, 'user' => $user]);
        if (!$review) {
            $review = new Review();
            $review->setGame($game);
            $review->setUser($user);
        }
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($review);
            $em->flush();
        }
        return $this->render('review/_form.html.twig', [
            'form' => $form->createView(),
            'gameId' => $game->getId(),
            'review' => $review
        ]);
    }
}
