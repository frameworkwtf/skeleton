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
    public function formAction()
    {
        return $this->render('auth/form.html', [
            'resetCode' => $this->request->getAttribute('reset_code'),
        ]);
    }

    public function loginAction()
    {
        $data = $this->request->getParsedBody();
        $loggedIn = $this->auth->login($data['login'] ?? null, $data['password'] ?? null);
        if (!$loggedIn) {
            $this->flash->addMessage('danger', 'Incorrect login or password');

            return $this->redirect('/auth');
        }

        $this->flash->addMessage('success', 'Welcome');

        return $this->redirect('/');
    }

    public function registerAction()
    {
        $data = $this->request->getParsedBody();
        try {
            $this->entity('user')->register($data);
        } catch (\Throwable $t) {
            $this->flash->addMessage('danger', $t->getMessage());

            return $this->redirect('/auth');
        }

        $this->auth->login($data['login'], $data['password']);

        return $this->redirect('/');
    }

    /**
     * Logout current user, GET without any params.
     */
    public function logoutAction()
    {
        $this->auth->logout();

        return $this->redirect('/auth');
    }

    /**
     * If user forgot password, use that endpoint, POST with body "login=userlogin@or-ema.il"
     * Use $code var to send link to user email/phone/etc.
     */
    public function forgotAction(): void
    {
        $data = $this->request->getParsedBody();
        $code = $this->auth->forgot($data['login'] ?? null);
        if ('' === $code) {
            $this->flash->addMessage('danger', 'Login incorrect');
            $this->redirect('/auth');
        }
        $this->flash->addMessage('success', 'Magic link with reset code was sent to your email');

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
            $this->flash->addMessage('danger', 'Reset code is incorrect');
            $this->redirect('/auth');
        }

        return $this->redirect('/');
    }
}
