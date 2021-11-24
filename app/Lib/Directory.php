<?php

namespace App\Lib;

use App\Lib\Contracts\DirectoryInterface;

class Directory implements DirectoryInterface {

    /**
     * List entries in folders
     *
     * @param  string      $username Current user's name
     * @param  string      $path     Current user's path
     * @param  int|integer $type     If set to 0, scan only files,
     *                               and if set to 1, scan only folders
     * @return array                 List of entries based on $type
     */
    public function list(string $username, string $path, int $type = 1): array {
        if($type) {
            $entries = glob($path . "*", GLOB_ONLYDIR);
        } else {
            $entries = $dirs = array_values(array_filter(glob($path . "*"), "is_file"));
        }

        return $entries;
    }

    /**
     * Create file or directory based on $type.
     *
     * @param  string      $path Current user's directory path
     * @param  int|integer $type If set to 0, Only create a file,
     *                           and if set to 1, Only create a folder
     * @return boolean           Creation status
     */
    public function create(string $path, int $type = 1): bool {
        // TODO: Needs improvement
        if($type) {
            if(is_dir($path)) {
                return false;
            }

            mkdir($path, 0755, true);
            return true;
        } else {
            if(!file_exists($path)) {
                touch($path);
                return true;
            }

            return false;
        }
    }
}
