<?php
class Analysis {
    public $url;
    private $html;
    public function __construct() {
        include_once(__DIR__ . '/simple_html_dom.php');
        $rs = new stdClass();
    }
    private function GetPage($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->site . $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt ($ch, CURLOPT_COOKIEJAR, $this->cookie_file);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_REFERER, $this->site.$url);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_file);
        $result=curl_exec ($ch);
        curl_close ($ch);
        return $result;
    }
    private function UrlInfo(){
        $url =  parse_url($this->url); ;
        $rs['url'] = $this->url;
        $rs['host'] = $url['host'];
        if (strpos($this->url, 'https://') === false){
            $rs['ssl'] = 0;
            $rs['proto'] = 'http://';
        } else {
            $$rs['ssl'] = 1;
            $rs['proto'] = 'https://';
        }
        $rs['info'] = 'Информация об URL и протоколе';
        return $rs;
    }
    private function PlainHtml($thml, $encoding){
        // соотношение Текст/HTML
        $thml = str_replace(array("\r", "\n"), '', $thml);
        $thml = preg_replace("/ +/", " ", $thml);
        $result['length'] = mb_strlen($thml, $encoding);
        $result['length_plain'] = mb_strlen(strip_tags($thml), $encoding);
        $result['ratio']['ratio'] = round(($result['length_plain']/$result['length'])*100);
        if ($result['ratio']['ratio'] > 15){
            $result['ratio']['success'][] = 'Соотношение текста в коде HTML между 15 и 70 процентов';
        } else {
            $resul['ratio']['errors'][] = 'Соотношение текста в коде HTML меньше 15 процентов';
        }
        unset($thml);
        $result['info'] = 'Соотношение Текст/HTML';
        return $result;
    }
    private function RootInfo($html){;
        if ($h = $html->find('html')){
            $result['count'] = count($h);
            if (count($h) > 1){ // Больше одного html
                $result['errors'][] = 'Больше одного тега html';
            } else {
                $result['success'][] = 'Как положено, один корень документа на странице';
            }
            if (isset($h[0]->lang)){ // задан язык страницы
                $result['lang'] = $h[0]->lang;
                $result['success'][] = 'Задан язык страницы (' . $result['lang'] . ')';
            } else { // не задан язык страницы
                $result['errors'][] = 'Не задан язык страницы';
            }

        } else {
            $result['errors'][] = 'Не найден корень документа';;
        }
        unset($h);
        $result['info'] = 'Информация о корне документа (тег html)';
        return $result;
    }

    private function TitleInfo($html, $encoding){
        $h = $html->find('title');
        if (count($h) > 0 && $h[0]->innertext !== ''){
            $result['count'] = count($h);
            if (count($h) > 1){
                $result['errors'][] = 'Найдено больше одного title';
            }
            $result['length'] = mb_strlen($h[0]->innertext, $encoding);
            if ($result['length'] < 10 || $result['length'] > 70){
                $result['warnings'][] = 'Длина заголовка ' . $result['length'] . ' символов';
            } else {
                $result['success'][] = 'Длина заголовка от 10 до 70' . ' символов';
            }
            $result['content'] = $h[0]->innertext;
        } else {
            $result['errors'][] = 'Не найден заголовок страницы';
        }
        unset($h);
        $result['info'] = 'Информация о заголовке страницы (тег title)';
        return $result;
    }
    private function DescriptionInfo($html, $encoding){
        $h = $html->find('meta[name=description]');
        if (count($h) > 0 && $h[0]->content !== ''){
            $result['length'] = mb_strlen($h[0]->content, $encoding);
            if ($result['length'] < 70 || $result['length'] > 160){
                $result['warnings'][] = 'Длина описания ' . $result['length'] . ' символов';
            } else {
                $result['success'][] = 'Длина описания от 70 до 160' . ' символов';
            }
            $result['content'] = $h[0]->content;
        } else {
            $result['errors'][] = 'Не найдено описание страницы';
        }
        unset($h);
        $result['info'] = 'Информация об описании страницы (тег meta-description)';
        return $result;
    }
    public function KeywordsInfo($html, $encoding){
        $h = $html->find('meta[name=keywords]');
        if (count($h) > 0 && $h[0]->content !== ''){
            $result['length'] = mb_strlen($h[0]->content, $encoding);
            if ($result['length'] > 250){
                $result['warnings'][] = 'Общая длина ключевых слов ' . $result['length'] . ' символов';
            } else {
                $result['success'][] = 'Общая длина ключевых слов меньше 250 символов';
            }
            $result['content'] = $h[0]->content;
        } else {
            $result['errors'][] = 'Не найдены ключевые слова';
        }
        unset($h);
        $result['info'] = 'Информация о ключевых словах (тег meta-keywords)';
        return $result;
    }

    public function Run(){
        $rs = new stdClass();
        $rs->url_info = $this->UrlInfo();

        if ($data = $this->GetPage($this->url)){
            $rs->encoding = mb_detect_encoding($data);
            $rs->plain_html = $this->PlainHtml($data, $rs->encoding);
            $html = new simple_html_dom();
            $html = $html->load($data);
            unset($data);
            $rs->root_info = $this->RootInfo($html);
            $rs->title_info = $this->TitleInfo($html, $rs->encoding);
            $rs->description_info = $this->DescriptionInfo($html, $rs->encoding);
            $rs->keywords_info = $this->KeywordsInfo($html, $rs->encoding);

        } else {
            $rs['error'] = 'Не удалось загрузить страницу';
        }
        return $rs;
    }

}
?>