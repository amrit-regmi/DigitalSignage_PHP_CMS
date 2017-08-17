<?php
require_once dirname(__DIR__) . '/models/WebsocketClient.php';
/**
 * This is the model class for table "screens".
 *
 * The followings are the available columns in table 'screens':
 * @property integer $ScreenId
 * @property string $MacAdd
 * @property integer $RouteId
 *
 * The followings are the available model relations:
 * @property Ads[] $ads
 * @property Route $route
 * @property SubscriptionData[] $subscriptionDatas
 */
class Screens extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'screens';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                       
			array('MacAdd,RouteId,ScreenName,serialNumber','required'),
			array('RouteId', 'numerical', 'integerOnly'=>true),	// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('MacAdd, RouteId', 'safe', 'on'=>'search'),
                        array('MacAdd','match','pattern'=>'/^[a-fA-F0-9]{12}$/','message'=>'Please use the proper format'),
                        array('serialNumber','match','pattern'=>'/^[a-fA-F0-9]{16}$/','message'=>'Please use the proper format')
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
                        'assigned'=>array(self::HAS_MANY,'assigned','ScreenId'),
			'ads' => array(self::MANY_MANY, 'Ads', 'assigned(ScreenId, AdsId)'),
			'route' => array(self::BELONGS_TO, 'Route', 'RouteId'),
			'subscription' => array(self::HAS_MANY, 'Subscription', 'ScreenId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ScreenName' => 'Screen Name',
			'MacAdd' => 'Mac Add',
			'RouteId' => 'Route',
                        'serialNumber'=>'Serial'
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

		$criteria->compare('ScreenId',$this->ScreenId);
		$criteria->compare('MacAdd',$this->MacAdd,true);
		$criteria->compare('RouteId',$this->RouteId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Screens the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
       
        public static function getScreenId($macAdd){
            $screen = Screens::model()->findByAttributes(array('MacAdd'=>$macAdd));
                $screenId = $screen->ScreenId;
                return $screenId;    
        }
        
        public static function getAdsId($screenId){
             $criteria=new CDbCriteria;
             $criteria->select = 'AdsId';
             $criteria->compare('ScreenId',$screenId);
             $criteria->with="ads";
             
                
             $data =new CActiveDataProvider('Assigned', array(
              'criteria'=>$criteria,
                'pagination'=>array(
                     'pageSize'=>1000,
                    ),
                ));
            return $data;
            
        }
        public static function getNews($rss_feed_url){ 
            $feed = array();
            $content = file_get_contents($rss_feed_url);
                $x = new SimpleXmlElement($content);
                    foreach($x->channel->item as $entry) {
                        $feed[] =$entry->title;
                } 
                return $feed;
        }
        /**
         * fetch all the screen for the given route
         * @param type $routeId 
         * @param type $pagination
         * @return \CActiveDataProvider
         */
        public static function getScreens($routeId,$pagination=true){
            $criteria= new CDbCriteria;
            $criteria->with = 'route';
            $criteria->compare('route.RouteId',$routeId);
           
            $data = new CActiveDataProvider('Screens',array('criteria'=>$criteria,'pagination'=>$pagination?array('pagesize'=>20,):false));
            return $data;
        }
        /**
         * fetch all the active sccreens for the given route
         * @param type $routeId
         * @param type $pagination
         * @return \CActiveDataProvider
         */
          public static function getActiveScreens($routeId,$pagination=true){
            $criteria= new CDbCriteria;
           
            $criteria->compare('RouteId',$routeId);
            $criteria->addCondition("Status=2");
           
            $data = new CActiveDataProvider('Screens',array('criteria'=>$criteria,'pagination'=>$pagination?array('pagesize'=>20,):false));
            return $data;
        }
        
        /**
         * return the routeId of the given screen
         * @param type $screenId
         * @return type routeId
         */
        public static function getRouteId($screenId){
           $screen= Screens::model()->findByAttributes(array('ScreenId'=>$screenId));
            return $screen->RouteId;
        }
        
        /**
         * Returns array of Screens for give route and client
         * @param type $routeId 
         * @param type $clientId
         * @param type $adsId if set omits the record on Assigned with the given add
         * @return type array
         */
        
        public static function getClientScreens($routeId,$clientId=null,$adsId=null){
            
            $screens=array();
           $criteria = new CDbCriteria();
           $criteria->compare('ClientId',$clientId);
             $criteria->addNotInCondition('AdsId',array($adsId));
           $activeScreens = Assigned::model()->findAll($criteria);
         
           foreach($activeScreens as $data){
               if(Screens::getRouteId($data->ScreenId)==$routeId){
                   $screens[]=$data->ScreenId;    
               }     
           }
           return array_unique($screens);   
        }
        
        public static function formatMac($mac){
            $chunks = array_map("strtoupper",str_split($mac, 2));
            $result = implode(':', $chunks);
            return $result;
        }
        public static function verifyScreen($mac,$serial){
            
        }
        public static function setShutdown($mac){
            $screen= Screens::model()->findByAttributes(array('MacAdd'=>$mac));
            $screen->updateAll(array('Status'=>0));
            $WebSocketClient = new WebsocketClient('localhost', 8080);
            $data = json_encode(array('type'=>'togglestatus','status'=>"0",'MacAdd'=>$mac));
            $WebSocketClient->sendData($data);
            unset($WebSocketClient);
            
        }
        /* public static function refreshPi($mac){
            $WebSocketClient = new WebsocketClient('localhost', 8080);
            $data = json_encode(array('type'=>'refresh','MacAdd'=>$mac));
            echo $WebSocketClient->sendData($data);
            unset($WebSocketClient);
         }*/
}