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

 protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
{
    $user = $token->getUser();

    if (!$user instanceof Users) {
        return false;
    }

    $userRoles = $user->getRoles();

    switch ($attribute) {
        case self::VIEW:
            return $user->getId() === $subject->getId();

        case self::EDIT:
            return $user->getId() === $subject->getId() || in_array('ROLE_ADMIN', $userRoles);

        case self::DELETE:
            return in_array('ROLE_ADMIN', $userRoles) || in_array('ROLE_CANDIDAT', $userRoles);

        default:
            return false;
    }
}
}
