<?php

namespace nacholibre\ContactBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use nacholibre\ContactBundle\Form\ContactUsType;

class DefaultController extends Controller {
    public function contactAction(Request $request) {
        $form = $this->createForm(ContactUsType::class);

        $form->handleRequest($request);

        $translator = $this->get('translator');

        $cnf = $this->container->getParameter('nacholibre_contact');

        $siteName = $cnf['site_name'];

        if (isset($cnf['config_entity'])) {
            $entityClass = $cnf['config_entity'];
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository($entityClass);
            $entityConfig = $repo->getConfig();
            $toEmails = [$entityConfig->getContactEmail()];
        } else {
            $toEmails = $cnf['to_emails'];
        }

        if ($form->isValid()) {
            $name = $form->get('name')->getData();
            $fromEmail = $form->get('email')->getData();
            //$phone = $form->get('phone')->getData();
            $message = $form->get('message')->getData();

            $subject = sprintf('%s - %s', $translator->trans('Contact Form'), $siteName);

            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($fromEmail)
                ->setTo($toEmails)
                ->setBody(
                    $this->renderView(
                        'nacholibreContactBundle:email:contact_form.html.twig',
                        [
                            'name' => $name,
                            'fromEmail' => $fromEmail,
                            //'phone' => $phone,
                            'message' => $message,
                        ]
                    ),
                    'text/html'
                )
                /*
                * If you also want to include a plaintext version of the message
                ->addPart(
                    $this->renderView(
                        'Emails/registration.txt.twig',
                        array('name' => $name)
                    ),
                    'text/plain'
                )
                */
            ;

            $this->get('mailer')->send($message);

            $this->addFlash(
                'notice',
                $translator->trans('Your message was sent') . '!'
            );

            $form = $this->createForm(ContactUsType::class);
        }

        return $this->render('nacholibreContactBundle::contact_page.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
