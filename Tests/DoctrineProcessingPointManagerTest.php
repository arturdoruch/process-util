<?php

namespace ArturDoruch\ProcessUtil\Tests;

use ArturDoruch\ProcessUtil\ProcessingPoint\DoctrineProcessingPointManager;
use ArturDoruch\ProcessUtil\Tests\Fixtures\Entity\ProcessingPoint;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class DoctrineProcessingPointManagerTest extends TestCase
{
    public function test()
    {
        $entityClass = ProcessingPoint::class;
        $em = $this->createEntityManager();
        $schemaTool = new SchemaTool($em);
        $schemaTool->createSchema([$em->getClassMetadata($entityClass)]);

        $pointManager = new DoctrineProcessingPointManager($em, $entityClass);

        $point = $pointManager->get($identifier = 'import-products');
        $pointManager->save($point->setId(5));

        $point = $pointManager->get($identifier);
        self::assertEquals(5, $point->getId());

        $pointManager->remove($identifier);
        self::assertEmpty($em->getRepository($entityClass)->findAll());
    }


    private function createEntityManager(): EntityManager
    {
        if (!extension_loaded('pdo_sqlite')) {
            throw new \RuntimeException('Extension pdo_sqlite is required.');
        }

        $config = new Configuration();
        $config->setAutoGenerateProxyClasses(true);
        $config->setProxyDir(sys_get_temp_dir());
        $config->setProxyNamespace('ArturDoruch\ProcessUtil\Tests\Fixtures\Proxy');
        $config->setMetadataDriverImpl(new AnnotationDriver(new AnnotationReader()));

        return EntityManager::create([
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ], $config);
    }
}
