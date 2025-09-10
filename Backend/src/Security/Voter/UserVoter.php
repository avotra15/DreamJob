<?php

namespace App\Security\Voter;

use App\Entity\Users;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class UserVoter extends Voter
{
    public const VIEW = 'VIEW';
    public const CREATE = 'CREATE';
    public const EDIT = 'EDIT';
    public const DELETE = 'DELETE';

    /*private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }*/

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE, self::VIEW, self::CREATE])
            && $subject instanceof Users;
    }

    /**
     * @param Users $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

       if (!$user instanceof Users) {
            return false;
        }

        $roleName = $user->getRoles();

       switch ($attribute) {
            case self::CREATE:
                return in_array('ROLE_ADMIN', $roleName, true);
                //return $this->security->isGranted('ROLE_ADMIN');

            case self::VIEW:
                return  $subject->getRoles() === $user;

            case self::EDIT:
                return  $subject->getRoles() === $user;

            case self::DELETE:
                return  $subject->getRoles() === $user;

            default:
                return false;
        }
    }
}
