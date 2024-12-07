<?php
// Define the PHP_Email_Form class
class PHP_Email_Form {
    
    public $to = '';
    public $from_name = '';
    public $from_email = '';
    public $subject = '';
    public $messages = [];
    public $ajax = false;
    public $smtp = null;

    // Method to add message to the form
    public function add_message($message, $title, $length = 0) {
        $this->messages[] = [
            'title' => $title,
            'message' => $message,
            'length' => $length
        ];
    }

    // Method to send the email
    public function send() {
        print_r($this->to); die;
        // Check if SMTP settings are provided
        if ($this->smtp) {
           
            $headers = array(
                'From' => $this->from_email,
                'Reply-To' => $this->from_email,
                'Content-Type' => 'text/html; charset=UTF-8'
            );

            // Check if we are using SMTP
            if ($this->smtp) {
                $smtp_host = $this->smtp['host'];
                $smtp_username = $this->smtp['username'];
                $smtp_password = $this->smtp['password'];
                $smtp_port = $this->smtp['port'];

                // Using PHPMailer or another SMTP handler is recommended here
                // (Implement SMTP handling if needed, this is just a simple example)
            }
        } else {
            // Default email send using PHP's mail function
            $to = $this->to;
            $subject = $this->subject;
            $message = '';

            // Construct the message body
            foreach ($this->messages as $msg) {
                $message .= "<strong>" . $msg['title'] . ":</strong><br>";
                $message .= nl2br(htmlspecialchars($msg['message'])) . "<br><br>";
            }

            // Set headers
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
            $headers .= "From: " . $this->from_email . "\r\n";
            $headers .= "Reply-To: " . $this->from_email . "\r\n";

            // Send the email
            if(mail($to, $subject, $message, $headers)) {
                return json_encode(['success' => true]);
            } else {
                return json_encode(['success' => false, 'message' => 'Failed to send email']);
            }
        }
    }
}
?>
