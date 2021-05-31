<?php


namespace App\Service;


use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{
    public $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function isVerified(UserInterface $userInterface): bool
    {
        $user = $this->userRepo->findOneBy(['email' => $userInterface->getUsername()]);

        return $user->isVerified();
    }
}