<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ZipUserFiles implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $app_name = env("APP_NAME", "parspack_app");
        $users = User::all();
        foreach($users as $user) {
            $path = "/opt/" . $app_name . "/" . $user->name . "/";
            $this->zip_files($path);
        }
    }


    /**
     * Zip files recursively
     *
     * @param  string $path Absolute path of folder that needs to be archived
     * @return void
     */
    private function zip_files(string $path): void {
        $file_name = date("Y-m-d");
        $destination = $path . "$file_name" . ".zip";

        $zip = new \ZipArchive();
        if($zip->open($destination, \ZIPARCHIVE::CREATE) === true) {
            $path = realpath($path);
            if(is_dir($path)) {
                $iterator = new \RecursiveDirectoryIterator($path);
                $iterator->setFlags(\RecursiveDirectoryIterator::SKIP_DOTS);
                $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST);
                foreach($files as $file) {
                    $file = realpath($file);
                    if(is_dir($file)) {
                        $zip->addEmptyDir(str_replace($path . DIRECTORY_SEPARATOR, '', $file . DIRECTORY_SEPARATOR));
                    }elseif(is_file($file)) {
                        $zip->addFile($file,str_replace($path . DIRECTORY_SEPARATOR, '', $file));
                    }
                }
            } elseif(is_file($path)) {
                $zip->addFile($path,basename($path));
            }
        }

        $zip->close();
    }

}
