<?php

/**
 * This is the model class for table "subscription".
 *
 * The followings are the available columns in table 'subscription':
 * @property integer $SubscriptionId
 * @property integer $RouteId
 * @property integer $NumAds
 * @property integer $NumScreen
 * @property string $Expire
 * @property integer $ClientId
 *
 * The followings are the available model relations:
 * @property Route $route
 * @property Client $client
 */
class Subscription extends CActiveRecord
{
    public $SubscriptionId;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subscription';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                         array('RouteId', 'uniqueValidator','attributeName'=>array('RouteId','ClientId'),'on'=>'create'),
			array('RouteId, NumAds, NumScreen, Expire', 'required'),
			array('RouteId, NumAds, NumScreen, ClientId', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('SubscriptionId, RouteId, NumAds, NumScreen, Expire, ClientId', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'route' => array(self::BELONGS_TO, 'Route', 'RouteId'),
			'client' => array(self::BELONGS_TO, 'Client', 'ClientId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'SubscriptionId' => 'Subscription',
			'RouteId' => 'Route',
			'NumAds' => 'Num Ads',
			'NumScreen' => 'Num Screen',
			'Expire' => 'Expire',
			'ClientId' => 'Client',
                        'Expires'=>'Expire'
		);
	}
        public static function countAds(){
            
        }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('SubscriptionId',$this->SubscriptionId);
		$criteria->compare('RouteId',$this->RouteId);
		$criteria->compare('NumAds',$this->NumAds);
		$criteria->compare('NumScreen',$this->NumScreen);
		$criteria->compare('Expire',$this->Expire,true);
		$criteria->compare('ClientId',$this->ClientId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Subscription the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
       
       
        public static function getSubscriptionStatus($clientId){
            $criteria = new CDbCriteria();
            $criteria->compare('ClientId', $clientId);
            $data =new CActiveDataProvider('Subscription',array('criteria'=>$criteria));
            return $data;
            
            
            
        }
        public static function getSubscribedRoutes($clientId){
            $criteria = new CDbCriteria();
            $criteria->compare('ClientId', $clientId);
            $criteria->with=array('route');
            $data= Subscription::model()->findAll($criteria);
            return $data;
        }
        /**
         * Returns number of screens available to be assigned for the given route and client
         * @param type $routeId
         * @param type $clientId
         * @param type $adsId if set omits the records on Screens where adsid is matched in updateAssignment senarios
         * @return type int 
         */
        public static function getAvailableScreens($routeId,$clientId,$adsId=null){
            
            $value =sizeof(Screens::getClientScreens($routeId,$clientId,$adsId));
            
            $criteria=new CDbCriteria();
             
            $criteria->select="NumScreen";
            $criteria->addColumnCondition(array('t.ClientId' => $clientId,'t.routeId'=>$routeId));
                     
            $value2=  Subscription::model()->findAll($criteria);
            return $value2[0]->NumScreen-$value;
        }
        public static function getClients($routeId,$dataprovider=false){
            $criteria = new CDbCriteria();
            $criteria->compare('RouteId',$routeId);
            $criteria->with=array('client');
            if($dataprovider){
               $data = new CActiveDataProvider('Subscription', array('criteria'=>$criteria));  
            }else{
            $data= Subscription::model()->findAll($criteria);
            
            }
            return $data;
        }
        public static function activiate($id){
            Subscription::model()->updateByPk($id,array('Status'=>1));
            
        }
        public static function deactiviate($id){
            $s = Subscription::model()->findByPk($id);
            $s->Status=0;
            $s->update();
            Assigned::rmAssignRoute($s->RouteId,$s->ClientId);
            
        }
}
