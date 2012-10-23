@echo off
pushd .
cd %~dp0
cd "../zendframework/zendframework/bin"
set BIN_TARGET=%CD%\classmap_generator.php
popd
php "%BIN_TARGET%" %*
