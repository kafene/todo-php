#!/bin/bash

wget http://getcomposer.org/installer -O - | php;
./composer.phar install --dev;
./bin/atoum
