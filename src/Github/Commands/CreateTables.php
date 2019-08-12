<?php

namespace Github\Commands;


use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateTables extends Command
{
  protected function configure()
  {
    $this
      ->setName('app:create-tables')
      ->setDescription('Create necessary tables')
      ->setHelp('Create necessary tables')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    /** @var Connection $conn */
    $conn = $this->getHelper('db')->getConnection();

    $q =
      'CREATE TABLE `user` (
          `github_id` int(11) UNSIGNED NOT NULL,
          `github_login` varchar(255) NOT NULL,
          PRIMARY KEY (github_id)
        ) ENGINE=InnoDB;'
    ;
    $conn->query($q);

    $output->writeln('<info>Tables have been created successfully</info>');
  }

}