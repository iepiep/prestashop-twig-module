<?php
/**
 * @author Roberto Minini <r.minini@solution61.fr>
 * @copyright 2025 Roberto Minini
 * @license MIT
 */

namespace DimSymfony\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Doctrine\DBAL\Connection;

class AppointmentRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $dbPrefix;

    /**
     * @var string
     */
    private $table;

    /**
     * @param Connection $connection
     * @param string $dbPrefix
     */
    public function __construct(Connection $connection, string $dbPrefix)
    {
        $this->connection = $connection;
        $this->dbPrefix = $dbPrefix;
        $this->table = $this->dbPrefix . 'dim_rdv';
    }

    /**
     * Get all appointments
     *
     * @return array
     */
    public function findAll(): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('*')
           ->from($this->table)
           ->orderBy('created_at', 'DESC');

        return $qb->execute()->fetchAll();
    }

    /**
     * Find an appointment by ID
     *
     * @param int $id
     * @return array|null
     */
    public function find(int $id): ?array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('*')
           ->from($this->table)
           ->where('id_dim_rdv = :id')
           ->setParameter('id', $id);

        $result = $qb->execute()->fetch();

        return $result ?: null;
    }

    /**
     * Toggle the visited status of an appointment
     *
     * @param int $id
     * @return bool
     */
    public function toggleVisited(int $id): bool
    {
        $appointment = $this->find($id);

        if (!$appointment) {
            return false;
        }

        $newStatus = !$appointment['visited'];

        $qb = $this->connection->createQueryBuilder();
        $qb->update($this->table)
           ->set('visited', ':visited')
           ->where('id_dim_rdv = :id')
           ->setParameter('visited', $newStatus, \PDO::PARAM_INT)
           ->setParameter('id', $id);

        return (bool) $qb->execute();
    }

    /**
     * Delete an appointment
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->delete($this->table)
           ->where('id_dim_rdv = :id')
           ->setParameter('id', $id);

        return (bool) $qb->execute();
    }
}
