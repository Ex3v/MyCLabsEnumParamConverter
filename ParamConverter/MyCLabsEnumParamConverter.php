<?php
/**
 * Author: Maciej Szkamruk
 * Date: 27/07/2017 13:46
 */

//@formatter:off
declare(strict_types=1);
//@formatter:on

namespace Ex3v\MyCLabsEnumParamConverterBundle\ParamConverter;

use MyCLabs\Enum\Enum;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MyCLabsEnumParamConverter implements ParamConverterInterface
{

	const OPTION_REQUIRED  = 'required';
	const OPTION_DEFAULT   = 'default';
	const OPTION_PARAMETER = 'parameter';
	const OPTION_ATTRIBUTE = 'attribute';


	/** {@inheritdoc} */
	public function apply(Request $request, ParamConverter $paramConverter)
	{
		$options   = $paramConverter->getOptions();
		$default   = isset($options[self::OPTION_DEFAULT]) ? $options[self::OPTION_DEFAULT] : null;
		$key       = isset($options[self::OPTION_PARAMETER]) ? $options[self::OPTION_PARAMETER] : $paramConverter->getName();
		$attribute = isset($options[self::OPTION_ATTRIBUTE]) ? $options[self::OPTION_ATTRIBUTE] : $paramConverter->getName();

		if (false === $this->requestHasParam($request, $key) && $this->paramIsRequired($options) && empty($default))
		{
			throw new BadRequestHttpException(sprintf('Param "%s" is required!', $key));
		}

		$value     = $request->get($key, $default);
		$enumClass = $paramConverter->getClass();

		if (
			false === $this->paramIsRequired($options)
			&& false === $this->isValidEnumValue($enumClass, $value)
			&& false === is_array($value)
			&& (string) $value === ''
		)
		{
			return;
		}

		try
		{
			/** @var Enum $enum */
			$value = new $enumClass($value);
		}
		catch (\UnexpectedValueException $e)
		{
			throw new BadRequestHttpException(
				sprintf('Invalid value "%s" for field "%s".', $value, $key)
			);
		}

		$request->attributes->set($attribute, $value);
	}

	/** {@inheritdoc} */
	public function supports(ParamConverter $configuration)
	{
		return is_subclass_of($configuration->getClass(), Enum::class);
	}

	private function requestHasParam(Request $request, string $key): bool
	{
		return $request->query->has($key) || $request->attributes->has($key) || $request->request->has($key);
	}

	private function paramIsRequired(array $options): bool
	{
		return isset($options[self::OPTION_REQUIRED]) && $options[self::OPTION_REQUIRED];
	}

	private function isValidEnumValue(string $enumClass, $value): bool
	{
		return call_user_func_array([$enumClass, 'isValid'], [$value]);
	}
}
