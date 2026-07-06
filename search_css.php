<?php
$lines = file('d:/App Install/xampp/htdocs/TMDT2/wp-content/themes/animefigure/style.css');
foreach($lines as $i => $line) {
    if(stripos($line, 'navbar-nav') !== false || stripos($line, 'sub-menu') !== false) {
        echo ($i+1) . ': ' . trim($line) . "\n";
    }
}
