<?php
/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 14/10/2017
 * Time: 18:38
 */

namespace AppBundle\Security;


use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TaskVoter extends Voter
{
    CONST EDIT = 'edit';
    CONST DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Task) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Task $task */
        $task = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($task, $user);
            case self::DELETE:
                return $this->canDelete($task, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Task $task, User $user)
    {
        if ($user->getRoles() === ['ROLE_ADMIN']) {
            return true;
        }

        return $user === $task->getAuthor();
    }

    private function canDelete(Task $task, User $user)
    {
        return $this->canEdit($task, $user);
    }

}
