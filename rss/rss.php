<?php
    date_default_timezone_set("Europe/Oslo");
    class Rss{

        public $url;


        function __construct($url){
            $this -> url = $url;
        }
        function parse(){
            $rss = simplexml_load_file($this->url);
            $parsed = array();
            foreach($rss -> channel -> item as $item){

                $title = $item -> title;

                $link = $item -> link;
                $description = $item -> description;
                $pubdate = $item -> pubDate;
                if($item -> enclosure['type'] == 'image/jpeg'){
                    $image = $item -> enclosure['url'];
                }

                $pubdate = $this -> timeDiff($pubdate);
                $parsed[] = "
                <li class=\"newsItem\">
                    <a href=\"$link\">
                        <section class=\"imageContainer\">
                            <img src=\"$image\" alt=\"news\">
                        </section>
                        <section class=\"newsContent\">
                            <h4>$title</h4>
                            <p class=\"publishDate\">$pubdate</p>
                        </section>
                    </a>
                </li>
                ";
            }
            return $parsed;
        }
        function timeDiff($time){
            $time = array_filter(explode(' ', explode(',', $time)[1]));
            $time = date('d/m/Y', strtotime("$time[1] $time[2] $time[3]")) . " $time[4]";

            $dt1 = new DateTime('now', new DateTimeZone(date_default_timezone_get()));
            $dt2 = new DateTime($time, new DateTimeZone('GMT'));
            $dt2 -> setTimezone(new DateTimeZone(date_default_timezone_get()));
            $diff = $dt2 -> diff($dt1);
            $h = $diff -> format("%h");
            $m = $diff -> format("%i");
            $s = $diff -> format("%s");
            if($h > 0){
                return $dt2 -> format("H:i");
            }
            else if($m < 1){
                return $s;
            }
            else{
                return $m . "m";
            }
        }
        function showFeed($numberOfNews){
            echo '<ul class="newsRss">';
            $parsed = $this -> parse();
            for($i=0; $i < $numberOfNews; $i++){
                echo $parsed[$i];
            }
            echo '</ul>';
        }
    }
 ?>
