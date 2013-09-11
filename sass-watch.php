#!/usr/bin/env php
<?php

define('DS', DIRECTORY_SEPARATOR);

// paths that have matching fragments with this array
// will be ommited from watching - feel free to change it
$pathBlacklist = array();

$currentPath = realpath('.');
$pathsWithSass = array();
$directoryIterator = new \RecursiveDirectoryIterator($currentPath);
$pathsIterator = new \RecursiveIteratorIterator($directoryIterator, \RecursiveIteratorIterator::SELF_FIRST);

// get all paths that have sass folder inside
foreach($pathsIterator as $name => $object)
{
    /* @var $object SplFileInfo  */    
    if ($object->isDir() && $object->getBasename() == 'sass')
    {       
       $pathsWithSass[] = $object->getPath();
    }
}

$pathsWithSassAndCss = array();

// check if discovered paths with sass have also "css" folder
// as we will watch only for those that have it already
foreach($pathsWithSass as $currentPath)
{
   if (is_dir($currentPath . DS . 'css'))
   {
       $pathsWithSassAndCss[] = $currentPath;
   }
}

$filteredPaths = array();

if (empty($pathBlacklist))
{
    $filteredPaths = & $pathsWithSassAndCss;

} else
{
    // filter out paths that are on blacklist
    foreach($pathsWithSassAndCss as $currentTargetPath)
    {
        $fragmentMatched = false;

        foreach($pathBlacklist as $blacklistedFragment)
        {
            $fragmentMatched = strpos($currentTargetPath, $blacklistedFragment, 0) !== false;

            if ($fragmentMatched)
            {
                echo sprintf('Matched blacklist fragment: "%s", excluded path: %s', $blacklistedFragment, $currentTargetPath) . PHP_EOL;
                continue;
            }
        }

        if (!$fragmentMatched)
        {
            $filteredPaths[] = $currentTargetPath;
        }
    }
}

// print nice message for the user
$sassWatchParams = array();
echo 'Watching for styles in:' . PHP_EOL;
foreach($filteredPaths as $index => $currentTargetPath)
{
    echo $index . '. ' . $currentTargetPath . PHP_EOL;
    $sassWatchParams[] = sprintf('%s' . DS . 'sass:%s' . DS . 'css', $currentTargetPath, $currentTargetPath);
}

// force initial recompiling
$command = sprintf('sass --line-numbers --line-comments --force --update %s',  implode(' ', $sassWatchParams));
system($command);
// run it in watching mode
$command = sprintf('sass --line-numbers --line-comments --watch %s',  implode(' ', $sassWatchParams));
system($command);
