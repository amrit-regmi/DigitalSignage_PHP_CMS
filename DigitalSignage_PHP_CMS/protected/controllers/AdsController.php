<?php

class AdsController extends Controller
{      protected function beforeAction($actionObject) {
            $action = $actionObject->getId();
            if(!Users::checkLogin()){
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
            $id= Yii::app()->request->getQuery('id');
            $model=new Ads('add');

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
             
                
                foreach($_POST['Ads']['RouteId'] as $key=> $value){
 
                    $update = Assigned::assignAds($value,$_POST['Ads']['NumScreens'][$key], $_POST['Ads']['ClientId'], $model->AdsId);
                    $updated = $update + $updated;
                }
                
                $params = array('data'=>array('Id'=>$model->AdsId,'source'=>Yii::app()->getBaseUrl().$model->Source));
                Assigned::pushToscreen(array('add'=>$updated),$params);
                Yii::app()->user->setFlash('success','Advert sucessfully uploaded and Assigned to screens');
                
                $this->redirect(array('/ads/'.$model->AdsId));
               
                
               //echo "<div class='alert in alert-block fade alert-success'><a href='#' class='close' data-dismiss='alert'>×</a>Advert sucessfully uploaded and Assigned to screens</div>"; 
               
            }
                }
                
                //print_r($_POST['Ads']);
               
            }
            
            $data_subscription = Client::getSubscriptiondata($id);
            //print_r($data_subscription->getData());
            $this->render('add',array('model'=>$model,'client_Id'=>$id,'data_subscription'=>$data_subscription));}
        

	public function actionRemove($id)
	{
        
        $params = array('data'=>array('Id'=>$id,'source'=>''));
        $removed = Assigned::rmAssignedAds($id);
       
 
        Ads::model()->findByPk($id)->delete();
        Assigned::pushToscreen(array('remove'=>$removed),$params);
        Yii::app()->user->setFlash('success','Advert sucessfully deleted');
       
       $this->redirect(array('/'.$_GET['ref']));
        
	}

	public function actionUpdateAssignments()
	{   
            
            $id= Yii::app()->request->getQuery('id');
            $model = Ads::model()->findByPk($id);
            //print_r($model);
            $model->setScenario('updateAssignments');
            
            if(isset($_POST['name'])){
                $model = Ads::model()->findByPk($_POST['pk']);
                if($_POST['name']=='name'){
                    $model->setScenario('updateName');
                    $model->name = $_POST['value'];
                    if($model->validate(array('name'))){
                        $model->save(false);
                    Yii::app()->end();
                    }
                
                }elseif($_POST['name']=='Expires'){ 
                     $model = Ads::model()->findByPk($_POST['pk']);
                    $model->setScenario('updateExpires');
                    $model->Expires = $_POST['value'];
                    if($model->validate(array('Expires'))){
                        $model->save(false);
                    Yii::app()->end();
                    }
                
                }
            }
            elseif(isset($_POST['ajax']) && $_POST['ajax']==='Ads')
            { 
               echo CActiveForm::validate($model,array('RouteId','NumScreens')); 
                Yii::app()->end();
            }
             
           if(isset($_POST['Ads']['RouteId']))
            {
               
                $updated =Assigned::updateAssigned($_POST['Ads'],$model->AdsId);
         
                Yii::app()->user->setFlash('success','Advert sucessfully reassigned to routes');
                
                $params = array('data'=>array('Id'=>$model->AdsId,'source'=>Yii::app()->getBaseUrl().$model->Source));
                Assigned::pushToscreen($updated,$params);
               
                $this->redirect(array('/ads/'.$model->AdsId."/?ref=".$_GET['ref']));
                
                Yii::app()->end();
               
            }
            $assignedData = Assigned::getAssignedData($model->AdsId);
            $data_subscription = Client::getSubscriptiondata($id);
            $this->renderPartial('updateAssignments',array('assignedData'=>$assignedData,'model'=>$model,'client_Id'=>$model->ClientId,'data_subscription'=>$data_subscription),FALSE,TRUE);
	}

	public function actionView()
	{
             $id= Yii::app()->request->getQuery('id');
            $adverts = Ads::getAdsDetail($id);
            $this->render('view',array('model'=>$adverts));
	}
        
        
        /**
         * handels ajax calls to get number of available screens on selected route for given client
         */
        public function actionAjaxAvailable(){
            
            $clientId= $_GET['clientId'];
            $routeId = $_GET['routeId'];
            $adsId=null;
            if(isset($_GET['AdsId'])){
                $adsId = $_GET['AdsId'];
            }
            $a = Subscription::getAvailableScreens($routeId,$clientId,$adsId);  
            echo $a;
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