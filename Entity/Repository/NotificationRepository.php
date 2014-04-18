<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Sekou KOÏTA <sekou.koita@supinfo.com>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\NotificationBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * NotificationRepository 
 */
class NotificationRepository extends EntityRepository
{
    /**
     * Find by query builder
     * 
     * @param array $criteria
     * @param array|null $orderBy
     * 
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByQueryBuilder(array $criteria, array $orderBy = null)
    {
        $qb = $this->createQueryBuilder('entity');

        if(!is_null($orderBy)) {
            foreach($orderBy as $field => $order) {
                $qb->addOrderBy(sprintf("entity.%s", $field), $order);
            }
        }
        
        foreach($criteria as $name => $value) {
            $qb->andWhere(sprintf('entity.%s = %s', $name, $value));
        }

        return $qb;
    }

    /**
     * Find by query
     *
     * @param array $criteria
     * @param array|null $orderBy
     * 
     * @return \Doctrine\ORM\Query
     */
    public function findByQuery(array $criteria = null, array $orderBy = null)
    {
        return $this->findByQueryBuilder($criteria, $orderBy)->getQuery();
    }

    /**
     * Find all query builder
     * 
     * @param array|null $orderBy
     * 
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllQueryBuilder(array $orderBy = null)
    {
        return $this->findByQueryBuilder(array(), $orderBy);
    }

    /**
     * Find all query
     * 
     * @param array|null $orderBy
     * 
     * @return \Doctrine\ORM\Query
     */
    public function findAllQuery(array $orderBy = null)
    {
        return $this->findAllQueryBuilder($orderBy)->getQuery();
    }

    /**
     * Get the number of medias for each mime type
     *
     * @param DateTime from
     * @param DateTime to
     * @param String type
     * @return array
     */
    public function findNumberByStatusForType(\DateTime $from, \DateTime $to, $type)
    {
        return $this
            ->getEntityManager()
            ->createQuery(
                'SELECT n.status, count(n.id) as number
                    FROM IDCINotificationBundle:Notification n
                    WHERE n.createdAt >= :from
                    AND n.createdAt <= :to
                    AND n.type = :type
                    GROUP BY n.status
                '
            )
            ->setParameter('from', $from)
            ->setParameter('to', $to->modify('+1 day'))
            ->setParameter('type', $type)
            ->getResult()
        ;
    }
    
    /**
     * Get the number of medias for each mime type
     *
     * @return array
     */
    public function findAllTypes()
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT DISTINCT n.type FROM IDCINotificationBundle:Notification n')
            ->getResult()
        ;
    }
}
