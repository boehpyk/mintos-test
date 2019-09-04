<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\SignUp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class APIController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return JsonResponse
     */
    public function register(Request $request, EntityManagerInterface $em, ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder)
    {
        $signUp = new SignUp();

        $data = json_decode($request->getContent(), true);

        $signUp->setEmail($data['email']);
        $signUp->setPassword($data['password']);

        // if you want to pass the SignUp class to Validator use
        // $errors = $validator->validate($signUp);
        // but you need to customize the errors to return below, dump($errors); for more info
        $emailError = $validator->validateProperty($signUp, 'email');
        $passwordError = $validator->validateProperty($signUp, 'password');
        $formErrors = [];
        if(count($emailError) > 0) {
            $formErrors['emailError'] = $emailError[0]->getMessage();
        }
        if(count($passwordError) > 0) {
            $formErrors['passwordError'] = $passwordError[0]->getMessage();
        }
        if($formErrors) {
            return new JsonResponse($formErrors);
        }
        $user = new User();
        $user->setEmail($signUp->getEmail());
//        $user->setPassword($signUp->getPassword());
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $signUp->getPassword()
            )
        );

        $em->persist($user);
        $em->flush();
        return new JsonResponse([
            'successMessage' => 'Thank you for registering'
        ]);
    }

    public function check_email(Request $request, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);
        $count = $this->getDoctrine()
                        ->getRepository(User::class)
                        ->getCountByEmail($data['email']);
        return new JsonResponse([
            'emailError' => ($count > 0) ? 'Given email "'.$data['email'].'" already exists in database' : null
        ]);
    }
}
