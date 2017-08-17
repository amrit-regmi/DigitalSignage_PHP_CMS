<?php

class AssignedController extends Controller
{     protected function beforeAction($actionObject) {
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
	public function actionAssign()
	{
		$this->render('assign');
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionRemove()
	{
		$this->render('remove');
	}

	public function actionScreen()
	{
		$this->render('screen');
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