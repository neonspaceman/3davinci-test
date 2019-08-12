<?php

namespace Github\Repository;


use Doctrine\DBAL\Connection;
use Github\Entity\User;

class GetUserRepo
{
  /**
   * @var Connection
   */
  private $conn;

  public function __construct(Connection $conn)
  {
    $this->conn = $conn;
  }

  public function saveOrUpdate(User $user)
  {
    $q = 'INSERT INTO `user` (`github_id`, `github_login`) VALUES (:githubId, :githubLogin) ON DUPLICATE KEY UPDATE `github_login` = :githubLogin';
    $stmt = $this->conn->prepare($q);
    $stmt->bindValue('githubId', $user->getId());
    $stmt->bindValue('githubLogin', $user->getLogin());
    $stmt->execute();
  }
}