<?php


namespace models;


use system\core\DbModel;

/**
 * Контакт
 *
 * @property int $ID
 * @property int $USER_ID
 * @property string $FIRST_NAME
 * @property string $LAST_NAME
 * @property string $PHONE
 * @property string $EMAIL
 * @property string $PHOTO
 *
 * @property User $user
 */
class Contact extends DbModel
{
    /** @var int primaryKey */
    public $ID;
    /** @var int fk_users.id */
    public $USER_ID;
    /** @var string Имя контакта */
    public $FIRST_NAME;
    /** @var string Фамилия контакта */
    public $LAST_NAME;
    /** @var string Телефон контакта */
    public $PHONE;
    /** @var string Электронная почта контакта */
    public $EMAIL;
    /** @var string Фото контакта */
    public $PHOTO;

    /**
     * Возвращает все контакты принадлежащие пользователю
     * @param int $userId Ид пользователя
     * @return Contact[]|array
     */
    public static function getAllContactsByUser($userId)
    {
        return self::find()->where(['USER_ID' => $userId])->all();
    }


    /** @inheritDoc */
    public function getTable()
    {
        return 'contacts';
    }

    /** @inheritDoc */
    public function primaryKey()
    {
        return 'ID';
    }

    /** @inheritDoc */
    public function fields()
    {
        return [
            'ID',
            'USER_ID',
            'FIRST_NAME',
            'LAST_NAME',
            'PHONE',
            'EMAIL',
            'PHOTO'
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'FIRST_NAME' => 'Имя',
            'LAST_NAME' => 'Фамилия',
            'PHONE' => 'Телефон',
            'EMAIL' => 'Электронная почта',
            'PHOTO' => 'Фотография'
        ];
    }

    /** @inheritdoc */
    public function validateRules()
    {
        return [
            [['PHONE'], 'validateRequired'],
            [['FIRST_NAME', 'LAST_NAME'], 'validateName'],
            [['PHONE'], 'validatePhone'],
            [['EMAIL'], 'validateEmail'],
            [['PHOTO'], 'validatePhoto']
        ];
    }

    /**
     * Возвращает пользователя, которому принадлежит контакт
     * @return null|DbModel
     */
    public function getUser()
    {
        return User::findOne($this->USER_ID);
    }
}
