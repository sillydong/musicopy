#!/usr/bin/php
<?php
/**
 * User: chenzhidong
 * Date: 16/9/23
 */

if ($argc != 3) {
    help($argv[0]);
} else {
    $src = $argv[1];
    $dst = $argv[2];
    if (!file_exists($src) || !is_dir($src) || !is_readable($src)) {
        echo $src . " not exist";
    } else if (!file_exists($dst) || !is_dir($dst) || !is_writable($dst)) {
        echo $dst . " not exist";
    } else {
        scan($src, $dst);
    }
    echo "\n";
}

function help($command)
{
    echo $command." sourcedir destdir\n";
}

function scan($basedir, $dst)
{
    $directories = array();
    $base_dirs = scandir($basedir);
    foreach ($base_dirs as $dir) {
        if ($dir[0] == ".") {
            continue;
        } else {
            if (is_dir($basedir . DIRECTORY_SEPARATOR . $dir)) {
                scan($basedir . DIRECTORY_SEPARATOR . $dir, $dst);
            } else {
                $musitian = str_replace(array('/', ' '), array('', '_'), str_replace(dirname(dirname($basedir)), "", dirname($basedir)));
                if (file_exists($dst . $musitian . '_' . $dir) && filesize($basedir . DIRECTORY_SEPARATOR . $dir) == filesize($dst . $musitian . '_' . $dir)) {
                    echo "skip " . $musitian . '_' . $dir . "\n";
                } else {

                    echo "copy " . $musitian . '_' . $dir . "\n";
                    copy($basedir . DIRECTORY_SEPARATOR . $dir, $dst . $musitian . '_' . $dir);
                }
            }
        }
        //end_code
    }
}
