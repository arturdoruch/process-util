<?php

namespace ArturDoruch\ProcessUtil\ProcessingPoint;

/**
 * Interface of the manager, managing the points with the last processed (imported, recovered, read)
 * database or file record.
 *
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
interface ProcessingPointManagerInterface
{
    /**
     * @param string $identifier The process identifier. Depend on the manager can be
     *                           the path to the processing file or custom name for the processing database records.
     *
     * @return ProcessingPoint
     */
    public function get(string $identifier): ProcessingPoint;

    /**
     * Updates id of the last processed record.
     *
     * @param ProcessingPoint $processingPoint
     */
    public function save(ProcessingPoint $processingPoint);

    /**
     * Removes the processing point.
     *
     * @param string $identifier The process identifier. Depend on the manager can be
     *                           the path to the processing file or custom name for the processing database records.
     */
    public function remove(string $identifier);
}
