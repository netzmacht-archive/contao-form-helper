<?php

namespace Netzmacht\FormHelper;


class Registry
{

	/**
	 * @var array
	 */
	protected $objects = array();


	/**
	 * @param $table
	 * @param $id
	 * @return bool
	 */
	public function has($table, $id)
	{
		if(!isset($this->objects[$table])) {
			return false;
		}

		return isset($this->objects[$table][$id]);
	}


	/**
	 * @param $table
	 * @param $id
	 * @throws
	 * @return mixed
	 */
	public function get($table, $id)
	{
		if($this->has($table, $id)) {
			return $this->objects[$table][$id];
		}

		throw new \Exception(sprintf('Object of table "%s" with ID "%s" not found in registry', $table, $id));
	}


	/**
	 * @param $table
	 * @param $data
	 * @param $id
	 * @throws
	 * @return $this
	 */
	public function register($table, $data, $id)
	{
		if($this->has($table, $id)) {
			throw new \Exception(sprintf('Object of table "%s" with ID "%s" is already registered in registry', $table, $id));
		}

		$this->objects[$table][$id] = $data;
		return $this;
	}


	/**
	 * @param $table
	 * @param $id
	 * @return $this
	 */
	public function unregister($table, $id)
	{
		unset($this->objects[$table][$id]);

		return $this;
	}

} 