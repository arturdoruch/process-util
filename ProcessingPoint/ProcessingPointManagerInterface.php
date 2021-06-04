<?php

namespace ArturDoruch\ProcessUtil\ProcessingPoint;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
interface ProcessingPointManagerInterface
{
    /**
     * @param string $identifier The process identifier. The path to the processing file
     *                           or custom name for the processing database records.
     *
     * @return ProcessingPoint
     */
    public function get(string $identifier): ProcessingPoint;

    /**
     * @param ProcessingPoint $processingPoint
     */
    public function save(ProcessingPoint $processingPoint);

    /**
     * Removes the processing point.
     *
     * @param string $identifier The process identifier. The path to the processing file
     *                           or custom name for the processing database records.
     */
    public function remove(string $identifier);
}
