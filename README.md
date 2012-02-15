# CakeSpec

Maturity : alpha

CakeSpec is a tool to get a CakePHP Project up and running fast using an application 
specification file written in JSON format.

CakeSpec can...

* Pull CakePHP and plugins from git.  
* Configure filesystem permissions
* Create PHP classes
* Set configuration variables
* Create your configuration files
  * databases.php
  * core.php
  * routes.php
* run bake commands
* and much more. 

To use the tool you will need to first create a cakespec file in JSON format.  In this stage of development, the spec files structure may change slightly before reach beta.   You can get a sneak peak of a spec file by looking in the tests/data directory.

Usage:

    cakespec /path/to/specfile.cakespec

Help and more command line options:

    cakespec --help


## Installation


    git clone https://github.com/pronique/cakespec.git /usr/share/cakespec

    ln -s /usr/share/cakespec /usr/bin/cakespec


--------------------------------------------------------------------------
CakeSpec is Open Source Software created and managed by PRONIQUE Software.

http://www.pronique.com

