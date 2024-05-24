<?php

namespace utils;

class BannerItemValidator {

    public static function validateFields($post, $files) {
        $errors = [];
        if (is_null($post->link) || empty(trim($post->link))) {
            $errors[] = "Link is required.";
        }
        if (empty($files['image']['name'])) {
            $errors[] = "Please select an image file.";
        }
        return $errors;
    }
}