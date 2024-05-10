<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'add a user',
)]
class UserCreateCommand extends Command
{
    private readonly UserRepository $userRepo;

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
        $this->userRepo = $this->em->getRepository(User::class);
    }

    // protected function configure(): void
    // {
    //     $this
    //         ->addArgument('username', InputArgument::REQUIRED, 'username')
    //         ->addArgument('password', InputArgument::REQUIRED, 'password')
    //     ;
    // }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        do {
            /** @var ?string $username */
            $username = $io->ask('enter username');
            if (empty($username)) {
                $io->error('please enter a valid username!');
            } elseif ($this->userRepo->findBy(['username' => $username])) {
                $io->error('username already registered!');
                $username = null;
            }
        } while (empty($username));

        do {
            /** @var ?string $password */
            $password = $io->askHidden('enter password');
            if (empty($password)) {
                $io->error('please enter a valid password!');
            }
        } while (empty($password));

        do {
            /** @var ?string $role */
            $role = $io->ask('enter the role to assign [ADMIN, USER]');
            if (empty($role) || !in_array($role, ['ADMIN', 'USER'])) {
                $io->error('please enter a valid role!');
            }
        } while (empty($role) || !in_array($role, ['ADMIN', 'USER']));

        $user = new User();
        $user->setUsername($username)
            ->setPassword($this->passwordHasher->hashPassword($user, $password))
            ->setRoles(["ROLE_{$role}"])
        ;

        $this->em->persist($user);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
