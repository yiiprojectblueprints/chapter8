<?php

// Set the scan directory
$directory = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'modules';
$cachedConfig = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'modules.config.php';

// Attempt to load the cached file if it exists
if (file_exists($cachedConfig))
    return require_once($cachedConfig);
else
{
    // Otherwise generate one, and return it
    $response = array();

    // Find all the modules currently installed, and preload them
    foreach (new IteratorIterator(new DirectoryIterator($directory)) as $filename)
    {
        // Don't import dot files
        if (!$filename->isDot())
        {
            $path = $filename->getPathname();

            if (file_exists($path.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'main.php'))
                $response[$filename->getFilename()] = require($path.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'main.php');
            else
                array_push($response, $filename->getFilename());
        }
    }

    $encoded = serialize($response);
    file_put_contents($cachedConfig, '<?php return unserialize(\''.$encoded.'\');');

    // return the response
    return $response;
}
