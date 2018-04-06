<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Auth.
 *
 * That controller handles work with auth for you
 */
class Auth extends \App\Controller
{
    /**
     * Create JWT token by POST with body == "login=userlogin@maybe.email&password=userpassword".
     */
    public function loginAction()
    {
        $data = $this->request->getParsedBody();
        $token = $this->auth->login($data['login'] ?? null, $data['password'] ?? null);
        if (null === $token) {
            return $this->json([
                'error' => [
                    'message' => 'Incorrect credentials',
                    'fields' => [
                        'login' => 'May be incorrect',
                        'password' => 'May be incorrect',
                    ],
                ],
            ]);
        }

        return $this->json(['token' => $token]);
    }

    /**
     * Logout current user, GET without any params.
     */
    public function logoutAction()
    {
        $this->auth->logout();

        return $this->json([]);
    }

    /**
     * If user forgot password, use that endpoint, POST with body "login=userlogin@or-ema.il"
     * Use $code var to send link to user email/phone/etc.
     */
    public function forgotAction()
    {
        $data = $this->request->getParsedBody();
        $code = $this->auth->forgot($data['login'] ?? null);
        if ('' === $code) {
            return $this->json([
                'error' => [
                    'message' => 'User not found',
                    'fields' => [
                        'login' => 'Login incorrect',
                    ],
                ],
            ]);
        }

        //@TODO for developers: implement sending link with $code to user email/phone/etc.
        throw new \Exception('Sending link with code for user NOT implemented');
    }

    /**
     * Reset user password by $code, POST with body "code=codefromforgot&password=new_user_password".
     *
     * @see self::forgotAction()
     */
    public function resetAction()
    {
        $data = $this->request->getParsedBody();
        $isReset = $this->auth->reset($data['code'] ?? null, $data['password'] ?? null);
        if (false === $isReset) {
            return $this->json([
                'error' => [
                    'message' => 'User not found',
                    'fields' => [
                        'code' => 'Code incorrect',
                        'new_password' => 'Required',
                    ],
                ],
            ]);
        }

        return $this->json([]);
    }
}
