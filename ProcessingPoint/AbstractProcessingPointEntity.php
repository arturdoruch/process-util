<?php

namespace ArturDoruch\ProcessUtil\ProcessingPoint;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 * @ORM\Table(name="processing_points")
 *
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
abstract class AbstractProcessingPointEntity extends ProcessingPoint
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=64)
     */
    protected $identifier;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $id;
}
