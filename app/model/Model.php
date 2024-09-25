<?php

class Model {

    protected function sanitize($data) {

        // Remove whitespace
        $data = trim($data);

        // Remove HTML tags
        $data = strip_tags($data);

        // Convert to HTML entities to prevent XSS attacks
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

        return $data;
    }

    protected function validate($data, array $rules): bool {
        foreach ($rules as $field => $fieldRules) {

            // Check min_length
            if (isset($fieldRules['min_length']) && strlen($data[$field]) < $fieldRules['min_length']) {
                return false;
            }

            // Check max_length
            if (isset($fieldRules['max_length']) && strlen($data[$field]) > $fieldRules['max_length']) {
                return false;
            }

            // Check if the value should be numeric
            if (isset($fieldRules['numeric']) && $fieldRules['numeric'] && !is_numeric($data[$field])) {
                return false;
            }

            // Check regex pattern
            if (isset($fieldRules['regex']) && !preg_match($fieldRules['regex'], $data[$field])) {
                return false;
            }
        }

        return true;
    }
}
