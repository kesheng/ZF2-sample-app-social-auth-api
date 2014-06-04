<?php

namespace Application\Repository;

use Sglib\Mapper\Db\AbstractMapper;

class UserRepository extends AbstractMapper
{
    /**
     * Get username count
     *
     * @param string $username
     * @param string $email
     * @return integer
     */
    public function getUsernameCount($username, $email)
    {
        $dql = <<<DQL
SELECT COUNT(u.id)
FROM Application\Entity\User u
WHERE
    u.username = :username OR
    u.email = :email
DQL;

        $query = $this->getEntityManager()->createQuery($dql);

        $query->setParameter('username', $username);
        $query->setParameter('email', $email);

        return $query->getSingleScalarResult();
    }
}
