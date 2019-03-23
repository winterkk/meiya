<?php
namespace backend\ArtService;

use common\services\CommonService;
use common\models\Arts;
use common\models\ArtsClasses;
use common\models\ArtsStyles;
use common\models\ArtsContents;
use common\models\ArtsColors;

/**
 * 图片操作类
 * @date  2019-03
 */

class ArtService extends CommonService
{
	/**
	 * 条件查询图片数量
	 * @param  $classId  类型分类
	 * @param  $styleId  风格分类
	 * @param  $contId  内容分类
	 * @param  $colorId  颜色类型
	 * @param  $picName  图片名称
	 * @param  $picNo  图片编号
	 * @return  number
	 */
	public function getArtsCount($classId=0,$styleId=0,$contId=0,$colorId=0,$picName='',$picNo='')
	{
		$count = Arts::find()->where(['>','art_state',Arts::ART_STATE_DEL]);
		if ($classId) {
			$count->andWhere(['art_class'=>$classId]);
		}
		if ($styleId) {
			$count->andWhere(['art_style'=>$styleId]);
		}
		if ($contId) {
			$count->andWhere(['art_content'=>$contId]);
		}
		if ($colorId) {
			$count->andWhere(['art_color'=>$colorId]);
		}
		if ($picName) {
			$count->andWhere(['like','art_title',$picName]);
		}
		if ($picName) {
			$count->andWhere(['like','art_no',$picNo]);
		}
		return $count->count();
	}

	/**
	 * 图片分页数据
	 * @param  $limit  每页条数
	 * @param  $offset  开始位置
	 * @param  $classId  类型分类
	 * @param  $styleId  风格分类
	 * @param  $contId  内容分类
	 * @param  $colorId  颜色类型
	 * @param  $picName  图片名称
	 * @param  $picNo  图片编号
	 */
	public function getArtsList($limit=20,$offset=0,$classId=0,$styleId=0,$contId=0,$colorId=0,$picName='',$picNo='')
	{
		$list = Arts::find()
			->from(['a'=>Arts::tableName()])
			->joinWith(['artsColors c'])
			->where(['>','a.art_state',Arts::ART_STATE_DEL]);
		// 查询条件
		if ($classId) {
			$count->andWhere(['a.art_class'=>$classId]);
		}
		if ($styleId) {
			$count->andWhere(['a.art_style'=>$styleId]);
		}
		if ($contId) {
			$count->andWhere(['a.art_content'=>$contId]);
		}
		if ($colorId) {
			$count->andWhere(['a.art_color'=>$colorId]);
		}
		if ($picName) {
			$count->andWhere(['like','a.art_title',$picName]);
		}
		if ($picName) {
			$count->andWhere(['like','a.art_no',$picNo]);
		}
		return $list->limit($limit)->offset($offset)->all();
	}

	/**
	 * 获取画作分类名称
	 * @param  $id
	 * @return  string
	 */
	public function getArtClassName($id)
	{
		$info = ArtsClasses::getArtClassInfo($id);
		return empty($info) ? '' : $info->class_name;
	}

	/**
	 * 获取图片风格分类名
	 * @param  $id
	 * @return string
	 */
	public function getArtStyleName($id)
	{
		$info = ArtsStyles::getArtStyleInfo($id);
		return empty($info) ? '' : $info->style_name;
	}

	/**
	 * 获取内容分类名称
	 * @param  $id
	 * @return  string
	 */
	public function getArtContentName($id)
	{
		$info = ArtsContents::getArtContentInfo($id);
		return empty($info) ? '' : $info->content_name;
	}

	/**
	 * 获取图片颜色信息
	 * @param  $colorId
	 * @return  object
	 */
	public function getArtColorInfo($colorId)
	{
		return ArtsColors::find()->where(['id'=>$colorId,'color_state'=>ArtsColors::COLOR_STATE_USABLE])->one();
	}

	/**
	 * 获取图片的信息
	 * @param  $picId  图片id
	 * @return  object
	 */
	public function getArtsInfo($picId)
	{
		return Arts::find()
			->from(['a'=>Arts::tableName()])
			->joinWith(['artsColors c'])
			->joinWith(['artsImages g'])
			->joinWith(['authors u'])
			->where(['id'=>$picId])
			->andWhere(['>','a.art_state',Arts::ART_STATE_DEL])
			->one();
	}

	/**
	 * 禁用图片
	 * @param  $picId
	 * @return  bool
	 */
	public function delArt($picId)
	{
		$info = Arts::findOne($picId);
		if (empty($info)) {
			return false;
		}
		if ($info->art_state == Arts::ART_STATE_USABLE) {
			return true;
		} else {
			$info->art_state = Arts::ART_STATE_USABLE;
			return $info->save();
		}
	}

	/**
	 * 新增/修改图片
	 * @param  $userId
	 * @param  $picId  图片id（非必须）
	 * @param  $picName  图片名称
     * @param  $authorId  作者
     * @param  $birthAt  创作时间
     * @param  $artNum  数量
     * @param  $marketPrice  市场价
     * @param  $currentPrice  现价
     * @param  $showImages  图片地址
     * @param  $artClass  类型分类
     * @param  $artStyle  风格分类
     * @param  $artContent  内容分类
     * @param  $artColor  颜色信息
     * @param  $length  长度
     * @param  $width  宽度
     * @param  $dpi  分辨率
     * @param  $mark  备注
     * @param  $desc  描述
	 */
	public function setArtDetail($userId,$picName,$authorId,$birthAt,$artNum,$marketPrice,$currentPrice,$showImages,$artClass,$artStyle,$artContent,$artColor,$length,$width,$dpi,$mark,$desc,$picId=0)
	{
		try {
			// log
			\Yii::info("用户：".$userId."添加/修改图片：".$picName);
			// 处理图片主表信息
			if ($picId) {
				$picInfo = Arts::findOne($picId);
				if (empty($picInfo)) {
					return false;
				}
			} else {
				$picInfo = new Arts();
				$picInfo->create_at = date('Y-m-d H:i:s');
			}

			$picInfo->art_title = $picName;
			$picInfo->art_no = $artNo;	//图片编号 类型+编号
			$picInfo->art_sort = $artSort;	//图片排序
			$picInfo->author_id = $authorId;
			$picInfo->birth_at = $birthAt;
			$picInfo->art_num = $artNum;
			$picInfo->art_state = Arts::ART_STATE_USABLE;
			$picInfo->market_price = $marketPrice;
			$picInfo->current_price = $currentPrice;
			$picInfo->show_image = $showImages;	//图片需要处理，需要上传缩略图、详情图、效果图，除缩略图其他可为空
			$picInfo->art_class = $artClass;
			$picInfo->art_style = $artStyle;
			$picInfo->art_content = $artContent;
			$picInfo->art_color = $artColor;
			$picInfo->art_length = $length;
			$picInfo->art_width = $width;
			$picInfo->art_size = $size;	//计算详情图大小
			$picInfo->art_dpi = $dpi;
			$picInfo->mark = $mark; // 内容过滤
			$picInfo->desc = $desc; // 内容过滤
			$picInfo->save();
			// 处理图片副表信息

			// 记录操作行为
			
		} catch (Exception $e) {
			\Yii::error($e->getMessage());
			return false;
		}
		
	}

}