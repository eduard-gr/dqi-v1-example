<?php


namespace DataQueryInterface\Example\Application\Service;


use Exception;
use DI\Container;
use Psr\Log\LoggerInterface;
use Trackpoint\DataQueryInterface\Resolver\BuilderInterface;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;

class AccessMethodBuilderService implements BuilderInterface
{

	private LoggerInterface $logger;
	private Container $container;

	public function __construct(
		LoggerInterface $logger,
		Container $container
	){
		$this->logger = $logger;
		$this->container = $container;
	}

	public function newInterfaceInstance(
		StatementInterface $statement
	){

		$this->logger->debug("interface request",[
			'name' => $statement->getName()
		]);

		$class = sprintf('\\DataQueryInterface\\Example\\Application\\AccessMethod\\%sAccessMethod',
			$statement->getName());

		if(class_exists($class) == false){
			throw new Exception(sprintf('Undefined interface %s',
				$class));
		}

		return $this->container->make($class,[
			'statement' => $statement
		]);
	}
}