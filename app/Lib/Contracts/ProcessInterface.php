<?php

namespace App\Lib\Contracts;

interface ProcessInterface {
    public function list(string $username): array;
    public function get_by_process_id(int $id): string;
}
