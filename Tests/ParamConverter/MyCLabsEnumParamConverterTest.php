<?php
/**
 * Author: Maciej Szkamruk
 * Date: 27/07/2017 13:51
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace Ex3v\MyCLabsEnumParamConverterBundle\Tests\ParamConverter;

use Ex3v\MyCLabsEnumParamConverterBundle\ParamConverter\MyCLabsEnumParamConverter;
use MyCLabs\Enum\Enum;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class MyCLabsEnumParamConverterTest extends \PHPUnit_Framework_TestCase
{

	const ATTRIBUTE_NAME = 'enumFromRequest';

	/**
	 * @dataProvider  requestDataProvider
	 */
	public function testConverterWithBasicOptions(DummyEnum $enum, $submittedValue)
	{
		$request = new Request();
		$request->request->set(self::ATTRIBUTE_NAME, $submittedValue);
		$sfParamConverter = new ParamConverter(['name' => '' . self::ATTRIBUTE_NAME . '', 'class' => DummyEnum::class]);

		$enumParamConverter = new MyCLabsEnumParamConverter();

		$enumParamConverter->apply($request, $sfParamConverter);


		self::assertTrue($request->attributes->has(self::ATTRIBUTE_NAME));

		/** @var DummyEnum $convertedParam */
		$convertedParam = $request->attributes->get(self::ATTRIBUTE_NAME);

		self::assertInstanceOf(DummyEnum::class, $convertedParam, 'Converted attribute must be instance of enum');
		self::assertEquals($enum->getValue(), $convertedParam->getValue(), 'Converted attribute must have the same value as submitted one');
	}


	/**
	 * @expectedException \RuntimeException
	 * @expectedExceptionMessageRegExp /^Param \".+\" is required!$/
	 */
	public function testConverterTrowsExceptionIfValueIsRequiredButNotProvided()
	{
		$request = new Request();

		$sfParamConverter = new ParamConverter(['name' => '' . self::ATTRIBUTE_NAME . '', 'class' => DummyEnum::class]);
		$sfParamConverter->setOptions([
			'required' => true,
		]);

		$enumParamConverter = new MyCLabsEnumParamConverter();

		$enumParamConverter->apply($request, $sfParamConverter);
	}

	public function testConverterReturnsDefaultValueIfItIsSet()
	{
		$request = new Request();

		$sfParamConverter = new ParamConverter(['name' => '' . self::ATTRIBUTE_NAME . '', 'class' => DummyEnum::class]);
		$defaultValue     = DummyEnum::VALUE_STRING;

		$sfParamConverter->setOptions([
			'required' => true,
			'default'  => $defaultValue,
		]);

		$enumParamConverter = new MyCLabsEnumParamConverter();

		$enumParamConverter->apply($request, $sfParamConverter);

		self::assertTrue($request->attributes->has(self::ATTRIBUTE_NAME));

		/** @var DummyEnum $convertedParam */
		$convertedParam = $request->attributes->get(self::ATTRIBUTE_NAME);

		self::assertInstanceOf(DummyEnum::class, $convertedParam, 'Converted attribute must be instance of enum');
		self::assertEquals($defaultValue, $convertedParam->getValue(), 'Converted attribute must have the same value as default value');
	}

	public function requestDataProvider()
	{
		$enums = DummyEnum::values();
		$out   = [];

		/** @var Enum $enum */
		foreach ($enums as $enum)
		{
			$out[] = [
				$enum,
				$enum->getValue(),
			];

		}

		return $out;
	}
}