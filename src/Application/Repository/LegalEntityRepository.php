<?php


namespace DataQueryInterface\Example\Application\Repository;


use DataQueryInterface\Example\Infrastructure\QueryBuilder;
use Generator;
use PDO;
use Psr\Log\LoggerInterface;
use sad_spirit\pg_builder\StatementFactory;
use Trackpoint\DataQueryInterface\Expression\Condition;

class LegalEntityRepository extends QueryBuilder
{

	const ENTITY_NAME = 'legal_entity';

	private LoggerInterface $logger;
	private PDO $pdo;


	/**
	 * LegalPersonRepository constructor.
	 * @param LoggerInterface $logger
	 * @param PDO $pdo
	 * @param StatementFactory $statement_factory
	 */
	public function __construct(
		LoggerInterface $logger,
		PDO $pdo,
		StatementFactory $statement_factory
	){

		parent::__construct($statement_factory);

		$this->logger = $logger;
		$this->pdo = $pdo;
	}


	protected function getEntityName(): string
	{
		return self::ENTITY_NAME;
	}


	/**
	 * @param array $columns
	 * @param Condition $condition
	 * @return void
	 * @throws \Exception
	 */
	public function select(
		array $columns,
		Condition $condition
	): Generator
	{
		$statement = parent::_select(
			$columns,
			$condition);

		$sql = $this->getStatementFactory()->createFromAST($statement)->getSql();
		$parameters = $condition->getExpressionConstantValue();

		$this->logger->debug('select',[
			'sql' => $sql,
			'parameters' => $parameters
		]);

		$ps = $this->pdo->prepare($sql);
		$ps->setFetchMode(PDO::FETCH_ASSOC);
		$ps->execute($parameters);

		while($tuple = $ps->fetch()){
			yield $tuple;
		}

	}

	public function insert(
		array $columns,
		array $values
	): Generator
	{
		$statement = parent::_insert(
			[], //$columns
			$values);

		$sql = $this->getStatementFactory()->createFromAST($statement)->getSql();

		$this->logger->debug('insert',[
			'sql' => $sql,
			'values' => $values
		]);

		$ps = $this->pdo->prepare($sql);
		$ps->setFetchMode(PDO::FETCH_ASSOC);
		$ps->execute($values);

		//Dirty hack. returning supports only in SQLite > 3.35
		yield array_intersect_key($values, array_flip($columns));
	}

	public function update(
		array $columns,
		array $values,
		Condition $condition
	): Generator
	{
		$statement = parent::_update(
			[], //$columns
			$values,
			$condition);

		$sql = $this->getStatementFactory()->createFromAST($statement)->getSql();
		$parameters = $condition->getExpressionConstantValue();

		$this->logger->debug('select',[
			'sql' => $sql,
			'parameters' => $parameters
		]);

		$ps = $this->pdo->prepare($sql);
		$ps->setFetchMode(PDO::FETCH_ASSOC);
		$ps->execute(array_merge(
			$values,
			$parameters));

		//Dirty hack. returning supports only in SQLite > 3.35
		$returning = array_merge(
			$condition->getExpressionConstantValue(),
			$values);

		yield array_intersect_key($returning, array_flip($columns));
	}
}