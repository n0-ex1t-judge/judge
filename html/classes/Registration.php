<?php

/**
 * handles the user registration
 * @author Panique <panique@web.de>
 */
class Registration
{
    // database connection
    private $db_connection = null;
    private $user_name = "";
    private $user_email = "";
    private $user_password = "";
    private $user_password_hash = "";

    public $registration_successful = false;
    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {

        if (isset($_POST["register"])) {

            $this->registerNewUser();

        }
    }

    /**
     * handles the entire registration process. checks all error possibilities, and creates a new user in the database if
     * everything is fine
     */
    private function registerNewUser()
    {

        if (empty($_POST['user_name'])) {

            $this->errors[] = "Трябва да въведете потребителско име!";

        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {

            $this->errors[] = "Трябва да въведете парола!";

        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {

            $this->errors[] = "Двете въведени пароли се различават!";

        } elseif (strlen($_POST['user_password_new']) < 6) {

            $this->errors[] = "Паролата трябва да се състои от поне 6 символа!";

        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {

            $this->errors[] = "Потребителското име не може да е по-късо от 2 символа или по-дълго от 64 символа!";

        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {

            $this->errors[] = "Въведеното потребителско име не отговаря на изискванията: допускат се само символите a-Z и числа 0-9d, общо от 2 до 64 символа!";

        } elseif (empty($_POST['user_email'])) {

            $this->errors[] = "Трябва да въведете email!";

        } elseif (strlen($_POST['user_email']) > 64) {

            $this->errors[] = "Email-ът Ви не може да има повече от 64 символа!";

        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {

            $this->errors[] = "Въведеният email адрес не е валиден!";

        } elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {

            // TODO: the above check is redundant, but from a developer's perspective it makes clear
            // what exactly we want to reach to go into this if-block

            // creating a database connection
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escapin' this, additionally removing everything that could be (html/javascript-) code
                $this->user_name = $this->db_connection->real_escape_string(htmlentities($_POST['user_name'], ENT_QUOTES));
                $this->user_email = $this->db_connection->real_escape_string(htmlentities($_POST['user_email'], ENT_QUOTES));

                $this->user_password = $_POST['user_password_new'];

                // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
                // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
                // compatibility library                
                $this->user_password_hash = crypt($this->user_password, "vladi");

                // check if user already exists
                $query_check_user_name = $this->db_connection->query("SELECT * FROM users WHERE user_name = '" . $this->user_name . "';");

                if ($query_check_user_name->num_rows == 1) {

                    $this->errors[] = "Въведеното потребителко име е заето. Моля изберете си друго.";

                } else {

                    // write new users data into database
                    $query_new_user_insert = $this->db_connection->query("INSERT INTO users (user_name, user_password_hash, user_email) VALUES('" . $this->user_name . "', '" . $this->user_password_hash . "', '" . $this->user_email . "');");

                    if ($query_new_user_insert) {

                        $this->messages[] = "Регистрирахте се успешно.";
                        $this->registration_successful = true;

                    } else {

                        $this->errors[] = "Вашата регистрация е неуспешна. Моля опитайте отново.";

                    }
                }

            } else {

                $this->errors[] = "Няма връзка с базата данни.";

            }

        } else {

            $this->errors[] = "Нямам идея какво стана.";

        }

    }

}
