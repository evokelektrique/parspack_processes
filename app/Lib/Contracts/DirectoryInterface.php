<?php

namespace App\Lib\Contracts;

interface DirectoryInterface {
    public function list(string $username, string $path, int $type = 1): array;
    public function create(string $path, int $type = 1): bool;
}
