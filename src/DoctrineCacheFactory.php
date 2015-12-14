<?php
namespace DoctrineCacheHarmony;

use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\PhpFileCache;

class DoctrineCacheFactory
{
    /**
     * Builds a ApcCache instance if APCu is installed. Otherwise, builds a PhpFileCache instance.
     * If debug is true, an ArrayCache instance is returned instead.
     *
     * @param bool $debug
     * @param string $namespace
     * @return Cache
     */
    public function build($debug = false, $namespace = "") {
        // If DEBUG mode is on, let's just use an ArrayCache.
        if ($debug) {
            $driver = new ArrayCache();
        } else {
            // If APC is available, let's use APC
            if (extension_loaded("apc")) {
                $driver = new ApcCache();
            } else {
                $driver = new PhpFileCache(sys_get_temp_dir().'/doctrinecache');
            }
        }
        $driver->setNamespace($namespace);
        return $driver;
    }
}
