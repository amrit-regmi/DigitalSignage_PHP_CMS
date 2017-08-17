<?php

class ScreensController extends Controller
{   protected function beforeAction($actionObject) {
            $action = $actionObject->getId();
            if(!Users::checkLogin() && ($action !=='render' && $action !=='news' && $action !=='weather'  && $action !=='shuttingDown' )){
                 $this->redirect(array('/site'));
                if(!isset($_GET['ajax'])){
                    $this->redirect(array('/site'));
                }
                return false;
        }else{
            return parent::beforeAction($actionObject);
            
        }    
        
        }
	public function actionAdd()
	{
            if(isset($_POST['rid'])){ //if screen is added from route page seting the route to that route
                $model1=  Route::model()->findByPk($_POST['rid']);
                $routelist = array($model1->RouteId=> $model1->RouteName);    
            }
            else
                {
            $sel_route = Route::model()->findAll();
            $routelist = CHtml::listData($sel_route, 
                'RouteId', 'RouteName');    
            }   
            
            $model= new Screens();
            
            if(isset($_POST['ajax'])&& $_POST['ajax'] =='addScreen'){
                if(isset($_POST['MacAdd'])&& $_POST['Serial']){
                    $model->MacAdd = $_POST['MacAdd'];
                    $model->serialNumber=$_POST['Serial'];
                }
                
                $this->renderPartial('_add',array('model'=>$model,'routelist'=>$routelist));
                 Yii::app()->end();
            }
            
                   
            if(isset($_POST['ajax']) && $_POST['ajax']=='Screens')
            {
                echo CActiveForm::validate($model); 
                Yii::app()->end();
                //Yii::app()->end();
            }if(isset($_POST['Screens']))
            {
                //print_r($_POST['Ads']);
                $model->attributes=$_POST['Screens'];
                if($model->validate())
                {    
                    
                   // print_r($model);
                    if($model->save())
                    {
                        Yii::app()->user->setFlash('success','Screen sucessfully added to system , screen will be available in a while');
                       $this->redirect(array('/Screens/'.$model->ScreenId));
                       //Screens::refreshPi($model->MacAdd);
                    }
                }
           }
           $this->render('add',array('model'=>$model,'routelist'=>$routelist));
	}
        public function actionIndex()
	{        
            $this->render('index',array('data'=> new CActiveDataProvider('Screens')));
                


	}

	public function actionRemove($id)
	{
            Yii::app()->user->setFlash('success','Screens sucessfully removed');
            Screens::model()->findByPk($id)->delete();
            
            
	}

	public function actionUpdate($id)
	{   
            $sel_route = Route::model()->findAll();
            $routelist = CHtml::listData($sel_route, 
                'RouteId', 'RouteName');    
 
            $model= Screens::model()->findByPk($id);
            
                   
            if(isset($_POST['ajax']) && $_POST['ajax']=='Screens')
            {
                echo CActiveForm::validate($model); 
                Yii::app()->end();
                //Yii::app()->end();
            }if(isset($_POST['Screens']))
            {
                //print_r($_POST['Ads']);
                $model->attributes=$_POST['Screens'];
                if($model->validate())
                {    
                    
                   // print_r($model);
                    if($model->update())
                    {
                        Yii::app()->user->setFlash('success','Sucessfully Updated Screen '.$model->ScreenId);
                       $this->redirect(array('/Screens/'.$model->ScreenId));
                    }
                }
           }
		$this->render('update',array('model'=>$model,'routelist'=>$routelist));
	}
        
        
        
        
        
        
        public function actionView($id){
            
            $screen = Screens::model()->findByPk($id);
            $ads = Screens::getAdsId($screen->ScreenId);
            $this->render('view',array('ads'=>$ads,'screen'=>$screen));
         
       
        }

	public function actionRender()
        {    
            if(isset($_GET['id']) && isset($_GET['sid'])){
                            
                            $screen = Screens::model()->findByAttributes(array('MacAdd' =>$_GET['id'],'serialNumber'=>$_GET['sid']));
                            if($screen != null){  
                            $screenId = Screens::getScreenID($_GET['id']);
                            $this->layout = 'empty';
                            $ads = Screens::getAdsId($screenId)->getData();
                            $adsId= array();
                            
                            foreach($ads as $value){
                                $adsId[]=$value->AdsId;
                            }


                            $criteria = new CDbCriteria();
                            $criteria->addInCondition('AdsId',$adsId);

                            $data =  new CActiveDataProvider('Ads',array('criteria'=>$criteria,'pagination'=>false));
                            
                            $screen->sess_id = session_id();
                            $screen->update();

                            $this->render('render',array('data'=>$data,'sid'=>$screenId));

                            } else{
               $this->beginWidget(
    'booster.widgets.TbJumbotron',
    array(
        'heading' => 'YOU ARE NOT AUTHORIZED TO CONNECT',
    )
); ?>
 
    <p>"YOU ARE NOT AUTHORIZED TO CONNECT"</p>
 
    <p>
<?php $this->endWidget();



                }
        
               
                }
        
           
       
	} 
        public function actionWeather(){
            $content = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=kathmandu&units=metric');
            /*$basicinfo = $content['main'];
            $basicinfiWeather=$content['weather'][0];
            print_r($content);
            print_r($basicinfo);*/
            echo $content;

        }
        public function actionNews(){
            print_r(json_encode(Screens::getNews('http://imagechannels.com/feed')));
            
        }
        public function actionAddAds($id){
            $model = new Ads('addtoscreen');
            if(isset($_POST['ajax']) && $_POST['ajax']==='Ads')
            {
                echo CActiveForm::validate($model,array('name','ClientId')); 
                Yii::app()->end();
            }
            

            if(isset($_POST['Ads']))
            {   
                
                $model->attributes=$_POST['Ads'];
                //print_R($model);
                if($model->validate())
                {
                    //print_r($_POST['Ads']); 
                    $model->name=$_POST['Ads']['name'];
                     
                     $model->ClientId=$_POST['Ads']['ClientId'];
                     $model->Date=date('Y-m-d H:i:s');
                      
                     $temp=CUploadedFile::getInstance($model,'Source');
                     $a = uniqid();
                     $model->Source = '/images/'.$a.'.jpg';
                    
                        if($model->save())
                        {
                            $temp->saveAs(Yii::app()->getBasePath().'/../images/'.$a.'.jpg');  
                            $params = array('data'=>array('Id'=>$model->AdsId,'source'=>Yii::app()->getBaseUrl().$model->Source));
                            Assigned::assigntoScreen($id, $model->AdsId,  $model->ClientId);
                            Assigned::pushToscreen(array('add'=>array($id)), $params);
                            Yii::app()->user->setFlash('success','Advert sucessfully uploaded and Assigned to screens');
                            $this->redirect(array('/ads/'.$model->AdsId."/?ref=Screens/".$id));

                           //echo "<div class='alert in alert-block fade alert-success'><a href='#' class='close' data-dismiss='alert'>×</a>Advert sucessfully uploaded and Assigned to screens</div>"; 

                        }
                }
                
                //print_r($_POST['Ads']);
               
            }
            //print_r($data_subscription->getData());
            $this->render('addAds',array('model'=>$model));
        }
        
        public function actionShuttingDown(){
            $id=$_GET['Mac'];
            Screens::setShutDown($id);
            yii::app()->end();
            
            
            
        }
		

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}