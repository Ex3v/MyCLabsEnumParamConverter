<?php
/**
 * Author: Maciej Szkamruk
 * Date: 27/07/2017 16:24
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace Ex3v\MyCLabsEnumParamConverterBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MyCLabsEnumParamConverterExtension extends Extension
{
	/** {@inheritdoc} */
	public function load(array $configs, ContainerBuilder $container)
	{
		$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
		$loader->load('services.yml');
	}

}
