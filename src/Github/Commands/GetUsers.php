<?php

namespace Github\Commands;


use Doctrine\DBAL\Connection;
use Github\Entity\User;
use Github\Repository\GetUserRepo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

class GetUsers extends Command
{
  /**
   * @var GetUserRepo
   */
  private $getUserRepo;

  protected function configure()
  {
    $this
      ->setName('app:get-users')
      ->setDescription('Get github users list')
      ->setDefinition([
        new InputOption('since', 's', InputOption::VALUE_OPTIONAL, 'The integer ID of the last User that you\'ve seen')
      ])
      ->setHelp('This command get you ability to get users of github')
    ;
  }

  protected function initialize(InputInterface $input, OutputInterface $output)
  {
    /** @var Connection $conn */
    $conn = $this->getHelper('db')->getConnection();
    $this->getUserRepo = new GetUserRepo($conn);
  }


  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $output->writeln('<info>Fetching from github.com</info>');

    $since = (int)$input->getOption('since');

    $http = HttpClient::create();
    $response = $http->request('GET', 'https://api.github.com/users?since=' . $since);

    $users = $response->toArray();

    $output->writeln('<info>Saving into database</info>');
    foreach ($users as $user){
      $user = new User($user);
      $this->getUserRepo->saveOrUpdate($user);
    }

    $output->writeln('<info>Success</info>');
  }
}