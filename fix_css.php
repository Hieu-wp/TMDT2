<?php
$file = 'd:/App Install/xampp/htdocs/TMDT2/wp-content/themes/animefigure/style.css';
$content = file_get_contents($file);

// Remove the old bridge CSS I added
$content = preg_replace('/\/\* Fix dropdown hover gap for ALL dropdowns \*\/[\s\S]*?z-index: 10;\s*\}/', '', $content);
$content = preg_replace('/\/\* Fix dropdown hover gap \*\/[\s\S]*?background: transparent;\s*\}/', '', $content);

// Add the NEW correct bridge on the PARENT elements
$new_css = "

/* Invisible hover bridge attached to PARENTS so hover doesn't break */
.navbar-nav .menu-item-has-children::after,
.action-btn::after {
    content: '';
    position: absolute;
    bottom: -20px;
    left: 0;
    width: 100%;
    height: 30px;
    background: transparent;
    z-index: 99;
}
";

file_put_contents($file, trim($content) . $new_css);
echo "Fixed style.css\n";
