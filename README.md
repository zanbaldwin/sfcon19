Original Presentation:<br>https://docs.google.com/presentation/d/1cTDYd4tNHH37MKbNEm1jqdMW-NcqaVU2MLIsUWtCs7k/edit?usp=sharing

# Obfuscation Demo

This is a demo application using concepts covered in [my talk for SymfonyCon Amsterdam 2019][talk]: [autoloader
overloading](lib/AutoloaderOverloader.php), [source transformation, and XOR encryption](lib/ObfuscatingTransformFilter.php).

Code in [`src/Controller.php`](src/Controller.php) is obfuscated.
To view the unencrypted source code run:
 
```bash
$ bin/obfuscate --undo src/Controller.php
```

[talk]: https://amsterdam2019.symfony.com/speakers#session-2866 "Crazy Fun Experiments with PHP (Not For Production)"
