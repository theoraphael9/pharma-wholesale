<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_repeat = '';
    public string $company_name = '';
    public string $phone = '';
    public string $address = '';

    public function rules(): array
    {
        return [
            // required fields
            [['username', 'email', 'password', 'password_repeat'], 'required'],
            // string limits
            ['username', 'string', 'min' => 3, 'max' => 50],
            ['email', 'string', 'max' => 100],
            ['company_name', 'string', 'max' => 100],
            ['phone', 'string', 'max' => 20],
            // email format
            ['email', 'email'],
            // unique checks
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username is already taken.'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email is already registered.'],
            // password repeat
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],
            // password length
            ['password', 'string', 'min' => 6],
            // optional fields
            [['address'], 'string'],
            [['company_name', 'phone', 'address'], 'default', 'value' => ''],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username'        => 'Username',
            'email'           => 'Email Address',
            'password'        => 'Password',
            'password_repeat' => 'Confirm Password',
            'company_name'    => 'Company Name',
            'phone'           => 'Phone Number',
            'address'         => 'Delivery Address',
        ];
    }

    public function signup(): User|null
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username     = $this->username;
        $user->email        = $this->email;
        $user->company_name = $this->company_name;
        $user->phone        = $this->phone;
        $user->address      = $this->address;
        $user->role         = User::ROLE_CUSTOMER;
        $user->status       = User::STATUS_ACTIVE;
        $user->setPassword($this->password);

        return $user->save() ? $user : null;
    }
}