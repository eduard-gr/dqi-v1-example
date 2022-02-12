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
use Trackpoint\DataQueryInterface\DQL;
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

/**
 * @var PDO $pdo
 */
$pdo = $container->get(PDO::class);

/**
 * @var DataQueryInterface $dqi
 */
$dqi = $container->get(DataQueryInterface::class);

$query = include('select.php');

if($query[DQL::STATEMENT] != DQL::SELECT){
	$pdo->beginTransaction();
}

try{
	$iterator = $dqi->execute($query);

	$result = [];
	foreach($iterator as $tuple){
		$result[] = $tuple;
	}

	if($pdo->inTransaction()){
		$pdo->commit();
	}

	echo json_encode($result);

}catch(Exception $exception){
	if($pdo->inTransaction()){
		$pdo->rollBack();
	}
}



