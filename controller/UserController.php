<?php
require_once 'config/db_connection.php';
require_once 'model/UserModel.php';

class UserController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new UserModel($db);
    }

    public function profile()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();


        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';

        $user = $this->model->getUserById($userId, $role);

        $userData = [
            'is_logged_in' => true,
            'initial' => isset($_SESSION['login_user']) ? strtoupper(substr($_SESSION['login_user'], 0, 1)) : 'U'
        ];

        require_once 'view/profile.php';
    }



    public function edit()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';

        $user = $this->model->getUserById($userId, $role);

        $userData = [
            'is_logged_in' => true,
            'initial' => isset($_SESSION['login_user']) ? strtoupper(substr($_SESSION['login_user'], 0, 1)) : 'U'
        ];

        require_once 'view/edit_profile.php';
    }

    // 2. Process the Update
    public function update()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';

            // 1. Get Data
            $name = trim($_POST['first_name']); // This is your "Full Name"
            $email = trim($_POST['email']);
            $address = trim($_POST['address']);
            $phone = trim($_POST['phone']);      // Matches name="phone" in the form

            $certNumber = isset($_POST['certificate_number']) ? trim($_POST['certificate_number']) : '';

            // 2. Update via Model
            $success = false;

            if ($role === 'farmer') {
                // Ensure your UserModel function accepts arguments in this EXACT order
                $success = $this->model->updateFarmer($userId, $name, $email, $phone, $address, $certNumber);
            } else {
                $success = $this->model->updateUser($userId, $name, $email, $phone, $address);
            }

            if ($success) {
                $_SESSION['login_user'] = $name;
                header("Location: index.php?page=profile&success=1");
                exit();
            } else {
                echo "Update failed.";
            }
        }
    }
}
?>