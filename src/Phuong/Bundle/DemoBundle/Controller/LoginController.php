<?php

namespace Phuong\Bundle\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Phuong\Bundle\DemoBundle\Form\LoginType;
use Phuong\Bundle\DemoBundle\Entity\Login;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LoginController extends Controller
{
    public function showLoginAction()
    {

        // return $this->render('PhuongDemoBundle:Login:showLogin.html.twig', array(
        //         // ...
        //     ));
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'PhuongDemoBundle:Login:showLogin.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {

        $username = trim($this->getRequest()->query->get('_username'));
        $password = trim($this->getRequest()->query->get('_password'));

        $post = Request::createFromGlobals();

        if ($post->request->has('submit')) {
            $username = $post->request->get('_username');
            $password = $post->request->get('_password');

            $em = $this->get('doctrine')->getEntityManager();
            $query = $em->createQuery("SELECT u FROM \Phuong\Bundle\DemoBundle\Entity\Login u WHERE u.username = :username");
            $query->setParameter('username', $username);
            //$query->setParameter('password', md5($password));
            $user = $query->getOneOrNullResult();
            //var_dump($user);
            if ($user) {
              // Get the encoder for the users password
              // $encoder_service = $this->get('security.encoder_factory');
              // $encoder = $encoder_service->getEncoder($user);
              // $encoded_pass = $encoder->encodePassword($password, $user->getSalt());

              if ($user->getPassword() == md5($password)) {
                // Get profile list
                var_dump('dung roi');
              } else {
                var_dump('fail pass');
              }
            } else {
              var_dump('fail user');
            }
        } else {
            $name = 'Not submitted yet';
        }
        
        //var_dump($request->query->get('_username'));
        //var_dump($_POST['_username']);
        // this controller will not be executed,
        // as the route is handled by the Security system
    }


    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new Login();
        $form = $this->createForm(new LoginType(), $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = md5($user->getPlainPassword());
            $user->setPassword($password);
            //$user->setPassword($user->getPlainPassword());
            $user->setcreatedAt(new \DateTime());
            //echo '<pre>';var_dump($user);die();
            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like send them an email, etc
            // maybe set a "flash" success message for the user
            $request->getSession()
                ->getFlashBag()
                ->add('register_success', 'Register success')
            ;
            return $this->redirectToRoute('show_login');
        }

        return $this->render(
            'PhuongDemoBundle:Login:register.html.twig',
            array('form' => $form->createView())
        );
    }

}
