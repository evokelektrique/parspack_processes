<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\Contracts\ProcessInterface;
use App\Models\User;

class ProcessController extends Controller {

    protected $processes;

    public function __construct(ProcessInterface $processes) {
        $this->processes = $processes;
    }

    /**
     * List processes
     *
     * @param  Request $request
     * @return string           JSON String
     */
    public function index(Request $request) {
        return $this->processes->list();
    }

    /**
     * Show a single process ID
     *
     * @param  Request $request
     * @param  int     $id
     * @return string           JSON String
     */
    public function get(Request $request, $id) {
        return $id;
    }
}

