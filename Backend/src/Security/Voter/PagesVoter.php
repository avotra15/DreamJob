<?php

namespace App\Security\Voter;

use App\Entity\Users;
use App\Service\SearchPageService;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class PagesVoter extends Voter
{
    public const VIEW = 'POST_VIEW';

    private SearchPageService $searchPageService;

    protected function supports(string $attribute, mixed $subject): bool
    {
        $Allpages = $this->searchPageService->filesearch();

        return in_array($attribute, [self::VIEW])
            && $subject instanceof $Allpages;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof Users) {
            return false;
        }
        switch ($attribute) {
            case self::VIEW:
                break;
        }

        return false;
    }
}
