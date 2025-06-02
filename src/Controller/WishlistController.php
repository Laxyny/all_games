<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\WishlistItem;
use App\Repository\WishlistItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WishlistController extends AbstractController
{
    #[Route(
        '/game/{id}/wishlist/toggle',
        name: 'app_game_wishlist_toggle',
        methods: ['POST']
    )]
    public function wishlistToggle(
        Request $request,
        Game $game,
        EntityManagerInterface $entityManager,
        WishlistItemRepository $wishlistRepository
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You need to be connected.');
        }
        $wishlist = $wishlistRepository->findOneBy(['game' => $game, 'user' =>
        $user]);
        if ($wishlist) {
            $entityManager->remove($wishlist);
            $wishlist = null;
        } else {
            $wishlist = new WishlistItem();
            $wishlist->setUser($user);
            $wishlist->setGame($game);
            $entityManager->persist($wishlist);
        }
        $entityManager->flush();
        return $this->render('wishlist/_wishlist_button.html.twig', [
            'game' => $game,
            'wishlist' => $wishlist,
        ]);
    }

    #[Route('/wishlist/', name: 'app_wishlist')]
    public function list(WishlistItemRepository $wishlistRepository): Response
    {
        $wishlistItems = $wishlistRepository->findBy(["user" =>
        $this->getUser()]);
        return $this->render('wishlist/list.html.twig', [
            'wishlistItems' => $wishlistItems,
        ]);
    }
}
