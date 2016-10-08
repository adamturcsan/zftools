# zftools

[![Build Status](https://travis-ci.org/adamturcsan/zftools.svg?branch=master)](https://travis-ci.org/adamturcsan/zftools)
[![Coverage Status](https://coveralls.io/repos/github/adamturcsan/zftools/badge.svg?branch=develop)](https://coveralls.io/github/adamturcsan/zftools?branch=develop)

Tools for helping Zend Framework app development processes

## Currently available commands

### 1. create-module [name]

Creates a new MVC module with a sample IndexController. The module is added to composer autoload config.
module.config.php is generated with matched ControllelFactory class.

### 2. create-controller [module] [name]

Create a new MVC controller to a specified module. A controllerFactory is generated also, configured in the module.config.php.