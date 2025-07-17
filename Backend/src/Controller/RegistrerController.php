<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RegistrerController extends AbstractController
{
    #[Route('/registrer', name: 'registrer', methods:['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new Users();
        $user->setNom($data['Nom'] ?? '');
        $user->setEmail($data['Email'] ?? '');
        
        $roleName = $data['Role'] ?? null;
        $role = $entityManager->getRepository(Roles::class)->findOneBy(['name' => $roleName]);
            if (!$role) {
                return $this->json(['success' => false, 'message' => 'Rôle invalide'], 400);
            }

        $user->setRole($role);
        
        $hashedPassword = $passwordHasher->hashPassword($user, $data['Password']);
        $user->setPassword($hashedPassword);

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsMessages = [];
            foreach ($errors as $error) {
                $errorsMessages[] = $error->getPropertyPath() . ':' . $error->getMessage();
        }

        return $this->json([
            'success' => false,
            'errors' => $errorsMessages,
        ], 400);
    }

    $entityManager->persist($user);
    $entityManager->flush();

    return $this->json([
        'success' => true,
        'messages' => 'User créer avec succès',
        'id' => $user->getId(),
    ]);

    }
}
