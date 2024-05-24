<?php
// namespace utils;

namespace utils;

class CategoryValidator {

    public static function validateFields($post, $files) {
        $errors = [];
        if (is_null($post->name) || empty(trim($post->name))) {
            $errors[] = "Name is required.";
        }
        if (is_null($post->description) || empty(trim($post->description))) {
            $errors[] = "Description is required.";
        }
        if (empty($files['image']['name'])) {
            $errors[] = "Please select an image file.";
        }
        return $errors;
    }

    public static function validateFieldsWithoutImage($post) {
        $errors = [];
        if (is_null($post->name) || empty(trim($post->name))) {
            $errors[] = "Name is required.";
        }
        if (is_null($post->description) || empty(trim($post->description))) {
            $errors[] = "Description is required.";
        }
        return $errors;
    }
}