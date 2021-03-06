<?php  namespace Deemeetar\TranslationsDebugger;

use Config;
use Illuminate\Translation\Translator as LaravelTranslator;
use Input;

class Translator extends LaravelTranslator {

    /**
     * Get the translation for the given key.
     *
     * @param  string  $key
     * @param  array   $replace
     * @param  string  $locale
     * @return string
     */
    public function get($key, array $replace = array(), $locale = null)
    {
        $result = parent::get($key, $replace, $locale);

        $flag = Config::get('translations-debugger::input_flag');
        if(($method = Input::get($flag, null)) != null) {
           return $this->method($method, $key, $result);
        }
        return $result;
    }

    public function method($method, $key, $result){
        if($method === "link") {
            $url_format = Config::get("translations-debugger::link_url");
            return $this->generateLink($url_format, $key, $result);
        }
        else if($method === "xeditable"){
            $url_format = Config::get("translations-debugger::xdebug_post_url");
            return $this->generateXeditable($key, $result, $url_format);
        }
        else if($method === "show_key"){
            return $key;
        }

        return $this->method(Config::get("translations-debugger::default_method"), $key, $result);
    }

    /**
     * Returns the file portion of the key
     * ex: For 'users.login.password' returns 'users'
     * @param string $key
     * @return string
     */
    public function getFile($key){
        $file = substr($key, 0, strpos($key, "."));
        return $file;
    }

    public function getKey($key){
        $result = substr($key, strpos($key, ".")+1);
        return $result;
    }

    private function generateLink($url_format, $key, $result)
    {
        $link_url = str_replace('$file', $this->getFile($key), $url_format);
        $link_url = str_replace('$key', $this->getKey($key), $link_url);
        $link = "<a href=\"$link_url\" title=\"edit: $key\" target=\"translation\"><img src=\"/packages/deemeetar/translations-debugger/img/edit.png\" alt=\"edit\"/></a> $result";
        return $link;
    }

    public function generateXeditable($key, $result, $url_format)
    {
        $group = $this->getFile($key);
        $key = $this->getKey($key);
        $locales = $this->loadLocales();
        $translations = Translation::where("group", $group)->where("key", $key)->get();
        $translation = [];
        foreach($translations as $trans){
            $translation[$trans['locale']] = $trans;
        }
        $editUrl = str_replace('$file', $group, $url_format);
        $editUrl = str_replace('$key', $key, $editUrl);
        return \View::make("translations-debugger::xeditable", compact('key', 'group', 'result', 'locales', 'translation', 'editUrl'));
    }

    protected function loadLocales()
    {
        //Set the default locale as the first one.
        $locales = array_merge(array(Config::get('app.locale')), Translation::groupBy('locale')->lists('locale'));
        return array_unique($locales);
    }
}
