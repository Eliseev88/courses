<?php

namespace MyApp\Controllers;

use MyApp\Basket;
use MyApp\Models\Users;
use MyApp\Models\History;
use MyApp\Models\Orders;

class AccountController extends Controller
{
    public function actionIndex()
    {
        if (isset($_SESSION['user'])) {

            $userHistory = History::getUserHistory($_SESSION['user']['id']);

            $this->render('account/account.twig', [
                'user' => $_SESSION['user'],
                'history' => $userHistory,
            ]);

        } elseif (isset($_COOKIE["cookie_token"]) && !empty($_COOKIE["cookie_token"])) {
            $userData = Users::getUserCookie($_COOKIE["cookie_token"]);
            if (!empty($userData)) {
                $_SESSION['user'] = [
					"id" => $userData[0]['id_user'],
					"login" => $userData[0]['login'],
					"name" => $userData[0]['name'],
					"email" => $userData[0]['email']
                ];
                $this->render('/account/account.twig', [
                    'user' => $_SESSION['user'],
                ]);
            } else {
                $this->redirect('/signin');
            }
        } else {
            $this->redirect('/signin');
        }
    }

    // Метод отображения корзины
    public function actionBasket()
    {
        $basket = Basket::getAllBasketGoods();

        $this->render('account/basket.twig', [
            'sum' => $basket['sum'],
            'goods' => $basket['goods'],
        ]);
    }

    // Метод очистки корзины
    public function actionClear()
    {
        Basket::clear();

        $this->redirect('/basket');
    }

    // Метод заказа
    public function actionOrder()
    {
        $basket = Basket::get();

        if (!$basket['count']) {
            $this->redirect('/catalog');
        } else if (!$_SESSION['user']) {
            $this->redirect("/signin");
        }

        $orderId = Orders::add($_SESSION['user']['id'], $basket['goods']);
        Basket::clear();

        $this->render('account/order.twig', [
            'orderId' => $orderId
        ]);
    }

    // Метод авторизации
    public function actionSignin()
    {
        $userLogin = $_POST['user_login'];
        $userPass = $_POST['user_pass'];
        $rememberMe = $_POST['remember_me'];

        if (!empty($userLogin) && !empty($userPass)) {
            Users::authorizeUser($userLogin, $userPass, $rememberMe);
            
            $this->redirect('/account');
        }

        $this->render('account/signin.twig', [
            'msg' => $_SESSION['msg']
        ]);

        unset($_SESSION['msg']);
    }

    // Метод выхода из учетной записи
    public function actionLogout()
    {
        if (isset($_COOKIE['cookie_token'])) {
            Users::deleteUserCookie($_SESSION['user']['id']);
            setcookie("cookie_token", "", time() - 3600, '/');
            unset($_SESSION['user']);
            Basket::clear();
            $this->redirect('/index');
        } else {
            Basket::clear();
            unset($_SESSION['user']);
            $this->redirect('/index');
        }
    }

    // Метод регистрации
    public function actionSignup()
    {
        $userName = trim($_POST['user_name']);
        $userLogin = trim($_POST['user_login']);
        $userEmail = trim($_POST['user_email']);
        $userPass = trim($_POST['user_pass']);
        $passConfirm = trim($_POST['user_confirm_pass']);

        if 
        (
            !empty($userName) && 
            !empty($userLogin) && 
            !empty($userEmail) && 
            !empty($userPass) && 
            !empty($passConfirm)
        ) {
            Users::addNewUser($userName, $userLogin, $userEmail, $userPass, $passConfirm);
        }

        $this->render('account/signup.twig', [
            'msg' => $_SESSION['msg'],
            'temp' => [
                'name' => $_SESSION['user_name'],
                'login' => $_SESSION['user_login'],
                'email' => $_SESSION['user_mail'],
            ],
        ]);

    }
}
