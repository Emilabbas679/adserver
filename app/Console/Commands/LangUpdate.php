<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LangUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:update';

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
        return true;
        $rows = 10;
        $files = [];
        $page = 0;
        while($rows > 0) {
            $page++;
            $items = $this->api->get_langauage_phrase(['page'=>$page])->post();
            $items = $items['data']['rows'];
            $rows = count($items);
            foreach ($items as $item) {
                $file = base_path('resources/lang/'.$item['language_id'].'/'.$item['module_id'].'.php');
                $files[$file][$item['var_name']] =$item['text'];
            }
        }
        foreach ($files as $file => $value) {
            $ftemplate = "<?php \n return [\n ";
            if (!file_exists($file))
                file_put_contents(base_path($file), $ftemplate);
            else{
                $lang_file = fopen($file, 'w');
                fwrite($lang_file, $ftemplate);
                fclose($lang_file);
            }
            $current = file_get_contents($file);
            foreach ($value as $k=>$v) {
                $v = str_replace('"', "'", $v);
                $current = $current."\n".'"'.$k.'" => "'.$v.'",'."\n";
            }
            $current = $current."\n ]; ";
            file_put_contents($file, $current);
        }

        return true;
    }
}
