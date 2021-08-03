<?php

class Func {
    protected static $instance;
    public static function getInstance() {
        return (self::$instance === null) ?
            self::$instance = new self() :
            self::$instance;
    }
    public function __construct() {
        $this->config = Config::getInstance();
    }
    /* Установка сессии */
    public function ss($name, $value){
        $_SESSION[$name] = $value;
        $this->session = $_SESSION;
    }
    /* Установка пост-запроса */
    public function sp($name, $value){
        $_POST[$name] = $value;
    }
    /* Установка гет-запроса */
    public function sg($name, $value){
        $_GET[$name] = $value;
    }

    public function AliasExists($table, $field, $string){
        $sql = "SELECT * FROM $table WHERE $field = '$string' && rel = 1";
        $db = Database::getInstance();
        return $db->select($sql);
    }

    public function GenStr($length = 20){
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    public function getExt($filename) {
        $path_info = pathinfo($filename);
        return $path_info['extension'];
    }
    function pcgbasename($param, $suffix=null) {
        if ( $suffix ) {
            $tmpstr = ltrim(substr($param, strrpos($param, DIRECTORY_SEPARATOR) ), DIRECTORY_SEPARATOR);
            if ( (strpos($param, $suffix)+strlen($suffix) )  ==  strlen($param) ) {
                return str_ireplace( $suffix, '', $tmpstr);
            } else {
                return ltrim(substr($param, strrpos($param, DIRECTORY_SEPARATOR) ), DIRECTORY_SEPARATOR);
            }
        } else {
            return ltrim(substr($param, strrpos($param, DIRECTORY_SEPARATOR) ), DIRECTORY_SEPARATOR);
        }
    }
    public function getBasename($filename) {
        $path_info = pathinfo($filename);
        return $this->pcgbasename($filename,'.'.$path_info['extension']);
    }

    public function getTemplates($path){
        $templates = array();
        if (is_dir($path)){
            $temp = scandir($path);
            if ($temp){
                foreach ($temp as $v){
                    if ($v =='.' || $v == '..') continue;
                    $templates[] = basename($v, '.tpl');
                }
            }
        }
        return $templates;
    }
    public function TranslitURL($str)
    {
        $tr = array(
            "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
            "Д"=>"d","Е"=>"e","Ё"=>"yo","Ж"=>"zh","З"=>"z","И"=>"i",
            "Й"=>"j","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
            "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
            "У"=>"u","Ф"=>"f","Х"=>"x","Ц"=>"c","Ч"=>"ch",
            "Ш"=>"sh","Щ"=>"shh","Ъ"=>"j","Ы"=>"y","Ь"=>"",
            "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"yo","ж"=>"zh",
            "з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"x",
            "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"j",
            "ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
            " "=> "-", "."=> "", "І"=> "i",
            "і"=> "i", "&#1186;"=> "n", "&#1187;"=> "n",
            "&#1198;"=> "u", "&#1199;"=> "u", "&#1178;"=> "q",
            "&#1179;"=> "q", "&#1200;"=> "u",
            "&#1201;"=> "u", "&#1170;"=> "g", "&#1171;"=> "g",
            "&#1256;"=> "o", "&#1257;"=> "o", "&#1240;"=> "a",
            "&#1241;"=> "a"
        );
        // Убираю тире, дефисы внутри строки
        $urlstr = str_replace('–'," ",$str);
        $urlstr = str_replace('-'," ",$urlstr);
        $urlstr = str_replace('—'," ",$urlstr);

        // Убираю лишние пробелы внутри строки
        $urlstr=preg_replace('/\s+/',' ',$urlstr);
        if (preg_match('/[^A-Za-z0-9_\-]/', $urlstr)) {
            $urlstr = strtr($urlstr,$tr);
            $urlstr = preg_replace('/[^A-Za-z0-9_\-]/', '', $urlstr);
            $urlstr = strtolower($urlstr);
            return $urlstr;
        } else {
            return strtolower($str);
        }
    }
    public function CreatePath($path){
        mkdir($path, 0777, true);
    }

    public function getParentCount($list, $id){
        $i=0;
        foreach ($list as $c){
            if ($c["PARENT"]==$id){
                $i++;
            }
        }
        return $i;
    }
    public function getStructure($list, $id=0){
        $structure = array();
        if ($list){
            foreach ($list as $k=>&$c){
                if ($c['PARENT']==$id){
                    $structure[] = $c;
                    if ($this->getParentCount($list, $c['ID'])>0){
                        $structure[count($structure)-1]['SUB'] = $this->getStructure($list,$c['ID']);
                    }
                }
            }
        }
        return $structure;
    }

    public function syntax_filter($text) {
        $search = '/<pre lang=\"([^>]*)\">(.*?)<\/pre>/siu';
        return preg_replace_callback($search, 'self::syntax_filter_callback', $text);
    }

    function syntax_filter_callback($data) {
        $linenumbers = false;
        $urls = false;
        $inline = false;
        $indentsize = 4;

        if (isset($data[2])) {
            $syntax = $data[1];
            $code = $data[2];

            if(strstr($syntax, '*')) {
                $inline = true;
                $syntax=str_replace('*','',$syntax);
            }

            if(strstr($syntax, '#')) {
                $linenumbers = true;
                $syntax=str_replace('#','',$syntax);
            }

            if ($syntax=='html') {
                $syntax = 'html4strict';
            }

            if ($syntax=='js') {
                $syntax = 'javascript';
            }

            $geshi = new GeSHi($code, $syntax);
            $geshi->set_header_type(GESHI_HEADER_DIV);

            $geshi->enable_classes(true);
            $geshi->set_overall_style('font-family: monospace;');
            if($linenumbers) {
                $geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS, 5);
                $geshi->set_line_style('color:#222;', 'color:#888;');
                $geshi->set_overall_style('font-size: 14px;font-family: monospace;', true);
            }
            if (!$urls) {
                for ($i = 0; $i < 5; $i++) {
                    $geshi->set_url_for_keyword_group($i, '');
                }
            }
            if ($indentsize) {
                $geshi->set_tab_width($indentsize);
            }
            $parsed = $geshi->parse_code();
            if($inline) {
                $parsed = preg_replace('/^<div/','<span', $parsed);
                $parsed = preg_replace('/<\/div>$/','', $parsed);
            }
        }
        return $parsed;
    }

    public function DelDir($d) {
        if ($os = glob($d."/*")) {
            foreach($os as $o) {
                is_dir($o) ? $this->DelDir($o) : unlink($o);
            }
        }
        rmdir($d);
    }

    public function DelDirCache($d) {
        if ($os = glob($d."/*")) {
            foreach($os as $o) {
                is_dir($o) ? $this->DelDir($o) : unlink($o);
            }
        }

    }

    function send_mail($mail_to, $thema, $html, $path=''){
        if ($path and file_exists($path)) {
            $fp = fopen($path,"rb");
            $file = fread($fp, filesize($path));
            fclose($fp);
        }
        $name = "ag-landing-panel.zip"; // в этой переменной надо сформировать имя файла (без всякого пути)
        $EOL = "\r\n"; // ограничитель строк, некоторые почтовые сервера требуют \n - подобрать опытным путём
        $boundary     = "--".md5(uniqid(time()));  // любая строка, которой не будет ниже в потоке данных.
        $headers    = "MIME-Version: 1.0;$EOL";
        $headers   .= "Content-Type: multipart/mixed; boundary=\"$boundary\"$EOL";
        $headers   .= "From: address@server.com";

        $multipart  = "--$boundary$EOL";
        $multipart .= "Content-Type: text/html; charset=utf-8$EOL";
        $multipart .= "Content-Transfer-Encoding: base64$EOL";
        $multipart .= $EOL; // раздел между заголовками и телом html-части
        $multipart .= chunk_split(base64_encode($html));

        $multipart .=  "$EOL--$boundary$EOL";
        $multipart .= "Content-Type: application/octet-stream; name=\"$name\"$EOL";
        $multipart .= "Content-Transfer-Encoding: base64$EOL";
        $multipart .= "Content-Disposition: attachment; filename=\"$name\"$EOL";
        $multipart .= $EOL; // раздел между заголовками и телом прикрепленного файла
        $multipart .= chunk_split(base64_encode($file));

        $multipart .= "$EOL--$boundary--$EOL";
        mail($mail_to, $thema, $multipart, $headers);
    }

    public function DateFormat($date){
        return date("d.m.Y G:i:s", $date);
    }

    function GetUniqueName($path, $file_name){
        $file_ext = $this->getExt($file_name);
        $file_basename =$this->getBasename($file_name);
        $file_basename = $this->TranslitURL($file_basename);
        $file = $file_basename.'.'.$file_ext;
        if (file_exists($path.$file)){
            $file = $file_basename.'_'.$this->generateName(5).'.'.$file_ext;
        }
        return $file;
    }
/*    public function UploadFile($file, $upload_dir){
        $result = false;
        if (isset($file)){
            if (!is_dir($upload_dir)){
                $this->CreatePath($upload_dir);
            }
            if (is_uploaded_file($file["tmp_name"])) {
                $image_ext = $this->getExt($file["name"]);
                $image_basename =$this->getBasename($file["name"]);
                $image_basename = $this->TranslitURL($image_basename);
                $image = $image_basename.'.'.$image_ext;
                if (file_exists($upload_dir.$image)){
                    $image = $image_basename.'_'.$this->generateName(5).'.'.$image_ext;
                }
                move_uploaded_file($file["tmp_name"], $upload_dir.$image);
                $result = $image;
            }
        }
        return $result;
    }*/
/*    public function UploadFile($file, $upload_dir){
        $result = false;
        if (isset($file)){
            if (!is_dir($upload_dir)){
                $this->CreatePath($upload_dir);
            }
            if (is_uploaded_file($file["tmp_name"])) {
                $image = $this->GetUniqueName($upload_dir,$file["name"]);
                move_uploaded_file($file["tmp_name"], $upload_dir.$image);
                $result = $image;
            }
        }
        return $result;
    }*/
    public function UploadFile($name,$tmp_name, $upload_dir){
        $result = false;
        if (isset($name)){
            if (!is_dir($upload_dir)){
                $this->CreatePath($upload_dir);
            }
            if (is_uploaded_file($tmp_name)) {
                $image = $this->GetUniqueName($upload_dir,$name);

                if (move_uploaded_file($tmp_name, $upload_dir.$image)){
                    $result = $image;
                }
            }
        }
        return $result;
    }

    public function GetFileList($dir, $result_insert_path = false){
        $result = false;
        if (is_dir($dir)){
            $list = scandir($dir);
            foreach ($list as $v){
                if ($v == '.' || $v == '..') continue;
                $r = $v;
                if ($result_insert_path) {
                    $r = $dir . $r;
                }
                $result[] = $r;
            }
        }
        return $result;
    }

    function detectMaxUploadFileSize() {
        $normalize = function($size) {
            if (preg_match('/^(-?[\d\.]+)(|[KMG])$/i', $size, $match)) {
                $pos = array_search($match[2], array("", "K", "M", "G"));
                $size = $match[1] * pow(1024, $pos);
            } else {
                throw new Exception("Failed to normalize memory size '{$size}' (unknown format)");
            }
            return $size;
        };
        $limits = array();
        $limits[] = $normalize(ini_get('upload_max_filesize'));
        if (($max_post = $normalize(ini_get('post_max_size'))) != 0) {
            $limits[] = $max_post;
        }
        if (($memory_limit = $normalize(ini_get('memory_limit'))) != -1) {
            $limits[] = $memory_limit;
        }
        $maxFileSize = min($limits);
        return $maxFileSize;
    }

    function formatSizeInMb($size, $maxDecimals = 3, $mbSuffix = " MB") {
        $mbSize = round($size / 1024 / 1024, $maxDecimals);
        return preg_replace("/\\.?0+$/", "", $mbSize) . $mbSuffix;
    }

    function format_phone($phone = '', $convert = false, $trim = true)
    {
        // If we have not entered a phone number just return empty
        if (empty($phone)) {
            return '';
        }

        // Strip out any extra characters that we do not need only keep letters and numbers
        $phone = str_replace('+7', '8', $phone);
        $phone = preg_replace("/[^0-9A-Za-z]/", "", $phone);

        // Do we want to convert phone numbers with letters to their number equivalent?
        // Samples are: 1-800-TERMINIX, 1-800-FLOWERS, 1-800-Petmeds
        if ($convert == true) {
            $replace = array('2'=>array('a','b','c'),
                '3'=>array('d','e','f'),
                '4'=>array('g','h','i'),
                '5'=>array('j','k','l'),
                '6'=>array('m','n','o'),
                '7'=>array('p','q','r','s'),
                '8'=>array('t','u','v'), '9'=>array('w','x','y','z'));

            // Replace each letter with a number
            // Notice this is case insensitive with the str_ireplace instead of str_replace
            foreach($replace as $digit=>$letters) {
                $phone = str_ireplace($letters, $digit, $phone);
            }
        }

        // If we have a number longer than 11 digits cut the string down to only 11
        // This is also only ran if we want to limit only to 11 characters
        if ($trim == true && strlen($phone)>11) {
            $phone = substr($phone,  0, 11);
        }

        // Perform phone number formatting here
        if (strlen($phone) == 7) {
            return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1-$2", $phone);
        } elseif (strlen($phone) == 10) {
            return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "($1) $2-$3", $phone);
        } elseif (strlen($phone) == 11) {
            return preg_replace("/([0-9a-zA-Z]{1})([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1($2) $3-$4", $phone);
        }

        // Return original phone if not 7, 10 or 11 digits long
        return $phone;
    }

}
?>
