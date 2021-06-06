<?php


namespace App\Controller;

use App\Entity\User;
use App\Service\PasswordEncoder;
use App\Service\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class Enter extends AbstractController
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

        return $this->render('enter.html.twig', $twigVars);
    }

    public function authUser(Request $request, PasswordEncoder $encoder)
    {
        try {
            /** @var User $user*/
            $user = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository(User::class)
                ->findOneBy(['login' => (string)$request->get('login')]);
        } catch (\Exception $e) {
            $request->getSession()->set('error', 'Произошла ошибка. Попробуйте еще раз');
            return $this->redirectToRoute('enter');
        }

        if (is_null($user)) {
            $request->getSession()->set('error', 'Логин не найден');
            return $this->redirectToRoute('enter');
        }

        if ($user->getPassword() !== $encoder->encode($request->get('password'))) {
            $request->getSession()->set('error', 'Неверный пароль');
            return $this->redirectToRoute('enter');
        }


        $redirect = new RedirectResponse($this->generateUrl('index'));
        $redirect->headers->setCookie(Cookie::create('idUser', $user->getIdUser()));

        return $redirect->send();
    }

    public function logout(Request $request)
    {
        $redirect = new RedirectResponse($this->generateUrl('enter'));
        $redirect->headers->clearCookie('idUser');
        return $redirect->send();
    }
}