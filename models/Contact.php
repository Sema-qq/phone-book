<?php


namespace models;


use system\instruments\DbModel;

/**
 * Контакт
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

    public function validateRules()
    {
        return [

        ];
    }
}
