<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $name
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
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

    public function getData($params = array())
    {
        if(isset($params['users']) && !empty($params['users']))
        {
            $conditions['user'] = 'u.id IN ('. join(',', (array)$params['users']) .')';
        }

        if(isset($params['cities']) && !empty($params['cities']))
        {

            $conditions[] = 'ci.id IN ('. join(',', (array)$params['cities']) .')';
        }

        if(isset($params['education']) && !empty($params['education']))
        {

            $conditions[] = 'e.id IN ('. join(',', (array)$params['education']) .')';
        }

        if ($params)
        {
            $condition = join(' AND ', $conditions);
        }

//        $sql = 'SELECT  u.name, ci.title as cityTitle, e.title as educationTitle FROM users as u
//                                    JOIN usersCities as uc ON u.id = uc.city_id
//                                    JOIN cities as ci ON u.id = ci.id
//                                    JOIN usersEducations as ue ON u.id = ue.education_id
//                                    JOIN educations as e ON u.id = e.id
//                                    WHERE u.id IN (1,4) AND ci.id IN (1) AND e.id IN (1)';
//

        $user = Yii::app()->db->createCommand()
            ->select('u.name, ci.title as cityTitle, e.title as educationTitle')
            ->from('users u')
            ->join('usersCities uc','u.id = uc.user_id')
            ->join('cities ci', 'uc.city_id = ci.id')
            ->join('usersEducations ue', 'u.id = ue.user_id')
            ->join('educations e', 'ue.education_id = e.id')
            ->where($condition)
//            ->where('ci.id IN (2) AND e.id IN (2,3)')
//            ->where(':id AND e.id IN (2,3)', array(':id' => $conditions['user'] ))
//            ->where('uid=:id OR uid=0', array(':id'=>$this->params['uid']))
            ->queryAll();

        return $user;
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getUsers()
    {
        return Users::model()->findAll();
//        return Yii::app()->db->createCommand("SELECT * FROM users")->queryAll();
    }

}
