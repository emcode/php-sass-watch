PHP Sass Watch
====================

This is just simple PHP cli script that finds recursively directories that contains folders "sass" and "css", and then runs "sass --watch found-sass-dirs:found-css-dirs" command on them. It can be usefull if you have project that have styles scattered in few different directories and if you are tired to run sass --watch on each of them every time.

Run it
---------------------

1. Download sass-watch.php script
2. Place it somewhere in your project (for. ex. inside "scripts" or "bin" folder) 
2. Give it "execution" permission using command:
``` bash
sudo chmod +x ./bin/sass-watch.php
```
3. Run it: 
``` bash
./bin/sass-watch.php
```

Dependencies
---------------------

To run this you need to have "sass" command available inside your terminal (ruby-sass package) and php5-cli installed.


License
---------------------

Please, do whatever you want with it.