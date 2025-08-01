<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UpdateController extends AbstractController
{
    #[Route('/api/update/{id}', name: 'app_user_update', methods: ['PUT'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function updateUser(
        int $id,
        Request $request,
        UsersRepository $usersRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $user = $entityManager->getRepository(Users::class)->find($id);

        if (!$user) {
            return $this->json([
                "failure" => false, 
                "message" => "Utilisateur non trouvé"], 404);
        }

        $data = json_decode($request->getContent(), true);
        $user = $usersRepository->updateUser($user, $data);

        return $this->json([
                "success" => true, 
                "message" => "Utilisateur modifié",
                'id' => $user->getId()], 202);
    }

    #[Route('/api/delete/{id}', name: 'app_user_delete', methods: ['DELETE'])] 
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function deleteUser(
        int $id,
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository,
    ): JsonResponse
    {
        $user = $entityManager->getRepository(Users::class)->find($id);

        if (!$user) {
            return $this->json([
                "failure" => false, 
                "message" => "Utilisateur non trouvé"], 404);
        }

        $user = $usersRepository->deleteUser($user);

        return $this->json([
                "success" => true, 
                "message" => "Utilisateur supprimé"], 202);
    }
}
