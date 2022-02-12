<?php


namespace DataQueryInterface\Example\Application\Service;


use DataQueryInterface\Example\Application\Entity\AccessMethodMetadata;
use Exception;
use Psr\Log\LoggerInterface;
use Trackpoint\DataQueryInterface\Metadata\InterfaceMetadata as AccessMethodMetadataInterface;
use Trackpoint\DataQueryInterface\Resolver\MetadataProviderInterface;

class AccessMethodMetadataService implements MetadataProviderInterface
{

	private LoggerInterface $logger;

	public function __construct(
		LoggerInterface $logger
	){
		$this->logger = $logger;
	}

	public function getInterfaceMetadata(string $name): AccessMethodMetadataInterface
	{
		$this->logger->debug("metadata request",[
			'name' => $name
		]);

		$class = sprintf('\\DataQueryInterface\\Example\\Application\\AccessMethod\\%sAccessMethod',
			$name);

		return new AccessMethodMetadata($class);
	}
}