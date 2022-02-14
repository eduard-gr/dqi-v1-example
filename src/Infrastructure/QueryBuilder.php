<?php


namespace DataQueryInterface\Example\Infrastructure;


use Exception;
use sad_spirit\pg_builder\nodes\ColumnReference;
use sad_spirit\pg_builder\nodes\expressions\NamedParameter;
use sad_spirit\pg_builder\nodes\expressions\OperatorExpression;
use sad_spirit\pg_builder\nodes\expressions\RowExpression;
use sad_spirit\pg_builder\nodes\Identifier;
use sad_spirit\pg_builder\nodes\lists\GenericNodeList;
use sad_spirit\pg_builder\nodes\lists\RowList;
use sad_spirit\pg_builder\nodes\lists\SetClauseList;
use sad_spirit\pg_builder\nodes\lists\TargetList;
use sad_spirit\pg_builder\nodes\Parameter;
use sad_spirit\pg_builder\nodes\QualifiedName;
use sad_spirit\pg_builder\nodes\range\InsertTarget;
use sad_spirit\pg_builder\nodes\range\RelationReference;
use sad_spirit\pg_builder\nodes\range\UpdateOrDeleteTarget;
use sad_spirit\pg_builder\nodes\SetTargetElement;
use sad_spirit\pg_builder\nodes\SingleSetClause;
use sad_spirit\pg_builder\nodes\TargetElement;
use sad_spirit\pg_builder\Statement;
use sad_spirit\pg_builder\StatementFactory;
use sad_spirit\pg_builder\Update;
use sad_spirit\pg_builder\Values;
use Trackpoint\DataQueryInterface\Expression\Condition;
use Trackpoint\DataQueryInterface\Expression\EqualExpression;
use Trackpoint\DataQueryInterface\Expression\Expression;
use Trackpoint\DataQueryInterface\Expression\GreaterEqualExpression;
use Trackpoint\DataQueryInterface\Expression\GreaterExpression;
use Trackpoint\DataQueryInterface\Expression\LessEqualExpression;
use Trackpoint\DataQueryInterface\Expression\LessExpression;

abstract class QueryBuilder
{

	private StatementFactory $statement_factory;

	/**
	 * QueryBuilder constructor.
	 * @param StatementFactory $statement_factory
	 */
	public function __construct(StatementFactory $statement_factory)
	{
		$this->statement_factory = $statement_factory;
	}

	/**
	 * @return StatementFactory
	 */
	public function getStatementFactory(): StatementFactory
	{
		return $this->statement_factory;
	}

	protected abstract function getEntityName(): string;

	/**
	 * @throws Exception
	 */
	protected function _select(
		array $columns,
		Condition $condition
	): Statement
	{

		$target_list = new TargetList();
		foreach($columns as $column){
			$target_list[] = new TargetElement(new ColumnReference(new Identifier($column)), null);
		}

		$statement = $this->statement_factory->select($target_list, null);
		$statement->from[] = new RelationReference(new QualifiedName(new Identifier($this->getEntityName())));

		$this->condition(
			$statement,
			$condition);

		return $statement;
	}

	protected function _insert(
		array $columns,
		array $values
	): Statement
	{

		$relation = new InsertTarget(new QualifiedName(new Identifier($this->getEntityName())));

		$statement = $this->statement_factory->insert($relation);

		foreach($columns as $column){
			$statement->returning[] = new TargetElement(new ColumnReference(new Identifier($column)), null);
		}

		$named_parameters = [];
		foreach($values as $name => $value){
			$statement->cols[] = new SetTargetElement(new Identifier($name));
			$named_parameters[] = new NamedParameter($name);
		}

		$statement->setValues(new Values(new RowList([new RowExpression($named_parameters)])));

		return $statement;
	}

	protected function _update(
		array $columns,
		array $values,
		Condition $condition
	): Statement
	{
		$relation = new UpdateOrDeleteTarget(new QualifiedName(new Identifier($this->getEntityName())));

		$set_list = new SetClauseList();
		foreach($values as $name => $value){
			$set_list[] = new SingleSetClause(
				new SetTargetElement(new Identifier($name)),
				new NamedParameter($name));
		}

		$statement = new Update($relation, $set_list);
		$statement->setParser($this->statement_factory->getParser());

		foreach($columns as $column){
			$statement->returning[] = new TargetElement(new ColumnReference(new Identifier($column)), null);
		}

		$this->condition(
			$statement,
			$condition);

		return $statement;
	}


	/**
	 * @throws Exception
	 */
	protected function condition(
		Statement $statement,
		Condition $condition
	){

		if($condition instanceof Condition){
			foreach($condition as $expression){
				$this->where(
					$statement,
					$expression);
			}
		}else if($condition instanceof Expression){
			$this->where(
				$statement,
				$condition);
		}
	}


	/**
	 * @throws Exception
	 */
	private function where(
		Statement $statement,
		Expression $expression
	){

		if($expression instanceof EqualExpression) $operator = '=';
		else if($expression instanceof GreaterEqualExpression) $operator = '>=';
		else if($expression instanceof GreaterExpression) $operator = '>';
		else if($expression instanceof LessEqualExpression) $operator = '<=';
		else if($expression instanceof LessExpression) $operator = '<';
		else throw new Exception('unknown expression');

		$condition = new OperatorExpression(
			$operator,
			new ColumnReference(new Identifier($expression->getName())),
			new NamedParameter($expression->getName()));

		if($expression->isDisjunction()){
			$condition = new OperatorExpression(
				'not',
				null,
				$condition);
		}

		$statement->where->and($condition);
	}

}