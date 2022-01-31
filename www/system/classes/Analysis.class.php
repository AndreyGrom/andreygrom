<?php
class Analysis {
    public $url;
    private $html;
    public $headers;
    public $data;
    private $rs;
    public function __construct() {
        include_once(__DIR__ . '/simple_html_dom.php');
        $this->rs = new stdClass();
        $this->old_tags = array(
            'applet' => 'Добавляет Java-апплет в документ. Вместо него следует использовать &lt;embed&gt; или &lt;object&gt;',
            'acronym' => 'Этот тег вызывал постоянные вопросы, что такое акроним и чем он отличается от  аббревиатуры. Для упрощения остался единственный тег &lt;abbr&gt;',
            'bgsound' => 'Определяет музыкальный файл, который будет проигрываться на веб-странице при  её открытии. Для воспроизведения музыки используйте новый элемент &lt;audio&gt;',
            'dir' => 'Создает список, содержащий названия директорий, вместо него используйте &lt;ul&gt;',
            'frame' => 'Фреймы более не  поддерживаются. Если они вам требуются, используйте другую версию HTML или &lt;iframe&gt; совместно со стилями',
            'frameset' => 'Фреймы более не  поддерживаются. Если они вам требуются, используйте другую версию HTML или &lt;iframe&gt; совместно со стилями',
            'noframe' => 'Фреймы более не  поддерживаются. Если они вам требуются, используйте другую версию HTML или &lt;iframe&gt; совместно со стилями',
            'isindex' => 'Предназначен для поискового индекса в текущем документе. Комбинация  &lt;form&gt; и &lt;input&gt; лучше справляется с этой задачей',
            'listing' => 'Для вывода листинга программы  предназначены &lt;pre&gt; и &lt;code&gt;',
            'xmp' => 'Для вывода листинга программы  предназначены &lt;pre&gt; и &lt;code&gt;',
            'nextid' => 'Этот тег не предназначен для людей и указывает  идентификатор следующего документа для автоматических редакторов HTML. Полностью исключён',
            'noembed' => 'Предназначен для отображения информации на  веб-странице, если браузер не поддерживает работу с плагинами. В качестве  альтернативы используйте &lt;object&gt;',
            'plaintext' => 'Отображает  содержимое контейнера «как есть», любые теги выводятся как текст. Вместо тега  используйте MIME-тип text/plain',
            'rb' => 'Определяет базовый текст внутри &lt;ruby&gt;. Этот тег полностью исключён',
            'strike' => 'Для зачёркнутого текста применяется &lt;s&gt;, а для указания редакторской  правки &lt;del&gt;',
            'basefont' => 'Вместо этого тега применяются стили',
            'big' => 'Вместо этого тега применяются стили',
            'blink' => 'Вместо этого тега применяются стили',
            'center' => 'Вместо этого тега применяются стили',
            'font' => 'Вместо этого тега применяются стили',
            'marquee' => 'Вместо этого тега применяются стили',
            'multicol' => 'Вместо этого тега применяются стили',
            'nobr' => 'Вместо этого тега применяются стили',
            'spacer' => 'Вместо этого тега применяются стили',
            'tt' => 'Вместо этого тега применяются стили',
            'u' => 'Вместо этого тега применяются стили',
        );
    }
    private function HeadersToArray(){
        $this->headers = explode('\r\n', $this->headers);
    }
    private function GetFullLink($link){
        if (strpos($link, 'http') === false){
            $link = $this->rs->proto . $this->rs->host . $link;
        }
        return $link;
    }
    function GetOldTags(){
        $result = array();
        foreach ($this->old_tags as $k => $t){
            $result[] = $k;
        }
        return $result;
    }
    public function GetPage($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)');
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        //$f = fopen('errors.txt', 'a+');
        //curl_setopt($ch, CURLOPT_STDERR, $f);
        curl_setopt($ch, CURLOPT_TIMEOUT,30); // times out after 4s
        $result=curl_exec ($ch);

        if ($result !== false)
        {
            $ch_info = curl_getinfo($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $this->headers = trim(substr($result, 0, $ch_info['header_size']));
            $this->data = substr($result, $ch_info['header_size']);
            $this->data = iconv(mb_detect_encoding($this->data), "UTF-8//TRANSLIT//IGNORE", $this->data);
            $rs = true;
        } else {
            $rs = false;
        }
        curl_close ($ch);
        return $rs;
    }
    private function UrlInfo(){
        $url =  parse_url($this->url); ;
        $this->rs->url = $this->url; // URL
        $this->rs->host = $url['host']; // Host
        if (strpos($this->url, 'https://') === false){
            $this->rs->ssl = 0;
            $this->rs->proto = 'http://';
        } else {
            $this->rs->ssl = 1;
            $this->rs->proto = 'https://';
        };
    }
    private function PlainHtml($data, $encoding){
        $data = str_replace(array("\r", "\n"), '', $data);
        $data = preg_replace("/ +/", " ", $data);
        $this->rs->length_html = mb_strlen($data, $encoding); // Кол-во символов вместе с тегами
        $this->rs->length_plain = mb_strlen($this->html->plaintext, $encoding); // Кол-во без тегов
        // соотношение Текст/HTML. Если меньше 15,  то плохо
        $this->rs->ratio = round(($this->rs->length_plain/$this->rs->length_html)*100);
    }
    private function RootInfo($html){;
        $h = $html->find('html');
        $this->rs->count = count($h); // Кол-во корневых тегов html на странице
        foreach ($h as $i){
            $this->rs->lang[] = $i->lang; // Язык страницы
        }
        unset($h);;
    }

    private function TitleInfo($html, $encoding){
        $h = $html->find('title');
        if (count($h) > 0){
            foreach ($h as $i){
                $title = array(
                    'content' => $i->innertext,
                    'length' => mb_strlen($i->innertext, $encoding),
                );
                $this->rs->title[] = $title; // title страницы
            }
        }
        // Длина title должна быть от 10 до 70 символов
        unset($h);
    }
    private function DescriptionInfo($html, $encoding){
        $h = $html->find('meta[name=description]');
        if (count($h) > 0){
            foreach ($h as $i){
                $desc = array(
                    'content' => $i->content,
                    'length' => mb_strlen($i->content, $encoding),
                );
                $this->rs->meta_description[] = $desc; // meta_description страницы
            }
        }
        // Длина meta_description должна быть от 70 до 160 символов
        unset($h);
    }
    private function KeywordsInfo($html, $encoding){
        $h = $html->find('meta[name=keywords]');
        if (count($h) > 0){
            foreach ($h as $i){
                $keywords = array(
                    'content' => $i->content,
                    'length' => mb_strlen($i->content, $encoding),
                );
                $this->rs->meta_keywords[] = $keywords; // meta_keywords страницы
            }
        }
        // Длина meta_keywords должна быть меньше 250 символов
        unset($h);
    }
    private function MetaOpenGraph($html){
        $h = $html->find('meta[property]');
        if (count($h) > 0){
            foreach ($h as $i){
                // Разметка Open Graph
                if (strpos($i->property,'og:') !== false){
                    $this->rs->meta_og[] = array(
                        'property' => $i->property,
                        'content' =>  $i->content,
                    );
                }
            }
        }
        unset($h);
    }
    private function MetaTwitter($html){
        $h = $html->find('meta[name]');
        if (count($h) > 0){
            foreach ($h as $i){
                // Разметка Twitter
                if (strpos($i->name,'twitter:') !== false){
                    $this->rs->meta_twitter[] = array(
                        'name' => $i->name,
                        'content' =>  $i->content,
                    );
                }
            }
        }
        unset($h);
    }
    private function CaptionTags($html){
        $tags = array();
        $tags_null = array();
        $h = $html->find('h1, h2, h3, h4, h5, h6');
        if (count($h) > 0){
            foreach ($h as $i){
                if (trim(strip_tags($i->innertext)) !== ''){
                    $tags[$i->tag][] = trim(strip_tags($i->innertext));
                } else {
                    $tags_null[$i->tag] = '';
                }
            }
            $this->rs->caption_tags['tags'] = $tags;
            $this->rs->caption_tags['tags_null'] = $tags_null;
        };
        unset($h);
    }
    function array_unique_key($array, $key) {
        $tmp = $key_array = array();
        $i = 0;
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $tmp[$i] = $val;
            }
            $i++;
        }
        $tmp = array_values($tmp);
        return $tmp;
    }
    private function Images($html){
        $h = $html->find('img');
        if (count($h) > 0){
            foreach ($h as $i){
                $this->rs->images[] = array(
                    'alt' => $i->alt,
                    'src' =>  $this->GetFullLink($i->src),
                    'title' =>  $i->title,
                );
            }
        }
        unset($h);
        if(isset($this->rs->images)){
            $this->rs->images = $this->array_unique_key($this->rs->images, 'src');
        }
    }
    private function Flash($html){
        $h = $html->find('object, embed');
        if (count($h) > 0){
            foreach ($h as $i){
                if ($i->src == '') continue;
                $this->rs->flash[] = array(
                    'alt' => $i->alt,
                    'src' =>  $this->GetFullLink($i->src),
                    'title' =>  $i->title,
                );
            }
        }
        unset($h);
    }
    private function Iframe($html){
        $h = $html->find('iframe');
        if (count($h) > 0){
            foreach ($h as $i){
                if ($i->src == '') continue;
                $this->rs->iframe[] = array(
                    'src' =>  $this->GetFullLink($i->src),
                );
            }
        }
        unset($h);
    }
    private function Links($html){
        $h = $html->find('a');
        if (count($h) > 0){
            foreach ($h as $i){
                if (isset($i->href) && $i->href !== ''){
                    $link = parse_url($i->href);
                    $l = array(
                        'text' => trim(strip_tags($i->innertext)),
                        'href' => $this->GetFullLink($i->href),
                    );
                    if (isset($link['host']) && $link['host'] !== $this->rs->host){
                        $l['type'] = 'out';
                    } else {
                        $l['type'] = 'current';
                    }
                    if (isset($i->rel) && $i->rel == 'nofollow'){
                        $l['nofollow'] = true;
                    } else {
                        $l['nofollow'] = false;
                    }
                    $this->rs->links[] = $l;
                }
            }
        }
    }
    private function Favicon($html){
        $h = $html->find('link[rel="icon"]');
        if (count($h) > 0){
            $this->rs->favicon = $h[0]->href;
            $this->rs->favicon = $this->GetFullLink($this->rs->favicon);
        }
        unset($h);
    }
    private function Charset($html){
        $h = $html->find('meta[charset], META[charset]');
        if (count($h) > 0){
            $this->rs->charset = $h[0]->charset;
        } else{
            if ($h = $html->find('meta[http-equiv=Content-Type]',0)){
                $fullvalue = $h->content;
                preg_match('/charset=(.+)/', $fullvalue, $matches);
                if (count($matches) > 1){
                    $this->rs->charset = $matches[1];
                }
            }

        }
        unset($h);
    }
    private function Robots(){
        if ($this->rs->is_robots = $this->GetPage($this->rs->proto . $this->rs->host . '/robots.txt')){
            $this->rs->robots = $this->data;
        }
    }
    private function OldTags($html){
        $h = $html->find(implode(',', $this->GetOldTags()));
        if (count($h) > 0){
            foreach ($h as $i){
                $this->rs->old_tags[] = array(
                    'tag' =>  $i->tag,
                    'info' =>  $this->old_tags[$i->tag],
                );
            }
        }
        unset($h);
    }
    public function Run(){
        $this->UrlInfo();
        if ($this->data == ''){
            $this->GetPage($this->url);
        }
        if ($this->data !== ''){
            $html = new simple_html_dom();
            $this->html = $html->load($this->data);
            $this->rs->encoding = mb_detect_encoding($this->data);
            $this->rs->headers = $this->headers;
            $this->PlainHtml($this->data, $this->rs->encoding);


            //unset($data);
            $this->RootInfo($this->html);
            $this->TitleInfo($this->html, $this->rs->encoding);
            $this->DescriptionInfo($this->html, $this->rs->encoding);
            $this->KeywordsInfo($this->html, $this->rs->encoding);
            $this->MetaOpenGraph($this->html);
            $this->MetaTwitter($this->html);
            $this->CaptionTags($this->html);
            $this->Images($this->html);
            $this->Flash($this->html);
            $this->Iframe($this->html);
            $this->Links($this->html);
            $this->Favicon($this->html);
            $this->Charset($this->html);
            $this->OldTags($this->html);
            //$this->Robots();
            unset($this->html);
        } else {
            $this->rs->error = 'Не удалось загрузить страницу';
        }
        return $this->rs;
    }

}
?>