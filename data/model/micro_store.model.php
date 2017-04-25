<?php
/**
 * 分享秀店铺街模型
 *
 *
 *
 * * @FeiWa (c) 2015-2018 FeiWa   (http://www.feiwa.org)
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 * @since      山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 */
defined('ByFeiWa') or exit('Access Invalid!');
class micro_storeModel extends Model{

    const TABLE_NAME = 'micro_store';
    const PK = 'store_id';

    public function __construct(){
        parent::__construct('micro_store');
    }

    /**
     * 读取列表
     *
     */
    public function getList($condition,$page=null,$order='',$field='*',$limit=''){
        $result = $this->table(self::TABLE_NAME)->field($field)->where($condition)->page($page)->order($order)->limit($limit)->select();
        return $result;
    }


    /**
     * 读取列表包含店铺详细信息
     *
     */
    public function getListWithStoreInfo($condition,$page=null,$order='',$field='*',$limit=''){
        $store_list = $this->field($field)->where($condition)->page($page)->order($order)->limit($limit)->select();

        if(!empty($store_list)) {
            $model_store = Model('store');
            for ($i = 0, $j = count($store_list); $i < $j ; $i++) {
               $store_list[$i]['hot_sales_list'] = $model_store->getHotSalesList($store_list[$i]['mall_store_id'], 5);
               $store_info = $model_store->getStoreInfoByID($store_list[$i]['mall_store_id']);
               $store_list[$i] = array_merge($store_list[$i], $store_info);
            }
        }
        return $store_list;
    }

    /**
     * 根据编号获取单个内容
     *
     */
    public function getOne($param){
        $result = $this->table(self::TABLE_NAME)->where($param)->find();
        return $result;
    }

    /**
     * 根据编号获取单个内容
     *
     */
    public function getOneWithStoreInfo($param){
        $result = $this->where($param)->find();
        if(!empty($result)) {
            $model_store = Model('store');
            $store_info = $model_store->getStoreInfoByID($result['mall_store_id']);
            $result = array_merge($result, $store_info);
        }
        return $result;
    }

    /*
     *  判断是否存在
     *  @param array $condition
     *
     */
    public function isExist($param) {
        $result = $this->getOne($param);
        if(empty($result)) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    /*
     * 增加
     * @param array $param
     * @return bool
     */
    public function save($param){
        return $this->table(self::TABLE_NAME)->insert($param);
    }

    /*
     * 批量增加
     * @param array $param
     * @return bool
     */
    public function saveAll($param){
        return $this->table(self::TABLE_NAME)->insertAll($param);
    }

    /*
     * 更新
     * @param array $update_array
     * @param array $where_array
     * @return bool
     */
    public function modify($update_array, $where_array){
        return $this->table(self::TABLE_NAME)->where($where_array)->update($update_array);
    }

    /*
     * 删除
     * @param array $param
     * @return bool
     */
    public function drop($param){
        return $this->table(self::TABLE_NAME)->where($param)->delete();
    }

}
