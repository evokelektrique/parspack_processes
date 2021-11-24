<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ZipUserFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:zip {name*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Zip files for given users list in their original base path.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $app_name = env("APP_NAME", "parspack_app");
        $names = $this->argument("name");
        foreach($names as $name) {
            $path = "/opt/" . $app_name . "/" . $name . "/";
            $this->info("Zipping files into '$path'");
            $this->zip_files($path);
        }

        return Command::SUCCESS;
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
