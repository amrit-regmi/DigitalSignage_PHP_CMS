<?php
//require_once 'PHP-Websockets-master\testwebsock.php';




class ClientController extends Controller
{
  protected function beforeAction($actionObject) {
            $action = $actionObject->getId();
            if(!Users::checkLogin()){
                 $this->redirect(array('/site'));
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
    $model=new Client('add');

    // uncomment the following code to enable ajax-based validation
   
    if(isset($_POST['ajax']) && $_POST['ajax']==='Client')
    {
        echo CActiveForm::validate($model);
        Yii::app()->end();
    }
    

    if(isset($_POST['Client']))
    {
        $model->attributes=$_POST['Client'];
        if($model->validate())
        {
            if($model->save()){
            Yii::app()->user->setFlash('success','Client sucessfully created');    
            $this->redirect(array('/Client/'.$model->ClientId));
            
            }
        }
    }
    $this->render('add',array('model'=>$model));
}



	public function actionRemove()
	{
		$this->render('remove');
	}

	public function actionUpdate($id)
	{       
                $model = Client::model()->findByPk($id);
		
                 if(isset($_POST['ajax']) && $_POST['ajax']==='Client')
                    {
                        echo CActiveForm::validate($model);
                       Yii::app()->end();
                    }


                    if(isset($_POST['Client']))
                    {
                        $model->attributes=$_POST['Client'];
                        if($model->validate())
                        {
                            if($model->update()){
                            Yii::app()->user->setFlash('success','Client sucessfully Updated');    
                            $this->redirect(array('/Client/'));
                             Yii::app()->end();
                            }
                        }
                    }
                    $this->render('update',array('model'=>$model));
	}

	public function actionView($id)
	{     
        
                $subscription = Subscription::getSubscriptionStatus($id);
                $ads = Ads::getAllAdsDetail($id); 
                
                
                $criteria = new CDbCriteria();
                $criteria->compare('ClientId', $id);
                $client = new CActiveDataProvider('Client',array('criteria'=>$criteria, 'pagination'=>false,));

                $this->render('view',array('client_Id'=>$id,'data_client'=>$client,'data_subscription'=>$subscription,'data_ads'=>$ads));
	}
        public function actionIndex()
	{       
                $clients = new CActiveDataProvider('Client');
		$this->render('index',array('data'=>$clients));
                
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