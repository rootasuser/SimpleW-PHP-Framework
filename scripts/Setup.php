<?php

namespace SimpleW;

class Setup
{
    public static function postInstall($event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $rootDir = dirname($vendorDir);
        
        self::copyDirectory(__DIR__.'/../skeleton', $rootDir);
        
        echo "Project structure created!\n";
    }

    private static function copyDirectory($source, $dest)
    {
        $dir = opendir($source);
        @mkdir($dest);
        
        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..') {
                if (is_dir("$source/$file")) {
                    self::copyDirectory("$source/$file", "$dest/$file");
                } else {
                    copy("$source/$file", "$dest/$file");
                }
            }
        }
        closedir($dir);
    }
}