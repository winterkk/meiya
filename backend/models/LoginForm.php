<?php
namespace backend\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
	public $username;
	public $password;
	public $category;

	public function rules()
	{
		return [

		];
	}
}