<?php


namespace App\Controller;

use App\Service\PasswordEncoder;
use App\Service\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\VarDumper\VarDumper;
use App\Entity\User;

class Registration extends AbstractController
{
    public function index(Request $request)
    {
        $twigVars = [];

        if ($request->getSession()->has('error')) {
            $twigVars['errors'] = [
                $request->getSession()->get('error')
            ];
            $request->getSession()->remove('error');
        }

        return $this->render('registration.html.twig', $twigVars);
    }

    public function createUser(Request $request, Validator $validator, PasswordEncoder $encoder)
    {
        if (false === $validator->isEmail($request->get('email'))) {
            $request->getSession()->set('error', 'Введенный E-mail не корректен');
            return $this->redirectToRoute('registration');
        }

        if ($this->isMailExists($request->get('email'))) {
            $request->getSession()->set('error', 'Этот E-mail уже используется');
            return $this->redirectToRoute('registration');
        }

        if ($this->isLogingExists($request->get('login'))) {
            $request->getSession()->set('error', 'Этот логин уже используется');
            return $this->redirectToRoute('registration');
        }

        $user = (new User())
            ->setLogin($request->get('login'))
            ->setEmail($request->get('email'))
            ->setName($request->get('name'))
            ->setPhone($request->get('phone'))
            ->setPassword($encoder->encode($request->get('password')));

        try {
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
        } catch (\Exception $e) {
            $request->getSession()->set('error', 'Не удалось добавить пользователя');
            return $this->redirectToRoute('registration');
        }

        $redirect = new RedirectResponse($this->generateUrl('index'));
        $redirect->headers->setCookie(Cookie::create('idUser', $user->getIdUser()));

        return $redirect->send();
    }

    /**
     * @param string $mail
     * @return bool
     */
    protected function isMailExists($mail)
    {
        return (bool)$this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['email' => $mail]);
    }

    /**
     * @param string
     * @return bool
     */
    protected function isLogingExists($login)
    {
        return (bool)$this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['login' => (string)$login]);
    }
}