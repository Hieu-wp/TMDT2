<?php
$file = 'd:/App Install/xampp/htdocs/TMDT2/wp-content/themes/animefigure/style.css';
$content = file_get_contents($file);

// Remove the old bridge I just added
$content = preg_replace('/\/\* Invisible hover bridge[\s\S]*?z-index: 99;\s*\}/', '', $content);

// Add a solid, perfect bridge
$new_css = "
/* Perfect hover bridge */
.navbar-nav .sub-menu::after,
.cart-dropdown::after,
.user-dropdown::after {
    content: '';
    position: absolute;
    top: -24px;
    left: -10px;
    right: -10px;
    height: 24px;
    background: transparent;
}
";

file_put_contents($file, trim($content) . "\n" . $new_css);
echo "Fixed style.css\n";
