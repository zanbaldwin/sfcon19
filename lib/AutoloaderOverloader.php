<?php declare(strict_types=1);

namespace ZanBaldwin\DPC19\Obfuscation;

use Composer\Autoload\ClassLoader as ComposerClassLoader;

class AutoloaderOverloader
{
    /** @var \Composer\Autoload\ClassLoader $composer */
    private $composer;
    /** @var string $filterName */
    private $filterName;

    public function __construct(ComposerClassLoader $composer, string $filterName)
    {
        $this->composer = $composer;
        $this->filterName = $filterName;
    }

    public function loadClass(string $class): ?bool
    {
        $file = $this->composer->findFile($class);
        $includeUri = sprintf('php://filter/read=%s/resource=file://%s', $this->filterName, $file);
        \Composer\Autoload\includeFile($includeUri);
        return true;
    }

    public static function init(string $filterName): void
    {
        $loaders = spl_autoload_functions();
        foreach ($loaders as &$loader) {
            // Unregister each loader, so they can be re-registered in the same order.
            spl_autoload_unregister($loader);
            if (is_array($loader) && $loader[0] instanceof ComposerClassLoader) {
                // Replace Composer autoloader with our  hijacking autoloader.
                $loader[0] = new self($loader[0], $filterName);
            }
        }
        unset($loader);
        // Processed all the loaders, re-register them with PHP in their original order.
        foreach ($loaders as $loader) {
            spl_autoload_register($loader);
        }

    }
}
