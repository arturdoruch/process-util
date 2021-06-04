<?php

namespace ArturDoruch\ProcessUtil\ProcessingPoint;

use ArturDoruch\Filesystem\Filesystem;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class FileProcessingPointManager implements ProcessingPointManagerInterface
{
    /**
     * @var string[]
     */
    private $filenames;

    /**
     * @var string
     */
    private $outputDirectory;

    /**
     * @param string $outputDirectory The path to the directory where the files with the last line
     *                                of processing file will be written.
     */
    public function __construct(string $outputDirectory)
    {
        Filesystem::createDirectory($this->outputDirectory = $outputDirectory);
    }


    public function get(string $identifier): ProcessingPoint
    {
        $index = Filesystem::read($this->getFilename($identifier));

        return new ProcessingPoint($identifier, $index);
    }


    public function save(ProcessingPoint $point)
    {
        Filesystem::write($this->getFilename($point->getIdentifier()), $point->getId());
    }

    /**
     * Removes the file with processing point.
     *
     * {@inheritdoc}
     */
    public function remove(string $identifier)
    {
        Filesystem::remove($this->getFilename($identifier));
    }


    private function getFilename(string $processingFile): string
    {
        if (!isset($this->filenames[$processingFile])) {
            if (!file_exists($processingFile)) {
                throw new \RuntimeException(sprintf('The processing file "%s" does not exist.', $processingFile));
            }

            $filename = $this->filenames[$processingFile] = $this->outputDirectory . '/' . md5_file($processingFile) . '.txt';

            if (!file_exists($filename)) {
                Filesystem::write($filename, '');
            }
        }

        return $this->filenames[$processingFile];
    }
}
