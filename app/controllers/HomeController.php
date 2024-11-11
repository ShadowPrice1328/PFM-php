<?php

namespace controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use services\SessionManager;

require(__DIR__ . '/../../vendor/autoload.php');

require_once(__DIR__ . '/../services/DatabaseService.php');
require_once(__DIR__ . '/../services/CategoriesService.php');
require_once(__DIR__ . '/../services/TransactionsService.php');
require_once(__DIR__ . '/../services/AuthService.php');


class HomeController
{
    public bool $authenticated;
    private $databaseService;
    private $categoriesService;
    private $transactionsService;
    private $authService;

    public function __construct($databaseService, $categoriesService, $transactionsService, $authService)
    {
        $this->databaseService = $databaseService;
        $this->categoriesService = $categoriesService;
        $this->transactionsService = $transactionsService;
        $this->authService = $authService;
    }

    public function index(): void
    {
        $username = $this->authService->getUsernameByUserId(SessionManager::getUserId());

        $viewModel = [];
        // Check database connection
        list($isConnected, $errorMessage) = $this->databaseService->canConnect();

        if ($isConnected) {
            $viewModel['connectionStatus'] = 'Connected to database!';
            $viewModel['categories'] = $this->categoriesService->getCategories();
            $viewModel['transactions'] = $this->transactionsService->getTransactions();
        } else {
            $viewModel['connectionStatus'] = 'Connection error!';
            $viewModel['errorMessage'] = $errorMessage;
        }

        $logDir = __DIR__ . '/../logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0775, true);
        }
        file_put_contents($logDir . '/debug.log', print_r($viewModel, true), FILE_APPEND);

        // Pass data to the view
        include_once(__DIR__ . '/../views/home/index.php');
    }

    public function contact(): void
    {
        include_once(__DIR__ . '/../views/home/contact.php');
    }

    public function sendEmail(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars(trim($_POST['name']));
            $email = htmlspecialchars(trim($_POST['email']));
            $phone = htmlspecialchars(trim($_POST['phone']));
            $message = htmlspecialchars(trim($_POST['message']));

            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($_ENV['MAIL_SETFROM_ADDRESS'], $_ENV['MAIL_SETFROM_NAME']);
            $mail->addReplyTo($email, $name);

            $mail->addAddress($_ENV['MAIL_ADDADDRESS']);

            $mail->isHTML(true);
            $mail->Subject = 'Email from PFM user';

            $mail->Body = $message . '<br><br>'. $phone . '<br>' . $email;

            if(!$mail->send())
            {
                echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }
            else
            {
                echo "<small>Thank you, $name! <br> We have received your message and will get back to you soon.</small>";
            }
        }
    }
}