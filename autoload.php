<?php

spl_autoload_register ( function ($class) {
	$libPath = realpath("lib");
	include $libPath . DIRECTORY_SEPARATOR . $class . '.php';
} );
