<?php

class UsersController extends Controller
{
	protected function beforeAction($actionObject) {
            $id = Yii::app()->getRequest()->getQuery('id');
            $action = $actionObject->getId();
            if((!Users::checkLogin()) && $action != 'validateKey'){
                 $this->redirect(array('/site'));
                if(!isset($_GET['ajax'])){
                    $this->redirect(array('/site/index'));
                }
                return false;
        }elseif(($action == 'reset' || $action == 'update' || $action == 'delete' || $action == 'disable' || $action == 'enable') && !Users::isSuperAdmin() ){
                Yii::app()->user->setFlash('error','You don\'t have enough permission to perfom this action');
                 $this->redirect(array('/site'));    
            
        }elseif(($action == 'delete' || $action == 'disable') && Users::isSuperAdmin($id)){
                Yii::app()->user->setFlash('error','You can\'t delete/disable the super admin');
                 $this->redirect(array('/site'));    
            
        }else{
            return parent::beforeAction($actionObject);
            
        }    
        
        }
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd()
	{
		$model=new Users('create');

		// Uncomment the following line if AJAX validation is needed

		if(isset($_POST['ajax']) && $_POST['ajax']=='Users')
            {
                echo CActiveForm::validate($model); 
                Yii::app()->end();
                //Yii::app()->end();
            }if(isset($_POST['Users']))
            {
                //print_r($_POST['Ads']);
                $model->attributes=$_POST['Users'];
                $model->ActivationCode = sha1(mt_rand(10000, 99999).time().$model->email);
                $activation_url = $this->createAbsoluteUrl('Users/validateKey', array('key'=>$model->ActivationCode));
                if($model->validate())
                {    
                    if($model->save())
                    { 
                        Yii::app()->user->setFlash('success','User sucessfully created and activation link has been sent to '.$model->email);
                        $this->redirect($activation_url);
                    }
                }
           }
           $this->render('create',array(
			'model'=>$model,
		));
	}
        
        public function actionValidateKey(){
            if(isset( $_GET['key'])){
                $key= $_GET['key'];
            }
            if(Users::validateActivationKey($key)){
                   $model = Users::model()->findByAttributes(array('ActivationCode' => $key));
                   $model->setScenario('register');
                   if(isset($_POST['ajax']) && $_POST['ajax']=='Users_manage')
                {
                echo CActiveForm::validate($model); 
                Yii::app()->end();
                //Yii::app()->end();
                }if(isset($_POST['Users']))
                {
                //print_r($_POST['Ads']);
                $model->attributes=$_POST['Users'];
                $model->Active = 1;
                if($model->validate())
                {    
                    if($model->update(array('username','password','salt','Active')))
                    { 
                        Yii::app()->user->setFlash('success','Update sucessfull, Please login now');
                        $this->redirect(array('/site/index'));
                    }
                }else{
                     echo CActiveForm::validate($model);
                     Yii::app()->end();
                }
                
                        
                }
                   
                   $this->render('manage',array('model'=>$model));
                }else{
                     $this->redirect(array('/site/index'));
                }
            }
            
       

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model= Users::model()->findByPk($id);

		if(isset($_POST['ajax']) && $_POST['ajax']=='Users')
            {
                echo CActiveForm::validate($model); 
                Yii::app()->end();
                //Yii::app()->end();
            }

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			if($model->validate()){
                                if($model->update(array('firstname','lastname','phone','email','accesslevel'))){
                                Yii::app()->user->setFlash('success','User sucessfully updated');
				$this->redirect(array('index'));
                                Yii::app()->end();
                                }
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model= Users::model()->findByPk($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        public function actionDisable($id)
	{
		$model= Users::model()->findByPk($id);
                $model->deleted = 1;
                $model->save();
                Yii::app()->user->setFlash('success','This user has been Disabled');
                $this->redirect(array('Users/update/'.$model->uid));
	}
         public function actionEnable($id)
	{
		$model= Users::model()->findByPk($id);
                $model->deleted = 0;
                $model->save();
                Yii::app()->user->setFlash('success','This user has been enabled');
                $this->redirect(array('Users/update/'.$model->uid));
	}
        public function actionReset($id)
	{
		$model= Users::model()->findByPk($id);
                $model->ActivationCode = sha1(mt_rand(10000, 99999).time().$model->email);
                $model->ActivationTime = date("Y-m-d H:i:s");
                $model->Active=0;
                if($model->validate()){
                    $model->save(); 
                    $activation_url = $this->createAbsoluteUrl('Users/validateKey', array('key'=>$model->ActivationCode));
                    Yii::app()->user->setFlash('success','The reset code has been sent to '.$model->email);
                    $this->redirect(array('Users/update/'.$model->uid));
                }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Users');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
        
}
