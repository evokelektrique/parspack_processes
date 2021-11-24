<?php

namespace App\Lib;

use App\Lib\Contracts\ProcessInterface;

class Process implements ProcessInterface {

    protected $os;

    public function __construct() {
        $this->os = PHP_OS;
    }

    /**
     * Get current operating system name
     * @return [type] [description]
     */
    public function get_os(): string {
        return $this->os;
    }

    /**
     * List running processes
     *
     * @return array            List of processes
     */
    public function list(): array {
        $raw_list = $this->get_raw_list();
        // $parsed_list = $this->parse_list($raw_list);

        return $raw_list;
    }

    /**
     * Get a process by its ID
     *
     * @param  int    $id process ID
     * @return string     Process information
     */
    public function get_by_process_id(int $id): string {
        return "test";
    }

    /**
     * Retrieve an unparsed list of running processe form command line
     *
     * @return array            List of processes
     */
    private function get_raw_list(): array {
        $command = "ps -f -u root 2>&1";
        $stdout = "";
        exec($command, $stdout);

        return $stdout;
    }

    /**
     * Parse and format/beautify a process list
     *
     * @param  array  $lines List of processes
     * @return array         A list of formatted processes
     */
    private function parse_list(array $lines): array {
        $temp_lines = [];
        foreach($lines as $line) {
            $temp_lines[] = preg_split("#\s+#", $line);
        }

        return $temp_lines;
    }

}
