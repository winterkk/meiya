<?php
namespace backend\models\searches;

use backend\models\BAdmin;
use yii\data\ActiveDataProvider;

class AdminSearch extends BAdmin
{

	/**
	 * 设置规则
	 * 注意，如果没有给字段设置规则，GridView的筛选项是不会出现的
	 */
	public function rules()
	{
		return [
			[['id','username','email','phone'], 'trim'],
			[['username','email','phone'],'string'],
			['id','integer']
		];	
	}

    /**
     * search
     */
    public function search($params)
    {
    	// 首先创建一个ActiveQuery
    	$query = BAdmin::find();
    	// 再创建一个ActiveDataProvider对象
    	$provider = new ActiveDataProvider([
    		// 提供查询对象
    		'query' => $query,
    		// 分页设置
    		'pagination' => [
    			// 分页大小
    			'pageSize' => 5,
    			// 设置地址栏当前页数参数名
    			'pageParam' => 'p',
    			// 设置地址栏分页大小参数名
    			'pageSizeParam' => 'pageSize',
    		],
    		// 排序
    		'sort' => [
    			// 默认
    			'defaultOrder' => [
    				'id' => SORT_DESC,
    			],
    			// 参与排序字段
    			'attributes' => [
    				'id','username'
    			]
    		],
    	]);

    	// 验证失败返回
    	if (!($this->load($params) && $this->validate())) {
    		return $provider;
    	}
    	// 增加过滤条件
    	$query->andFilterWhere(['like','username',$this->username])
    		->andFilterWhere(['like','phone',$this->phone]);


    	return $provider;
    }
}