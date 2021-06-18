<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use DirectoryIterator;


class EmptyTmpFolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmp:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle()
    {
        print("it starts");
        $files = array_diff(scandir(public_path('uploads/tmp')), array('.', '..'));
        foreach ($files as $file) {
            $created = date ("Y-m-d", filemtime(public_path('uploads/tmp/'.$file)));
            $created = strtotime($created);
            $now =strtotime( date('Y-m-d'));
            $datediff = $now - $created;
            $diffday =  round($datediff / (60 * 60 * 24));
            if ($diffday > 1)
                unlink(public_path('uploads/tmp/'.$file));
        }
        print("\n finished \n");
        return 'ok';
    }
}
