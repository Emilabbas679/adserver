<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TranslateController extends Controller
{
    public function index(Request $request)
    {
        $files = $this->availableTranslationFiles();
        $file = $request->file ?? $files[1];
        $languages = Config::get('global.languages');
        foreach ($languages as $key => $value) {
            $f = base_path("resources/lang/" . $key . "/$file");
            if(!is_file($f)){
                $contents = file_get_contents(base_path("resources/lang/" . config("app.fallback_locale") . "/$file"));
                file_put_contents($f, $contents);
            }
            $lang[$key] = include($f);
        }
//        $files = sort($files);
        sort($files);
        return view("translate.index", compact("files", "file", "lang", 'languages'));
    }


    public function update(Request $request)
    {
        $f = $request->file ?? $this->availableTranslationFiles()[1];
        $languages = Config::get('global.languages');
        foreach ($languages as $k => $v) {
            $n = 0;
            $file = "<?php \n return [\n";
            foreach ($request->key as $key) {
                if (empty($key)) {
                    $n++;
                    continue;
                }
                $file .= "\"" . $this->neatStr($key) . "\" => \"" . $this->neatStr($request[$k][$n]) . "\",\n";
                $n++;
            }
            $file .= "];";
            file_put_contents(base_path('resources/lang/' . $k . "/$f"), $file);
        }
        if($request->file){
            $r = "?file=".$request->file;
        }else{
            $r = "";
        }

        return redirect("/".app()->getLocale().'/translate'.$r)->with('success', 'Yenilənmə əməliyyatı uğurla başa çatdı.');
    }

    public function availableTranslationFiles(){
        $files = $this->listOfFiles("/resources/lang/".config("app.fallback_locale"));

        foreach($files as $key=>$file){
            if($file == "validation.php")
                unset($files[$key]);
        }

        return $files;
    }

    public function create_files(Request $request) {
        $fname = $request->filename;
        $fname_lowered = mb_strtolower(str_replace(array(' ','-','%20'), array('_','_','_'), $fname));
        $ftemplate = "<?php \n return [\n
            '' => '',\n
        ];";
        $languages = Config::get('global.languages');
        foreach($languages as $k => $v){
            file_put_contents(base_path('resources/lang/'.$k.'/'.$fname_lowered.'.php'), $ftemplate);
        }

        return redirect('/'.app()->getLocale().'/translate?file='.$fname_lowered.'.php')->with('success', 'New file named '.$fname_lowered.'.php created successfully.');
    }

    function listOfFiles($dir)
    {
        $files = [];

        $helperDir = base_path().$dir;
        if ($dh = opendir($helperDir)) {
            while ($file = readdir($dh)) {
                if (is_file($helperDir.'/'.$file)) {
                    $files[] = $file;
                }
            }
        }

        return $files;
    }

    function neatStr($str)
    {
        if (strlen($str) > 5000) {
            abort(403);
        } // Let Administrator know about this attempt by email!
        return str_replace(['<', '>', '"', '\\', ';'], '', $str);
    }

    public function updateCron()
    {
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
                file_put_contents($file, $ftemplate);
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

        return redirect()->route('admin.translations', app()->getLocale())->with('success', __('adnetwork.successfully_updated'));
    }
}
