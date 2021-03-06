<?php
	//将分类1与商品关联
	namespace Home\Model;
	use Think\Model\RelationModel;
	class SeckillTypeGoodsRelationModel extends RelationModel{
		protected $trueTableName = 'seckill_type';#必须指定
		protected $_link = array(  	
			'seckill_goods'=>array(            
				'mapping_type'=> self::HAS_MANY,            
				'foreign_key' => 'type_id',
				'condition'=>"start<unix_timestamp(now()) and end > unix_timestamp(NOW())",
				'mapping_fields'=>'id,goodsname,price,img_url,start,end,num',
			)
		);
	}