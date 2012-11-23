<?php

class RegisterController extends Controller
{
	public function actionCustomer()
	{
		// ���� ������ ������ ��� ����������
		if(isset($_POST['user']))
		{
			// ������� ������ � ������� ��, ��� ������������ �������� �����������
			$user = new User(User::SCENARIO_SIGNUP);
			$customer = new Customer();
			
			// ���������� ������������ �������� ���������
			$user->attributes = $_POST['user'];
			$customer->attributes = $_POST['customer'];
		
			// �������� ������
			if($user->validate())
			{
				// ��������� ���������� ������
				// false ����� ��� ����, ����� �� ����������� ��������� ��������
				$user->save(false);		
				$customer->user_id = $user->id;
				$customer->save();
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