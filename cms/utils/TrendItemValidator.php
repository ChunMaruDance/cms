<?php

namespace utils;

class TrendItemValidator {

    public static function validateFields($post, $files) {
        $errors = [];
        if (is_null($post->title) || empty(trim($post->title))) {
            $errors[] = "Title is required.";
        }
        if (is_null($post->text) || empty(trim($post->text))) {
            $errors[] = "Text is required.";
        }
        if (is_null($post->link) || empty(trim($post->link))) {
            $errors[] = "Link is required.";
        }
        if (empty($files['image']['name'])) {
            $errors[] = "Please select an image file.";
        }
        return $errors;
    }
}