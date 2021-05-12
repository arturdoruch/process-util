<?php

namespace ArturDoruch\ProcessUtil;

use ArturDoruch\Filesystem\FileSize;

/**
 * Limits memory peak usage of the running script to specified value.
 *
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class MemoryUsageLimiter
{
    /**
     * @var FileSize
     */
    private $size;

    /**
     * @var string
     */
    private $unit;

    /**
     * @param int|float $limit Allowed memory usage limit.
     * @param string $unit The unit of the limit.
     */
    public function __construct($limit, string $unit)
    {
        if (!class_exists(FileSize::class)) {
            throw new \LogicException('To use MemoryUsageLimiter install the "arturdoruch/filesystem" component.');
        }

        $this->size = new FileSize($limit, $unit);
        $this->unit = $unit;
    }

    /**
     * @return FileSize
     */
    public function getLimit(): FileSize
    {
        return $this->size;
    }

    /**
     * Checks whether the memory usage limit has been reached.
     *
     * @param string $message Additional exception message of the reached limit.
     *
     * @throws \RuntimeException When the limit is reached.
     * @todo Maybe create MemoryLimitExceededException for using instead of \RuntimeException
     */
    public function check(string $message = '')
    {
        if ($this->size->getValue() < $memoryUsage = memory_get_peak_usage()) {
            throw new \RuntimeException(trim(sprintf(
                'The memory usage limit of %s has been reached at %s. %s',
                $this->size, (new FileSize($memoryUsage))->format($this->unit), $message
            )));
        }
    }
}
