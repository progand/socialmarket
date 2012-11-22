<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 */
class User extends CActiveRecord
{
	// Сценарий регистрации
	const SCENARIO_SIGNUP = 'signup';

	// Повторный пароль нужно объявить, т.к. этого поля нет в БД
	public $password_repeat;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('username, password, email', 'required'),
				array('password, email', 'length', 'max'=>128),
				// Длина логина должна быть в пределах от 5 до 30 символов
				array('username', 'length', 'min'=>5, 'max'=>30),
				// Логин должен соответствовать шаблону
				array('username', 'match', 'pattern'=>'/^[A-z][\w]+$/'),
				// Логин должен быть уникальным
				array('username', 'unique'),
				array('password', 'length', 'min'=>6, 'max'=>30),
				// Повторный пароль и почта обязательны для сценария регистрации
				array('password_repeat, email', 'required', 'on'=>self::SCENARIO_SIGNUP),
				// Длина повторного пароля не менее 6 символов
				array('password_repeat', 'length', 'min'=>6, 'max'=>30),
				// Пароль должен совпадать с повторным паролем для сценария регистрации
				array('password', 'compare', 'compareAttribute'=>'password_repeat', 'on'=>self::SCENARIO_SIGNUP),
				// Почта проверяется на соответствие типу
				array('email', 'email', 'on'=>self::SCENARIO_SIGNUP),
				// Почта должна быть в пределах от 6 до 50 символов
				array('email', 'length', 'min'=>6, 'max'=>50),
				// Почта должна быть уникальной
				array('email', 'unique'),
				// Почта должна быть написана в нижнем регистре
				array('email', 'filter', 'filter'=>'mb_strtolower'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, username, password, email', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(				
				'username' => 'Username',
				'password' => 'Password',
				'password_repeat' => 'Repeat password',
				'email' => 'Email',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	public function validatePassword($password)
	{
		return $password===$this->password;
	}
}