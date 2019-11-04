<?php
namespace backend\models;
use common\models\Menu;
use common\services\CommonService;

class BMenu extends Menu
{
	/**
	 * menu data
	 */
	public function getMenuSource()
	{
		return static::find()->asArray()->all();
	}

	/**
	 * menu tree
	 */
	public static function getMenuTree($userId)
	{
		$list = self::getMenuSource();
		if (!empty($list)) {
			$treeHead = [
				['label' => 'Meiya Erp', 'options' => ['class' => 'header']],
			];
			$tree = self::makeMenuTree($list);
			array_unshift($tree, $treeHead);
			return $tree;
		} else {
			return [];
		}
	}

	/**
	 * 生成menu
	 */
	public function makeMenuTree($list, $pk='id', $pid = 'parent', $child='items',$level=0)
	{
		$tree = [];
		foreach ($list as $key => $value) {
			if ($value[$pid] == $level) {
				// $tree[$value[$pk]] = $value;
				// 顶层
				$t['label'] = $value['name'];
				$t['icon'] = 'file-code-o';
				$t['url'] = $value['route'];
				$tree[$value[$pk]] = $t;
				unset($list[$key]);
				$tree[$value[$pk]][$child] = self::makeMenuTree($list,$pk,$pid,$child,$value[$pk]);
			}
		}
		return $tree;
	}
}