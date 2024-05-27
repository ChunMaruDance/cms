<?php
// namespace utils;

namespace utils;

class OrderValidator
{
    public static function validate($email, $name, $phone, $payment_method, $post_office)
    {
        $errors = [];

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Некоректна електронна пошта';
        }

        if (empty(trim($name))) {
            $errors[] = 'Ім\'я не може бути порожнім';
        }

        if (empty($phone) || !preg_match('/^\+?[0-9\s\-]{7,15}$/', $phone)) {
            $errors[] = 'Некоректний номер телефону';
        }

        if (empty(trim($post_office))) {
            $errors[] = 'Спосіб оплати не може бути порожнім';
        }


        return $errors;
    }
}
