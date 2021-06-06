<?php


namespace App\Controller;


use App\Entity\Order;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class Form extends AbstractController
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
        return $this->render('form.html.twig', $twigVars);
    }

    public function createOrder(Request $request)
    {
        if ((int)$request->get('service') === 0) {
            $request->getSession()->set('error', 'Услуга не выбрана');
            return $this->redirectToRoute('form');
        }

        $em = $this->getDoctrine()->getManager();
        $order = (new Order())
            ->setIdService($request->get('service'))
            ->setIsConfirmed(0)
            ->setComment($request->get('comment'));

        if ($request->cookies->get('idUser')) {
            $user = $this->getDoctrine()
                ->getManager()
                ->getRepository(User::class)
                ->find((int)$request->cookies->get('idUser'));

            if ($user) {
                $order
                    ->setName($user->getName())
                    ->setPhone($user->getPhone());
            }
        } else {
            $order
                ->setName($request->get('name'))
                ->setPhone($request->get('phone'));
        }

        try {
            $em->persist($order);
            $em->flush();
        } catch (\Exception $e) {
            $request->getSession()->set('error', 'Ошибка при создании заявки');
            return $this->redirectToRoute('form');
        }

        return $this->redirectToRoute('confirmation');
    }

    public function confirmation()
    {
        return $this->render('confirmation.html.twig');
    }
}