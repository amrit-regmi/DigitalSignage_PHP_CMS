<?php


class RouteController extends Controller
{    protected function beforeAction($actionObject) {
            $action = $actionObject->getId();
            if(!Users::checkLogin()){
                 $this->redirect(array('/site'));
                echo "Please login first";
                if(!isset($_GET['ajax'])){
                    $this->redirect(array('/'));
                }
                return false;
        }else{
            return parent::beforeAction($actionObject);
            
        }    
        
        }
	public function actionAdd()
	{
           $route = new Route();
            if(isset($_POST['ajax']) && $_POST['ajax']==='Route')
            {
                echo CActiveForm::validate($route); 
                Yii::app()->end();
            }
            if(isset($_POST['Route']))
            {   $updated = array();
                //print_r($_POST['Ads']);
                $route->attributes=$_POST['Route'];
                if($route->validate())
                {
                    if($route->save())
                    {
                        Yii::app()->user->setFlash('success','Route sucessfully uploaded, assign screens to this route');
                        $this->redirect(array('/Route/'.$route->RouteId));
                         Yii::app()->end();
                    }
                }
            }
           $this->render('add',array('model'=>$route));     
	}

	public function actionRemove()
	{
		$this->render('remove');
	}

	public function actionUpdate($id)
	{
              $route = Route::model()->findByPk($id);
            if(isset($_POST['ajax']) && $_POST['ajax']==='Route')
            {
                echo CActiveForm::validate($route); 
                Yii::app()->end();
            }
            if(isset($_POST['Route']))
            {   $updated = array();
                //print_r($_POST['Ads']);
                $route->attributes=$_POST['Route'];
                if($route->validate())
                {
                    if($route->update())
                    {
                        Yii::app()->user->setFlash('success','Route sucessfully updated');
                        $this->redirect(array('/Route/'));
                         Yii::app()->end();
                    }
                }
            }
		$this->render('update',array('model'=>$route));
	}

	public function actionView($id)
                
	{  
            
            $route = Route::model()->findByPk($id);
            $data= Screens::getScreens($id,false);
            $activedata = Screens::getActiveScreens($id,false);
            $adsIds = Assigned::getAdsinRoute($id);
            $ads= array();
            foreach($adsIds as $adss){
                $ads[]=Ads::model()->findByPk($adss);
                
            }
            $client= Subscription::getClients($id,true);     
            $this->render('view',array('datas'=>$data,'activedata'=>$activedata,'route'=>$route,'ads'=>$ads,'client'=>$client));
	}
        public function actionIndex()
	{ 
          
            $data = new CActiveDataProvider('Route');       
            $this->render('index',array('data'=>$data));
            
            
            
	}
        public function actionAddAds($id){
            $route = Route::model()->findByPk($id);
            $model=new Ads('addtoRoute');

            // uncomment the following code to enable ajax-based validation
            
            if(isset($_POST['ajax']) && $_POST['ajax']==='Ads')
            {
                echo CActiveForm::validate($model,array('name','ClientId','RouteId','NumScreens')); 
                Yii::app()->end();
            }
            

            if(isset($_POST['Ads']))
            {   $updated = array();
                //print_r($_POST['Ads']);
                $model->attributes=$_POST['Ads'];
                if($model->validate())
                {
                     $model->name=$_POST['Ads']['name'];
                     $model->ClientId=$_POST['Ads']['ClientId'];
                     $model->Date=date('Y-m-d H:i:s');
                      
                     $temp=CUploadedFile::getInstance($model,'Source');
                     $a = uniqid();
                     $model->Source = '/images/'.$a.'.jpg';
                    
            if($model->save())
            {
                $temp->saveAs(Yii::app()->getBasePath().'/../images/'.$a.'.jpg');
             
                $add = array();
                foreach($_POST['Ads']['ScreenId'] as $key=> $value){                   
                    $add[]=Assigned::assigntoScreen($value,$model->AdsId, $model->ClientId);

                }
                
                $params = array('data'=>array('Id'=>$model->AdsId,'source'=>Yii::app()->getBaseUrl().$model->Source));
                Assigned::pushToscreen(array('add'=>$add),$params);
                Yii::app()->user->setFlash('success','Advert sucessfully uploaded and Assigned to screens');
                
                $this->redirect(array('/ads/'.$model->AdsId));
               
                
               //echo "<div class='alert in alert-block fade alert-success'><a href='#' class='close' data-dismiss='alert'>×</a>Advert sucessfully uploaded and Assigned to screens</div>"; 
               
            }
                }
                
                //print_r($_POST['Ads']);
               
            }
            //print_r($data_subscription->getData());
            $this->render('addAds',array('model'=>$model,'route'=>$route));
            
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
