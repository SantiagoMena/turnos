<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $nombre;
    public $email;
    public $mensaje;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['nombre', 'email'], 'required'],
            [['mensaje'], 'string'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            // 'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact()
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo(Yii::$app->params['contactEmail'])
                ->setFrom(['citas@integrarips.com' => 'Nuevo Contacto Web'])
                ->setSubject('Nuevo Contacto Web')
                ->setHtmlBody("Nuevo Contacto<br>Nombre: $this->nombre<br>Email: $this->email<br>Mensaje: $this->mensaje")
                ->send();

            return true;
        }
        return false;
    }
}
