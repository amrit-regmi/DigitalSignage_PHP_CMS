<?php
require_once dirname(__DIR__) . '/models/WebsocketClient.php';
/**
 * This is the model class for table "assigned".
 *
 * The followings are the available columns in table 'assigned':
 *  @property string $AsssignedId
 * @property string $ScreenId
 * @property integer $AdsId
 * @property integer $ClientId
 */
class Assigned extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public $screen_routeId;
	public function tableName()
	{
		return 'assigned';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ScreenId, AdsId', 'required'),
			array('AdsId, ClientId', 'numerical', 'integerOnly'=>true),
			array('ScreenId', 'length', 'max'=>25),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ScreenId, AdsId, ClientId,AssignedId', 'safe', 'on'=>'search'),
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
			'ads' => array(self::BELONGS_TO, 'Ads', 'AdsId'),
                        'screen'=>array(self::BELONGS_TO,'Screens','ScreenId'),
                      
                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ScreenId' => 'Screen',
			'AdsId' => 'Ads',
			'ClientId' => 'Client',
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

		$criteria->compare('ScreenId',$this->ScreenId,true);
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
	 * @return Assigned the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
         public static function adsCountScreen($screenId,$clientId=null){
             $criteria = new CDbCriteria();
             $criteria->compare("ScreenId",$screenId);
             $criteria->compare("ClientId",$clientId);
             return Assigned::model()->count($criteria);  
        }
        
        /**
         * Returns the all the Ads in the given route for the given client
         * @param type $routeId 
         * @param type $clientId if set null returns all the ads for the route
         * @param type $filter set true returns the ads without repeatations set false returns everything
         * @return type array of adsid
         */
        public static function getAdsinRoute($routeId,$clientId=null,$filter=true){
           $ads=array();
           $criteria = new CdbCriteria();
           $criteria->compare('ClientId',$clientId);
           $activeScreens = Assigned::model()->findAll($criteria);
           foreach($activeScreens as $data){
               if(Screens::getRouteId($data->ScreenId)==$routeId){
                   $ads[]=$data->AdsId;    
               }     
           }
           if($filter){
           return array_unique($ads);   
           }else{
               return $ads;
           } 
           
        }
        /**
         * Retuns the rawdata as routeid and number of screens displying for the given adsId 
         * @param type $AdsId
         * @return type rawdata
         */
        public static function getAssignedData($AdsId){
            $query ="SELECT S.RouteId, Count(S.RouteId) as NumScreen From Assigned A LEFT JOIN Screens S on A.ScreenId = S.ScreenId Where A.AdsId= :adsId GROUP BY S.RouteId";
            $command= Yii::app()->db->createCommand($query);
            $command->bindValue(':adsId', $AdsId);
            $rawData = $command->queryAll();
            return $rawData;
        }
        
        
        public static function assignAds($routeId,$numScreens,$clientId,$adsId){
            $query = "SELECT S.ScreenId, count(A.ScreenId) AS count From Screens S LEFT JOIN Assigned A ON A.ScreenId = S.ScreenId Where S.ScreenId in (Select B.ScreenId from Screens B where RouteId = :routeId )GROUP BY ScreenId ORDER BY count ASC Limit ".$numScreens;
           //query to get the exact number of specefied (param $numscreens) screenIds belonging to the given route parma$routeId sorting by screen with lowest adscount
            $command= Yii::app()->db->createCommand($query);
            $command->bindValue(':routeId', $routeId);
            //$command->bindValue(':numScreens', $numScreens);
            $ScreenstoUpdate = $command->queryAll();
           
            $add= array();
            
            foreach($ScreenstoUpdate as $key=> $value){
                $query1 = "INSERT INTO Assigned
                    (ScreenId, AdsId, ClientId)
                VALUES
                    (:screenId,:adsId,:clientId);";
                
                $command1= Yii::app()->db->createCommand($query1);
                $command1->bindValue(':screenId', $value['ScreenId'],PDO::PARAM_STR);
                $command1->bindValue(':adsId', $adsId,PDO::PARAM_INT);
                $command1->bindValue(':clientId', $clientId,PDO::PARAM_INT);
                //echo 'up'.$value['ScreenId'].PHP_EOL;
               if($command1->execute()){
                   $add[]=$value['ScreenId'];
               }
               
            }
            return $add;
        }
        
        public static function rmAssignedAds($AdsId){ //removes the given ad from all the screen and returns affected screenIds
            $criteria=new CDbCriteria;
            $criteria->condition="AdsId =".$AdsId;
            $screenId=  Assigned::model()->findAll($criteria);
            
            $removed= array();
           
           foreach($screenId as $screen){
               //echo 'rm'.$screen['ScreenId'].PHP_EOL;
               if($screen->delete()){
               $removed[]=$screen['ScreenId'];
               }
           }
        return $removed;
        }
        
        public static function updateAssigned($ads,$adsId){
            $adsRemovedfrom = Assigned::rmAssignedAds($adsId);
            $adsAddedto = array();
            foreach($ads['RouteId'] as $key=> $value){
                     $updated = Assigned::assignAds($value,$ads['NumScreens'][$key], $ads['ClientId'],$adsId);
                     $adsAddedto=  array_merge($adsAddedto,$updated);
                }
                /*print_R($ads);
                print_r($adsRemovedfrom);
                print_r($adsAddedto); */
                $update = array('remove'=>array_values(array_diff($adsRemovedfrom,$adsAddedto)),'add'=>array_values(array_diff($adsAddedto,$adsRemovedfrom)));
                //print_r($affected_screens);
                return $update;
        }
        
        public static function pushToscreen($screenId,$params){
            $WebSocketClient = new WebsocketClient('localhost', 8080);
            $data = json_encode(array('type'=>'push','push'=>$params,'Screens'=>$screenId));
            echo $WebSocketClient->sendData($data);
            unset($WebSocketClient);
            
        }
        public static function assigntoScreen($screenId,$adsId,$clientId){
            $query1 = "INSERT INTO Assigned
                    (ScreenId, AdsId, ClientId)
                VALUES
                    (:screenId,:adsId,:clientId);";
                
                $command1= Yii::app()->db->createCommand($query1);
                $command1->bindValue(':screenId', $screenId,PDO::PARAM_INT);
                $command1->bindValue(':adsId', $adsId,PDO::PARAM_INT);
                $command1->bindValue(':clientId', $clientId,PDO::PARAM_INT);
                $command1->execute();
                return $screenId;
        }
        public static function rmAssignRoute($routeId,$clientId){
            $sid = Screens::getClientScreens($routeId, $clientId);
            
            $criteria = new CDbCriteria();
            $criteria->addInCondition('ScreenId', $sid);
            $criteria->addCondition('ClientId='.$clientId);
            Assigned::model()->deleteAll($criteria);
           
        }
       
        
}
