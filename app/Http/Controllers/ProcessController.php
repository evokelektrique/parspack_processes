<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\Contracts\ProcessInterface;
use App\Models\User;

class ProcessController extends Controller {

    protected $processes;
    protected $users;

    public function __construct(ProcessInterface $processes, User $users) {
        $this->users = $users;
        $this->processes = $processes;
    }

    /**
     * List processes
     *
     * @param  Request $request
     * @return string           JSON String
     */
    public function index(Request $request) {
        $username = auth()->user()->name;
        return $this->processes->list($username);
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

