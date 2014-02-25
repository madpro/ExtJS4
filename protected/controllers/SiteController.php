<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

    public function actionGetUser()
    {
        $users = Users::model()->getUsers();

//        var_dump($users);
        $result = array();
        foreach ($users as $user)
        {
            $result[] = array( 'boxLabel' => $user['name'], 'name' => 'users', 'inputValue' => $user['id']);
        }
        echo CJSON::encode($result);
        exit;
    }

    public function actionGetEducation()
    {
        $educations = Educations::model()->getEducations();

        $result = array();
        foreach ($educations as $education)
        {
            $result[] = array( 'boxLabel' => $education['title'], 'name' => 'education', 'inputValue' => $education['id']);
        }
        echo CJSON::encode($result);
        exit;
    }

    public function actionGetCities()
    {
        $cities = Cities::model()->getCities();

        $result = array();
        foreach ($cities as $city)
        {
            $result[] = array( 'boxLabel' => $city['title'], 'name' => 'cities', 'inputValue' => $city['id']);
        }
        echo CJSON::encode($result);
        exit;
    }

    public function actionGetData()
    {
        $request = Yii::app()->request->getParam('data', array());
        $params = $request ? CJSON::decode($request): array();

        $users = Users::model()->getData($params);
        echo CJSON::encode($users);
        exit;
    }
}