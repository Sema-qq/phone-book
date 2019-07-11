<?php


namespace models;


use models\traits\validators\ContactValidate;
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
    use ContactValidate;

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
     * @param array $sort сортировка
     * @return Contact[]|array
     */
    public static function getAllContactsByUser($userId, array $sort = [])
    {
        return self::find()->where(['USER_ID' => $userId])->sort($sort)->all();
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
            [['FIRST_NAME', 'PHONE'], 'validateRequired'],
            [['FIRST_NAME', 'LAST_NAME'], 'validateName'],
            [['PHONE'], 'validatePhone'],
            [['EMAIL'], 'validateEmail']
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

    public function saveImage($filename)
    {
        if ($filename) {
            $this->PHOTO = $filename;
            return $this->save(false);
        }
        return false;
    }
}
