<?php

namespace App\Security\Voter;

use App\Entity\Users;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class UserVoter extends Voter
{
    public const VIEW = 'VIEW';
    public const EDIT = 'EDIT';
    public const DELETE = 'DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE, self::VIEW])
            && ($subject instanceof Users || $subject === null);
    }

    /**
     * @param Users || null $subject
     */

    public function __construct(private AccessDecisionManagerInterface $accessDecisionManager) 
    {
    }

 protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
{
    $user = $token->getUser();

    if (!$user instanceof Users) {
        return false;
    }

    $userRoles = $user->getRoles();

    switch ($attribute) {
        case self::VIEW:
            // Un utilisateur peut voir son propre profil ou les admins peuvent tout voir
            return $subject === $user || in_array('ROLE_ADMIN', $userRoles);

        case self::EDIT:
            // Un utilisateur peut modifier son propre profil ou les admins peuvent tout modifier
            return $subject === $user || in_array('ROLE_ADMIN', $userRoles);

        case self::DELETE:
            // Seuls les admins peuvent supprimer des utilisateurs
            return in_array('ROLE_ADMIN', $userRoles) || in_array('ROLE_CANDIDAT', $userRoles);

        default:
            return false;
    }
}
}
