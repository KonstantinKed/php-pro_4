<?php

class Email {
    public function __construct(protected string $email)
    {
        EmailValidator::validateEmail($email);
    }
    public function getEmail(): string
    {
        return $this->email;
    }
}
class EmailValidator {
    public static function validateEmail(string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email is not valid');
        }
    }
}
class EmailSender {
    public function __construct(protected Email $email) {}
    public function sendEmail(string $subj, string $message) {
        return (mail($this->email->getEmail(), $subj, $message));
    }
}

$emailObj = new Email('ex@gmail.com');
$sender = new EmailSender($emailObj);

if ($sender->sendEmail('Greetings', 'Hello bacon')) {
    echo "sent to email: " . $emailObj->getEmail();
} else {
    echo "Sending failed";
}


echo PHP_EOL;

echo '===== END PROGRAM =====';

echo PHP_EOL;
