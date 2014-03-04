<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 04.03.14
 * Time: 15:44
 */

namespace Netzmacht\FormHelper;


class FormLocator
{
	static protected $formTable = 'tl_form';

	/**
	 * @var Registry
	 */
	protected $registry;

	/**
	 * @var \Database
	 */
	protected $database;


	/**
	 * @param $registry
	 * @param $database
	 */
	function __construct($registry, $database)
	{
		$this->registry = $registry;
		$this->database = $database;
	}

	/**
	 * @param $id
	 * @return \Database\Result|mixed
	 */
	public function getForm($id)
	{
		if($this->registry->has(static::$formTable, $id)) {
			return $this->registry->get(static::$formTable, $id);
		}

		$result = $this->database
			->prepare(sprintf('SELECT * FROM %s WHERE id=?', static::$formTable))
			->execute($id);

		$this->registry->register('tl_form', $result, $id);

		return $result;
	}

} 