<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\Contracts\DirectoryInterface;
use App\Models\User;

class FileController extends Controller {

    protected $directory;
    protected $users;
    protected $app_name;

    public function __construct(DirectoryInterface $directory, User $users) {
        $this->users = $users;
        $this->directory = $directory;
        $this->app_name = env("APP_NAME", "parspack_app");
    }

    /**
     * List files
     *
     * @param  Request $request
     * @return string           JSON String
     */
    public function index(Request $request) {
        $username = auth()->user()->name;
        $path = "/opt/" . $this->app_name . "/" . $username . "/";
        return $this->directory->list($username, $path, 0); // Set to 0 to scan only files
    }

    /**
     * Create a folder
     *
     * @param  Request $request
     * @return string           JSON String
     */
    public function store(Request $request) {
        // Validation
        $fields = $request->validate([
            // Directory name
            "name" => "required|string"
        ]);

        $username = auth()->user()->name;
        $path = "/opt/" . $this->app_name . "/" . $username . "/" . $fields["name"];
        $file = $this->directory->create($path, 0); // Set to 0 to only create a file

        if(!$file) {
            return response([
                "status" => false,
                "message" => "Something went wrong in creation of folder, probably a problem with permissions."
            ], 200);
        }

        return response([
            "status" => true,
            "message" => "File successfully created",
            "directory" => $path
        ], 201);
    }
}
