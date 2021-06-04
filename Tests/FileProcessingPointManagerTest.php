<?php

namespace ArturDoruch\ProcessUtil\Tests;

use ArturDoruch\ProcessUtil\ProcessingPoint\FileProcessingPointManager;
use ArturDoruch\ProcessUtil\ProcessingPoint\ProcessingPointManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class FileProcessingPointManagerTest extends TestCase
{
    public function test()
    {
        $pointManager = $this->createProcessingPointManager($outputDir = __DIR__ . '/data/import-csv-points');

        $point = $pointManager->get(__DIR__ . '/Fixtures/products.csv');
        $pointManager->save($point->setId(3));

        $point = $pointManager->get($point->getIdentifier());
        self::assertEquals(3, $point->getId());

        $pointManager->remove($point->getIdentifier());
        self::assertEmpty(glob($outputDir . '/*'));
    }


    private function createProcessingPointManager($outputDir): ProcessingPointManagerInterface
    {
        return new FileProcessingPointManager($outputDir);
    }
}
