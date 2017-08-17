<?php

/**
 * This is the model class for table "ads".
 *
 * The followings are the available columns in table 'ads':
 * @property integer $AdsId
 * @property integer $ClientId
 *
 * The followings are the available model relations:
 * @property Client $client
 * @property Screens[] $screens
 */
class Ads extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ads';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
        public $NumScreens ;
        public $RouteId;
        public $ScreenId;
        
     

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        
                       array('name,ClientId','required','on'=>'addtoscreen,addtoRoute'),
                        array('ScreenId','required','on'=>'addtoRoute'),
                        array('Source', 'file','allowEmpty'=>false, 'types'=>'jpg, gif, png'),
                        array('RouteId,NumScreens', 'required','on' => 'updateAssignments'),
                        array('name,RouteId,NumScreens', 'required','on'=>'add'),
                        array('name', 'required','on'=>'updateName'),
                        array('Expires','date','format'=>'yyyy-MM-dd'),
                        array('Expires','required','on'=>'updateExpires'),
			array('ClientId','numerical','integerOnly'=>true),
                        array('RouteId','validateRouteScreen','on'=>'add,updateAssignments'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('AdsId, ClientId', 'safe', 'on'=>'search'),
                        //array('Source', 'file', 'types'=>'jpg, gif, png'),
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
			'client' => array(self::BELONGS_TO, 'Client', 'ClientId'),
			'screens' => array(self::MANY_MANY, 'Screens', 'assigned(AdsId, ScreenId)'),
                        'assigned'=>array(self::HAS_MANY,'Assigned','AdsId'),
                        'occurence'=>array(self::STAT,'Assigned','AdsId')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'AdsId' => 'Ads',
			'ClientId' => 'Client',
                        'NumScreens'=>'Number of screens'
		);
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

		$criteria->compare('AdsId',$this->AdsId);
		$criteria->compare('ClientId',$this->ClientId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ads the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public static function getallAds($pageination = true){
                
             $data =new CActiveDataProvider('Ads', array(
                'pagination'=>$pageination?array(
                     'pageSize'=>20,
             ):false,
                ));
            return $data;
        }
        
        /**
         * Returns all the ads with details of the specified client
         * @param type $clientId
         */
        public static function getAllAdsDetail($clientId){
            $criteria1= new CDbCriteria();
                $criteria1->compare('ClientId', $clientId);
                $criteria1->with=array('occurence');
                $ads = new CActiveDataProvider('Ads',array('criteria'=>$criteria1, 'pagination'=>false,));
                Return $ads;
        }
        /**
         * Returns the Adverts detail of the specified ads
         * @param type $adsId 
         */
        public static function getAdsDetail($adsId){
            $criteria1= new CDbCriteria();
                $criteria1->compare('AdsId', $adsId);
                $criteria1->with=array('occurence');
                $ads = Ads::model()->find($criteria1);
                Return $ads;
        }
        
        public static function getRecentAds($numberofAds =16){   
            $data =new CActiveDataProvider('Ads',array(
                'pagination'=>false,
                'criteria'=>array(
                        'order'=>'Date DESC',
                        'limit'=>$numberofAds,
                        ),
                )
             );
                
            return $data;
            
            
        }
         public static function getRoutes($adsId,$dataprovider=true ){
            $criteria = new CdbCriteria();
            
            $criteria->compare('t.AdsId',$adsId);
            $criteria->select= 'screen.RouteId as screen_routeId,t.ScreenId';
            $criteria->with=array('screen'=>array('select'=>'RouteId'));
            $routes = new CActiveDataProvider('Assigned',array('criteria'=>$criteria));
            if($dataprovider){
                return $routes;
                
            }else{
                $routeIds= array();
                foreach($routes->getData() as $data){
                    $routeIds[]=$data->screen_routeId;
                }
                return array_unique($routeIds);
            }
            
         }
         
         public function validateRouteScreen($attribute,$params){
             if(count(array_unique($this->$attribute))<count($this->$attribute))
        {       $this->addError($attribute, 'Same  route cannot be repeated twice');
                //echo 'Array has duplicates';
        }
        
             foreach($this->$attribute as $key => $value){
                 if($value == null){
                      $this->addError($attribute, 'You must specify at least one route');
                 }
                
                 elseif(!is_numeric($this->NumScreens[$key])){
                    echo $this->NumScreens[$key];
                    $this->addError($attribute, 'Number of screens must be numeric value ');
                 }
                 elseif(!Subscription::model()->exists('RouteId=:routeId AND ClientId=:clientId', array(":routeId"=>$value,":clientId"=>$this->ClientId))){
                     $this->addError($attribute, 'Route does not exist in your subscription');
                 }elseif( Subscription::getAvailableScreens($value,$this->ClientId,$this->AdsId) < $this->NumScreens[$key]){
                     $this->addError($attribute, 'Do not exceed the available screens');
                 }
                 
             }
             
         }
        
}
