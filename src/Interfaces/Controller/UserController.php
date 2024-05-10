<?php

namespace App\Interfaces\Controller;

use App\Application\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/register', name: 'register_user', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $contentType = $request->headers->get('Content-Type');
        if (str_contains($contentType, 'application/json')) {
            $data = json_decode($request->getContent(), true);
        } else {
            $data = $request->request->all();
        }

        $email = $data['email'];
        $password = $data['password'];
        $name = $data['name'];

        if (!$email || !$password || !$name) {
            return new JsonResponse(['error' => 'Missing required parameters'], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userService->registerUserService($email, $password, $name);
        var_dump('user controller', $user);

        return new JsonResponse([
            'success' => true,
            'userId' => $user->getId(),
            'message' => 'User registered successfully'
        ], Response::HTTP_CREATED);
    }

    #[Route('/login', name: 'login_user', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $isLogged = $this->userService->loginUserService($email, $password);

        if ($isLogged) {
            return new JsonResponse([
                'success' => true,
                'message' => 'User logged in successfully'
            ]);
        }

        return new JsonResponse([
            'success' => false,
            'message' => 'Invalid credentials'
        ]);
    }
}
