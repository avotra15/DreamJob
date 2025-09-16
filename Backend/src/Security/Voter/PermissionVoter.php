<?php

namespace App\Security\Voter;

use App\Constants\PermissionConstants;
use App\Entity\Users;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class PermissionVoter extends Voter
{

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, PermissionConstants::PERMISSIONS);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof Users) {
            return false;
        }

        return false;
    }
}
