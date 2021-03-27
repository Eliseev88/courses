<?php

namespace MyApp\Models;

class Users extends Model
{
    const ROLE_ADMIN = 1;
    const ROLE_CONTENT = 2;
    const ROLE_USER = 3;

    const TABLE = 'users';
    const TABLE_ROLES = 'users_roles';

    // Метод получения куки
    public static function getUserCookie($userCookieToken)
    {
        return self::db()->getCookie(self::TABLE, $userCookieToken);
    }

    // Метод удаления куки
    public static function deleteUserCookie($userId)
    {
        $stmt = self::link()->prepare('UPDATE ' . self::TABLE . " SET cookie_token = '' WHERE id_user = :userId ");
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $stmt->execute();
    }

    // Метод добавления куки
    public static function addUserCookie($cookieToken, $userLogin)
    {
        $stmt = self::link()->prepare('UPDATE ' . self::TABLE . 
                                " SET cookie_token = :cookieToken WHERE login = :userLogin ");
        $stmt->bindParam(':cookieToken', $cookieToken, \PDO::PARAM_STR);
        $stmt->bindParam(':userLogin', $userLogin, \PDO::PARAM_STR);
        $stmt->execute();
    }

    // Метод авторизации
    public static function authorizeUser($userLogin, $userPass, $rememberMe)
    {
        if (!empty($user = self::db()->getUser(self::TABLE, $userLogin))) {
            // Сравниваем хэши паролей
            $dbPassHash = $user[0]['password'];
            if (password_verify($userPass, $dbPassHash)) {
                // Если стоит галочка "запомнить меня"
				if(isset($rememberMe)){
					// Создаем токен
					$cookieToken = md5($user[0]['id_user'].time());
                    // Добавляем созданный токен в базу данных
                    self::addUserCookie($cookieToken, $userLogin);
					// Создаем локальный куки
					setcookie('cookie_token', $cookieToken, 
								time() + 60 * 60 * 24 * 7, '/');
				} else {
					// Если галочка "запомнить меня" не поставлена, то удаляем куки
					if (isset($_COOKIE["cookie_token"])) {
                        self::deleteUserCookie($user[0]['id_user']);
                        setcookie("cookie_token", "", time() - 3600, '/');
					}
                }
                return $_SESSION['user'] = [
					"id" => $user[0]['id_user'],
					"login" => $user[0]['login'],
					"name" => $user[0]['name'],
                    "email" => $user[0]['email'],
                    "role" => self::getRoles($user[0]['id_user']),
				];
            } else {
				$_SESSION['msg'] = 'Wrong login or password';
                header('Location: /account');
            }    
        } else {
            $_SESSION['msg'] = 'Wrong login or password';
            header('Location: /account');
        }
    }

    // Метод регистрации
    public static function addNewUser($userName, $userLogin, $userEmail, $userPass, $passConfirm)
    {
        if ($userPass === $passConfirm) {
            $hash = password_hash($userPass, PASSWORD_BCRYPT);
            if (self::db()->getUser(self::TABLE, $userLogin)) {
                $_SESSION['msg'] = 'This login is busy';

                header('Location: /signup');
            } else {
                $stmt = self::link()->prepare
                    (
                        ' INSERT INTO ' . self::TABLE . " (login, password, name, email) 
                        VALUES (:login, :password, :name, :email)"
                    );
                $stmt->bindParam(':login', $userLogin, \PDO::PARAM_STR);
                $stmt->bindParam(':password', $hash, \PDO::PARAM_STR);
                $stmt->bindParam(':name', $userName, \PDO::PARAM_STR);
                $stmt->bindParam(':email', $userEmail, \PDO::PARAM_STR);
                $stmt->execute();
                            
                unset($_SESSION['user_name']);
                unset($_SESSION['user_login']);
                unset($_SESSION['user_mail']);

                $_SESSION['msg'] = 'You have successfully registered';

                header('Location: /signin');
            }
        } else {
            $_SESSION['msg'] = 'Passwords do not match';
			$_SESSION['user_name'] = $userName;
			$_SESSION['user_login'] = $userLogin;
			$_SESSION['user_mail'] = $userEmail;

			header('Location: /signup');
        }
    }

    // Метод получения ролей пользователей
    public static function getRoles($userId)
    {
        $rows = self::link()
            ->query('SELECT role FROM ' . self::TABLE_ROLES . ' WHERE user_id=' . (int)$userId)
            ->fetchAll(\PDO::FETCH_ASSOC);

        $roles = [];
        foreach ($rows as $row) {
            $roles[] = (int)$row['role'];
        }

        return $roles;
    }
}
