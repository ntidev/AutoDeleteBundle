<?php

namespace NTI\AutoDeleteBundle\Service;

use NTI\AutoDeleteBundle\Entity\AutoDeleteEntry;
use Symfony\Component\DependencyInjection\ContainerInterface;

class  CleanDirectoryService {

    /** @var ContainerInterface $container */
    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * Takes care of deleting the files that are older than $days
     * returns the amount of files that were deleted
     *
     *
     * @param AutoDeleteEntry $entry
     * @return int
     */
    public function clean(AutoDeleteEntry $entry) {

        $path = $entry->getPath();
        $seconds = $entry->getSeconds();

        if(file_exists($path)) {
            if(is_dir($path)) {
                return $this->rrmdir($entry, $path, $seconds);
            } else {
                if (filemtime($path) <= time() - $seconds) {
                    if(unlink($path)) {
                        return 1;
                    } else {
                        return 0;
                    }
                }
            }
        }

        return 0;
    }

    /**
     * Recursively delete a directory and its content
     *
     * @param AutoDeleteEntry $entry
     * @param $dir
     * @param $seconds
     * @param int $count
     * @return int
     */
    private function rrmdir(AutoDeleteEntry $entry, $dir, $seconds, $count = 0)
    {
        $deleteEmptyDirectory = !$entry->isKeepEmptyDir();

        if (is_dir($dir)) {

            // Check if the directory is empty and delete it if configured to do so
            if($this->isEmpty($dir) && $deleteEmptyDirectory) {
                rmdir($dir);
                return;
            }

            $objects = scandir($dir);

            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {

                    if (filetype($dir . "/" . $object) == "dir" && $entry->isRecursive()) {
                        $this->rrmdir($entry, $dir . "/" . $object, $seconds, $count);
                    }
                    if (filemtime($dir . "/" . $object) <= time() - $seconds) {
                        if(unlink($dir . "/" . $object)) {
                            $count++;
                            // Recheck if the directory is empty after the file was deleted
                            if($this->isEmpty($dir) && $deleteEmptyDirectory) {
                                rmdir($dir);
                            }
                        }
                    }
                }
            }
            reset($objects);
        }
        return $count;
    }

    /**
     * Check if a directory is empty
     * @param $path
     * @return bool
     */
    private function isEmpty($path) {
        $handle = opendir($path);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                return FALSE;
            }
        }
        return TRUE;
    }
}