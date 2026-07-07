<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swift_Mailer;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        /*return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);*/
        return $this->render('new.base.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/quienes-somos", name="about")
     */
    public function about(): Response
    {
        return $this->render('default/about.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/contratación", name="contract")
     */
    public function contract(): Response
    {
        return $this->render('default/contract.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/productos", name="products")
     */
    public function products(): Response
    {
        return $this->render('default/products.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/politica-privacidad", name="privacy-policy")
     */
    public function privacy(): Response
    {
        return $this->render('default/privacy.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, Swift_Mailer $mailer)
    {
        //Comprobar si es peticion AJAX
        if ($request->isXmlHttpRequest()) {
            //Establecer logs
            $logger = new Logger('my_logger');
            $logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/email.log', Logger::DEBUG));
            $logger->info('Reached POST check');

            //Comprobar si la petición está vacía
            if (
                empty($_POST['email'])     ||
                empty($_POST['phone'])     ||
                !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
            ) {
                $logger->info('No arguments Provided!');
                echo "No arguments Provided!";
                return new JsonResponse(['success' => false]);
            }
            $logger->info('Arguments Provided!');

            //Sanear texto
            $email_address = strip_tags(htmlspecialchars($_POST['email']));
            $phone = strip_tags(htmlspecialchars($_POST['phone']));

            $logger->info("Vars saved:\"\nEmail: " . $email_address . "\nPhone: " . $phone);

            //Crear correo
            $message = (new \Swift_Message("Formulario Contacto Web:  " . $email_address))
                ->setFrom('contacto@finkaluz.com')
                ->setReplyTo($email_address)
                ->setTo('finkaluz@finkaluz.com')
                ->setBody(
                    // Contenido del correo. Puede ser texto o una plantilla renderizada.
                    $this->renderView('emails/contacto.email.html.twig', [
                        'email_address' => $email_address,
                        'phone' => $phone,
                    ]),
                    'text/html'
                );

            $logger->info($this->renderView('emails/contact.email.html.twig', [
                'email_address' => $email_address,
                'phone' => $phone,
            ]));

            //Enviar correo
            $result = $mailer->send($message);

            $logger->info($result);

            return new JsonResponse(['success' => true]);
        }
    }
}
