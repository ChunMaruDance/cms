<?php
// namespace utils;

namespace utils;

class AccessoryValidator {

    public static function validateFields($post, $files) {
        $errors = [];
        if (is_null($post->name) || empty(trim($post->name))) {
            $errors[] = "Name is required.";
        }
        if (is_null($post->description) || empty(trim($post->description))) {
            $errors[] = "Description is required.";
        }
        if (is_null($post->short_description) || empty(trim($post->short_description))) {
            $errors[] = "Short description is required.";
        }
        if (is_null($post->price) || !is_numeric($post->price)) {
            $errors[] = "Price must be a numeric value.";
        }
        if (empty($files['image']['name']) && empty($post->id)) {
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
        if (is_null($post->short_description) || empty(trim($post->short_description))) {
            $errors[] = "Short description is required.";
        }
        if (is_null($post->price) || !is_numeric($post->price)) {
            $errors[] = "Price must be a numeric value.";
        }
        if (!isset($post->array['category']) || empty(trim($post->category))) {
            $errors[] = "Category is required.";
        }
        return $errors;
    }
}