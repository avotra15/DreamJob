<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class RegistrerController extends AbstractController
{
    #[Route('/registrer', name: 'registrer', methods:['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['Email'];

        // Vérifier si l'utilisateur existe déjà
        $existingUser = $entityManager->getRepository(Users::class)->findOneBy(['email' => $email]);

        if ($existingUser) {
            return new JsonResponse([
                'failure' => false,
                'message' => 'Email déjà utilisé'],400);
        }

        $user = new Users();
        $user->setNom($data['Nom'] ?? '');
        $user->setEmail($data['Email'] ?? '');
        
        $roleName = $data['Roles'] ?? null;
        $role = $entityManager->getRepository(Roles::class)->findOneBy(['roles' => $roleName]);
            if (!$role) {
                return $this->json(['success' => false, 'message' => 'Rôle invalide'], 400);
            }

        $user->setRole($role);
        
        $hashedPassword = $passwordHasher->hashPassword($user, $data['Password']);
        $user->setPassword($hashedPassword);

    $entityManager->persist($user);
    $entityManager->flush();

    return $this->json([
        'success' => true,
        'messages' => 'User créer avec succès',
        'id' => $user->getId(),
    ], 200);
    $this->redirectToRoute('login');
    } 
}