<?php

class RegisterController extends Controller
{
	public function actionCustomer()
	{
		// ������� ������ � ������� ��, ��� ������������ �������� �����������
		$user = new User(User::SCENARIO_SIGNUP);
		
		// ���� ������ ������ ��� ����������
		if(isset($_POST['User']))
		{
			// ���������� ������������ �������� ���������
			$user->attributes = $_POST['User'];
		
			// �������� ������
			if($user->validate())
			{
				// ��������� ���������� ������
				// false ����� ��� ����, ����� �� ����������� ��������� ��������
				$user->save(false);
		
				// ������������� �� ������ ������������������ �������������
				$this->redirect($this->createUrl('site/'));
			}
		}
		
		// ������� �����
		$this->render('customer');
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionSupplier()
	{
		$this->render('supplier');
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