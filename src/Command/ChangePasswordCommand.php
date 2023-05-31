<?php

namespace App\Command;

use App\Service\UserServices;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[AsCommand(
    name: 'changePassword',
    description: 'Change password for admin',
)]
class ChangePasswordCommand extends Command
{
    private UserServices $userServices;
    private UserPasswordHasherInterface $userPasswordHasher;

    /**
     * @param UserServices $userServices
     */
    public function __construct(UserServices $userServices, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userServices = $userServices;
        $this->userPasswordHasher = $userPasswordHasher;
        parent::__construct();
    }


    protected function configure(): void
    {
        $this
            ->addArgument('newPassword', InputArgument::REQUIRED, 'New password for admin')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $newPassword = $input->getArgument('newPassword');

        $userAdmin = $this->userServices->getUserByEmail("admin@admin");
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, $newPassword));
        $this->userServices->saveUser($userAdmin);

        $io->success('You have changed password for admin.');

        return Command::SUCCESS;
    }
}
