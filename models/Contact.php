<?php


namespace models;


use system\instruments\DbModel;

class Contact extends DbModel
{
    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'contacts';
    }

    /**
     * @inheritdoc
     */
    function primaryKey()
    {
        return 'ID';
    }
}
