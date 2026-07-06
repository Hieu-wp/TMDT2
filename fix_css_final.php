<?php
$file = 'd:/App Install/xampp/htdocs/TMDT2/wp-content/themes/animefigure/style.css';
$content = file_get_contents($file);

// 1. Remove all ::after gap fixes I tried
$content = preg_replace('/\/\* Perfect hover bridge \*\/[\s\S]*?background: transparent;\s*\}/', '', $content);
$content = preg_replace('/\/\* Fix dropdown hover gap[\s\S]*?background: transparent;\s*\}/', '', $content);
$content = preg_replace('/\/\* Invisible hover bridge[\s\S]*?z-index: 99;\s*\}/', '', $content);

// 2. Remove the physical gap from the dropdowns so they sit flush!
// This makes them a single solid block with the parent, impossible to lose hover.
$content = str_replace('top: calc(100% + 12px);', 'top: 100%;', $content);

// 3. Move the triangle (mũi nhọn) down slightly so it doesn't poke too far up, 
// or remove it if it looks bad, but let's just make it top: -5px (was -6px).
// Wait, actually the triangle is fine. 

file_put_contents($file, trim($content));
echo "Fixed style.css by removing the gap entirely.\n";
