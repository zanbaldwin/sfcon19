# Obfuscation Demo

This is a demo application using concepts covered in [my talk for Dutch PHP Conference 2019][talk]: [autoloader
overloading](lib/AutoloaderOverloader.php), [source transformation, and XOR encryption](lib/ObfuscatingTransformFilter.php).

Code in [`src/Controller.php`](src/Controller.php) is obfuscated.
To view the unencrypted source code run:
 
```bash
$ bin/obfuscate --undo src/Controller.php
```

[talk]: https://joind.in/event/dutch-php-conference-2019/crazy-fun-experiments-with-php-not-for-production "Crazy Fun Experiments with PHP (Not For Production)"
