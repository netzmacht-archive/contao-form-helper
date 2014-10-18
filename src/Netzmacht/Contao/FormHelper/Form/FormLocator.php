<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 04.03.14
 * Time: 15:44
 */

namespace Netzmacht\Contao\FormHelper\Form;


class FormLocator
{

	/**
	 * @param $id
	 * @return \Database\Result|mixed
	 */
	public function getForm($id)
	{
        return \FormModel::findByPk($id);
	}

}