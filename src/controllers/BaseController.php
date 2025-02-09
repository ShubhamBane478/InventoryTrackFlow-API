///A base controller that provides helper methods for sending responses.

<?php
// controller/BaseController.php

/**
 * BaseController class
 * Provides common functionalities for all controllers.
 */
class BaseController {
    /**
     * Send a JSON response to the client.
     *
     * @param mixed $data Data to send as JSON.
     * @param int $status HTTP status code (default is 200).
     */
    protected function response($data, $status = 200) {
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    /**
     * Send an error response in JSON format.
     *
     * @param string $message Error message.
     * @param int $status HTTP status code (default is 400).
     */
    protected function errorResponse($message, $status = 400) {
        $this->response(['error' => $message], $status);
    }
}
