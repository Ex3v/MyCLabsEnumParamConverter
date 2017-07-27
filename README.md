Ex3v\MyCLabsEnumParamConverterBundle
==================


A simple Symfony bundle to enable seamless `MyClabs\Enum` param conversion in your controllers.

[![Build Status](https://travis-ci.org/Ex3v/MyCLabsEnumParamConverter.png?branch=master)](https://travis-ci.org/Ex3v/MyCLabsEnumParamConverter) 
### Installation and usage

##### 1. Install via composer:
```
composer require ex3v/myclabs-enum-param-converter
```

##### 2. Enable bundle:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new \Ex3v\MyCLabsEnumParamConverterBundle\MyCLabsEnumParamConverterBundle(),
    );
}
```

##### 3. Use in your controller:

```php
/**
 * @ParamConverter("barType")
 */
public function fooAction(BarType $barType) : Response
{
	//...	
}

```


**Note that you do not have to point out specific converter as long as you use typehints in your controller actions.**

If you want to point out this converter explicitly, use following example:



```php
/**
 * @ParamConverter("barType", converter="converter_enum")
 */
public function fooAction(BarType $barType) : Response
{
	//...	
}

```

### Happy coding!
