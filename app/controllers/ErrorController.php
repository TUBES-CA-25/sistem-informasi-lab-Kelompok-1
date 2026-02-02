<?php
/**
 * ICLABS - Error Controller
 * Handles error page rendering
 */

class ErrorController extends Controller
{
    /**
     * Error messages mapping
     */
    private $errorMessages = [
        400 => [
            'title' => 'Bad Request',
            'message' => 'Permintaan Anda tidak dapat diproses. Periksa kembali data yang Anda kirimkan.'
        ],
        401 => [
            'title' => 'Unauthorized',
            'message' => 'Anda harus login terlebih dahulu untuk mengakses halaman ini.'
        ],
        403 => [
            'title' => 'Forbidden',
            'message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.'
        ],
        404 => [
            'title' => 'Not Found',
            'message' => 'Halaman yang Anda cari tidak ditemukan.'
        ],
        408 => [
            'title' => 'Request Timeout',
            'message' => 'Permintaan Anda memakan waktu terlalu lama. Silakan coba lagi.'
        ],
        500 => [
            'title' => 'Internal Server Error',
            'message' => 'Terjadi kesalahan pada server. Tim kami sedang memperbaikinya.'
        ],
        502 => [
            'title' => 'Bad Gateway',
            'message' => 'Server tidak dapat terhubung ke layanan yang diperlukan.'
        ],
        503 => [
            'title' => 'Service Unavailable',
            'message' => 'Layanan sedang dalam pemeliharaan. Silakan coba beberapa saat lagi.'
        ],
        504 => [
            'title' => 'Gateway Timeout',
            'message' => 'Server membutuhkan waktu terlalu lama untuk merespons.'
        ]
    ];

    /**
     * Render error page
     * 
     * @param int $code HTTP error code
     * @param string|null $customMessage Custom error message (optional)
     */
    public function render($code = 404, $customMessage = null)
    {
        // Set HTTP response code
        http_response_code($code);

        // Get error details
        $errorInfo = $this->errorMessages[$code] ?? $this->errorMessages[500];
        
        // Override with custom message if provided
        if ($customMessage) {
            $errorInfo['message'] = $customMessage;
        }

        // Prepare data for view
        $data = [
            'code' => $code,
            'title' => $errorInfo['title'],
            'message' => $errorInfo['message'],
            'isLoggedIn' => isLoggedIn(),
            'userRole' => getUserRole()
        ];

        // Check if custom error view exists
        $errorView = APP_PATH . '/views/errors/' . $code . '.php';
        
        if (file_exists($errorView)) {
            $this->view('errors/' . $code, $data);
        } else {
            // Fallback to generic error page
            $this->view('errors/500', $data);
        }
    }

    /**
     * Shortcut methods for common errors
     */
    public function notFound($message = null)
    {
        $this->render(404, $message);
    }

    public function forbidden($message = null)
    {
        $this->render(403, $message);
    }

    public function unauthorized($message = null)
    {
        $this->render(401, $message);
    }

    public function badRequest($message = null)
    {
        $this->render(400, $message);
    }

    public function serverError($message = null)
    {
        $this->render(500, $message);
    }
}
