<?php
namespace backend\models\searches;

use common\models\Art;
use yii\data\ActiveDataProvider;

class ArtSearch extends Art
{
	/**
	 * 设置查询规则
	 *
	 */
	public function rules()
	{
		return [
			[['id','title','art_no','class_id','style_id','cont_id','status'],'trim'],
			[['id','class_id','style_id','cont_id','status'],'integer'],
			[['title','art_no'],'string'],
		];
	}

	/**
	 * search
	 */
	public function search($params)
	{
		$query = Art::find();
		$provider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 5,
				'pageParam' => 'p',
    			'pageSizeParam' => 'pageSize',
			],
			'sort' => [
				'defaultOrder' => [
					'sort' => SORT_DESC
				],
				'attributes' => [
					'id','sort','art_no','title'
				]
			]
		]);
		// 验证失败返回
    	if (!($this->load($params) && $this->validate())) {
    		return $provider;
    	}

    	$query->andFilterWhere(['like','title',$this->title])
    		->andFilterWhere(['id'=>$this->id])
    		->andFilterWhere(['like','art_no',$this->art_no])
    		->andFilterWhere(['class_id'=>$this->class_id])
    		->andFilterWhere(['style_id'=>$this->style_id])
    		->andFilterWhere(['cont_id'=>$this->cont_id])
    		->andFilterWhere(['statues' => $this->status]);

    	return $provider;
	}
}