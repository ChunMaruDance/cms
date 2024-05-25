<?php

namespace utils;

class FeedbackValidator {

    public static function validateFields($post) {
        $errors = [];

        if (is_null($post->name) || empty(trim($post->name))) {
            $errors[] = "Name is required and cannot consist solely of spaces.";
        }

        if (is_null($post->email) || empty(trim($post->email))) {
            $errors[] = "Email is required and cannot consist solely of spaces.";
        } elseif (!filter_var($post->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if (is_null($post->message) || empty(trim($post->message))) {
            $errors[] = "Message is required and cannot consist solely of spaces.";
        }

        return $errors;
    }
}
