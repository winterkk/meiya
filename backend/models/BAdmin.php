<?php
namespace backend\models;
use common\models\Admin;

class BAdmin extends Admin
{
	// 状态
	const USER_DELETE = 0;
	const USER_USEFUL = 1;
	const USER_BLOCK = 2;	//冻结
}