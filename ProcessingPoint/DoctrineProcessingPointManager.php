<?php

namespace ArturDoruch\ProcessUtil\ProcessingPoint;

use Doctrine\ORM\EntityManager;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class DoctrineProcessingPointManager implements ProcessingPointManagerInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $entityClass;

    /**
     * @var string
     */
    private $tableName;


    public function __construct(EntityManager $entityManager, string $entityClass)
    {
        $this->entityManager = $entityManager;
        $this->entityClass = $entityClass;
        $classMetadata = $entityManager->getClassMetadata($entityClass);
        $this->tableName = $classMetadata->getTableName();

        if (!$classMetadata->getReflectionClass()->isSubclassOf(AbstractProcessingPointEntity::class)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid processing point entity class "%s". It must extend the "%s" class.', $entityClass, AbstractProcessingPointEntity::class
            ));
        }
    }


    public function get(string $identifier): ProcessingPoint
    {
        if (!$point = $this->entityManager->getRepository($this->entityClass)->find($identifier)) {
            $point = new $this->entityClass($identifier);
            $this->entityManager->persist($point);
            $this->entityManager->flush();
        }

        return $point;
    }


    public function save(ProcessingPoint $processingPoint)
    {
        if ($class = get_class($processingPoint) !== $this->entityClass) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid processing point entity class. Expected instance of the "%s", but got "%s".',
                $this->entityClass, $class
            ));
        }

        $this->entityManager->getConnection()->update($this->tableName, [
            'id' => $processingPoint->getId()
        ], [
            'identifier' => $processingPoint->getIdentifier()
        ]);
    }


    public function remove(string $identifier)
    {
        $this->entityManager->getConnection()->delete($this->tableName, [
            'identifier' => $identifier
        ]);
    }
}
