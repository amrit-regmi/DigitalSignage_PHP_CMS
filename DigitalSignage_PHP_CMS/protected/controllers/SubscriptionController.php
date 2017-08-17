<?php

class SubscriptionController extends Controller
{       protected function beforeAction($actionObject) {
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
	public function actionAdd($id)
	{     
                
                $route=  Route::model()->findAll();
                $routelist=  CHtml::listData($route,'RouteId','RouteName');
                
                $model = new Subscription('create');
                  if(isset($_POST['ajax']) && $_POST['ajax']=='Subscription')
            {
                echo CActiveForm::validate($model); 
                Yii::app()->end();
                //Yii::app()->end();
            }if(isset($_POST['Subscription']))
            {
                //print_r($_POST['Ads']);
                $model->attributes=$_POST['Subscription'];
            
                if($model->validate())
                {    
                    
                   // print_r($model);
                    if($model->save())
                    {
                        Yii::app()->user->setFlash('success','Subscription sucessfully created');
                       $this->redirect(array('/Client/'.$id));
                    }
                }
           }
		$this->render('add',array('model'=>$model,'routelist'=>$routelist,'id'=>$id));
	}


	public function actionRemove()
	{
		$this->render('remove');
	}

	public function actionUpdate($id)
	{
            $route=  Route::model()->findAll();
            $routelist=  CHtml::listData($route,'RouteId','RouteName');
            $model = Subscription::model()->findByPk($id);
              if(isset($_POST['ajax']) && $_POST['ajax']=='Subscription')
            {
                echo CActiveForm::validate($model); 
                Yii::app()->end();
                //Yii::app()->end();
            }if(isset($_POST['Subscription']))
            {
                $model->attributes=$_POST['Subscription'];
                
                if($model->validate())
                {    
                    
                    //print_r($model);
                    if($model->update())
                    {
                        Yii::app()->user->setFlash('success','Subscription sucessfully updated');
                       $this->redirect(array('/Client/'.$model->ClientId));
                    }
                }
           }
            $this->render('update',array('model'=>$model,'routelist'=>$routelist));
	}

	public function actionView()
	{
		$this->render('view');
	}
        public function actionActiviate($id)
	{
               Subscription::activiate($id);
               Yii::app()->user->setFlash('success','Subscription sucessfully activiated');
                       $this->redirect(array('/Client/'.Subscription::model()->findByPk($id)->ClientId));
	}
        public function actionDeactiviate($id)
	{
            
            //$s = Screens::getClientScreens(Subscription::model()->findByPk($id)->RouteId, Subscription::model()->findByPk($id)->ClientId);
            //print_r($s);
            Subscription::deactiviate($id);
           // $this->redirect(array('/Client/'.Subscription::model()->findByPk($id)->ClientId));
           
               Yii::app()->user->setFlash('success','Subscription sucessfully deactiviated');
               $this->redirect(array('/Client/'.Subscription::model()->findByPk($id)->ClientId));
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