<?php

namespace App\Helpers\Traits;

use ErrorException;
use Exception;
use RuntimeException;

/**
 * Trait HasFile
 *
 * @property string $tempDirName
 * @property string $rootDirPath
 * @package App\Helpers\Traits
 */
trait HasFile
{
    /**
     * Generate/create a file path using UUID
     *
     * @param string|null $fileName
     * @param string|null $childDir
     * @param bool        $makeDir
     * @return string
     * @throws Exception
     */
    public function createPath(string $fileName = null, string $childDir = null, bool $makeDir = true): string
    {
        # Check if UUID property exists and is not empty
        if (property_exists($this, "id") && empty($this->id)) {
            throw new ErrorException("Failed to generate file path! No id is present.");
        }

        # Get root storage path & create unique hashed directory path from UUID
        $rootPath = storage_path($this->rootDirPath ?: null);

        # Join the root storage path & video's directory path
        $directoryPath = $rootPath . DIRECTORY_SEPARATOR . $this->id;

        # Append child directory with the path
        if (!empty($childDir)) $directoryPath .= DIRECTORY_SEPARATOR . $childDir;

        # Create directories using the path if needed
        if ($makeDir === true) $this->createPathDirectory($directoryPath);

        # Return full directory path including file name
        return $directoryPath . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * Create the given path
     *
     * @param string $directoryPath
     */
    private function createPathDirectory(string $directoryPath): void
    {
        $max_try = 1;
        do {
            # Check if the directory already exists
            if (file_exists($directoryPath)) break;

            # Try to create directory
            if (mkdir($directoryPath, 0777, true)) break;
        } while ($max_try++ < 10);

        # Throw an exception if directory creation failed
        if ($max_try >= 10) {
            throw new RuntimeException("Couldn't create the path, giving up");
        }
    }
}
