<?php
/**
 * Author: hans
 * Date: 27/07/2017 16:22
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace Ex3v\MyCLabsEnumParamConverterBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MyCLabsEnumParamConverterBundle extends Bundle
{

	/** {@inheritdoc} */
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
	}

}