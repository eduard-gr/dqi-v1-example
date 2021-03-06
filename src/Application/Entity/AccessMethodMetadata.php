<?php


namespace DataQueryInterface\Example\Application\Entity;

use Ds\Map;
use Exception;
use ReflectionClass;
use Trackpoint\DataQueryInterface\Metadata\AttributeMetadata;
use Trackpoint\DataQueryInterface\Metadata\InterfaceMetadata as AccessMethodMetadataInterface;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;

class AccessMethodMetadata implements AccessMethodMetadataInterface
{

	private Map $attributes;

	/**
	 * AccessMethodMetadata constructor.
	 * @throws \ReflectionException
	 */
	public function __construct($class)
	{
		$this->attributes = new Map();

		if(class_exists($class) == false){
			throw new Exception(sprintf('Undefined interface %s',
				$class));
		}

		$reflection = new ReflectionClass($class);
		if(in_array(StatementInterface::class, $reflection->getInterfaceNames()) == false){
			throw new Exception(sprintf('The interface %s is not available for requests',
				$reflection->getShortName()
			));
		}

		$metadata = $reflection->getConstant('METADATA');
		if($metadata === false){
			throw new Exception(sprintf('Error reading metadata for interface %s',
				$reflection->getShortName()
			));
		}

		foreach ($metadata as $name => $property){
			$this->attributes->put($name, new AttributeMetadata($name, $property));
		}

	}

	public function getAttribute($name): AttributeMetadata{
		return $this->attributes->get($name);
	}

	public function getAttributes(): Map{
		return $this->attributes;
	}
}