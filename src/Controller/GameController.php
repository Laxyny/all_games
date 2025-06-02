<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\WishlistItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(): Response
    {
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }

    #[Route('/game/list', name: 'app_game_list')]
    public function list(GameRepository $gameRepository): Response
    {
        //get all games
        $games = $gameRepository->findAll();
        return $this->render('game/list.html.twig', [
            'games' => $games,
        ]);
    }

    #[Route('/game/{id}', name: 'app_game_show')]
    public function show(Game $game, Request $request, EntityManagerInterface
    $entityManager, WishlistItemRepository $wishlistRepository): Response
    {
        $user = $this->getUser();
        $wishlist = $wishlistRepository->findOneBy(['game' => $game, 'user' =>
        $user]);
        return $this->render('game/show.html.twig', [
            'game' => $game,
            'wishlist' => $wishlist,
        ]);
    }
}
