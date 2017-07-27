<?php
/**
 * Author: Maciej Szkamruk
 * Date: 27/07/2017 16:15
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace Ex3v\MyCLabsEnumParamConverterBundle\Tests\ParamConverter;

use MyCLabs\Enum\Enum;

/**
 * @method static DummyEnum VALUE_STRING()
 * @method static DummyEnum VALUE_NUMERIC()
 * @method static DummyEnum VALUE_NULL()
 * @method static DummyEnum VALUE_EMPTY_STRING()
 * @method static DummyEnum VALUE_ARRAY()
 */
class DummyEnum extends Enum
{
	const VALUE_STRING       = 'string';
	const VALUE_NUMERIC      = 123;
	const VALUE_NULL         = null;
	const VALUE_EMPTY_STRING = '';
	const VALUE_ARRAY        = [1, 2, 3];
}