<?php

namespace ArturDoruch\ProcessUtil\ProcessingPoint;

/**
 * Holds id of the last processed (imported, recovered, read) record of the database or file.
 *
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class ProcessingPoint
{
    /**
     * @var string The process identifier. The path to the processing file or custom name.
     */
    protected $identifier;

    /**
     * @var string Id of the last processed record.
     */
    protected $id;

    /**
     * @param string $identifier The process identifier. The path to the processing file or custom name.
     * @param string $id Id of the last processed record.
     */
    public function __construct(string $identifier, string $id = null)
    {
        $this->identifier = $identifier;
        $this->id = $id;
    }


    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $id Id of the last processed record.
     *                         E.g. id of the database record or index of the file line.
     *
     * @return $this
     */
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }


    public function getId(): ?string
    {
        return $this->id;
    }
}
