<?php

use DataQueryInterface\Example\Application\Service\AccessMethodBuilderService;
use DataQueryInterface\Example\Application\Service\AccessMethodMetadataService;
use DI\ContainerBuilder;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Trackpoint\DataQueryInterface\DataQueryInterface;
use Trackpoint\DataQueryInterface\Resolver\BuilderInterface;
use Trackpoint\DataQueryInterface\Resolver\InterfaceResolver;
use Trackpoint\DataQueryInterface\Resolver\MetadataProviderInterface;

require_once __DIR__ . '/vendor/autoload.php';

$builder = new ContainerBuilder();

//https://github.com/splitbrain/php-cli


$builder->addDefinitions([
	PDO::class => DI\factory(function (ContainerInterface $c) {
		$dsn = 'sqlite:LegalStructure.db';

		$pdo = new PDO($dsn);

		$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		return $pdo;
	}),

	LoggerInterface::class => DI\factory(function (ContainerInterface $c) {
		$error_log_handler = new ErrorLogHandler();
		$error_log_handler->setFormatter(new LineFormatter('%level_name%: %message% %context% %extra%'));

		$log = new Logger('DataQueryInterface');
		$log->setHandlers([$error_log_handler]);

		return $log;
	}),

	MetadataProviderInterface::class => DI\get(AccessMethodMetadataService::class),
	BuilderInterface::class => DI\get(AccessMethodBuilderService::class)
]);

$container = $builder->build();
$dqi = $container->get(DataQueryInterface::class);

$query = include('select.php');
$iterator = $dqi->execute($query);

$result = [];
foreach($iterator as $tuple){
	$result[] = $tuple;
}

echo json_encode($result);