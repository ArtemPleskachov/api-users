<?php

namespace App\Controller\Api\Auth;

use App\DTO\Request\Auth\RegisterDTO;
use App\Service\UserService;
use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/v1/api/auth')]
final class AuthController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
    ) {}
    
    #[Route('/login', name: 'app_api_auth_login', methods: ['POST'])]
    public function login(): never
    {
        throw new \LogicException('Handled by json_login firewall.');
    }
    
    #[Route('/register', methods: ['POST'])]
    public function register(#[MapRequestPayload] RegisterDTO $dto): JsonResponse
    {
        try {
            ['user' => $user, 'token' => $token] = $this->userService->registerAndIssueToken($dto);
        } catch (DomainException $e) {
            $code = $e->getCode() ?: 400;
            return $this->json(['success' => false, 'message' => $e->getMessage()], $code);
        }
        
        return $this->json([
            'success' => true,
            'token'   => $token,
            'user'    => [
                'public_id' => $user->getPublicId(),
                'login'     => $user->getLogin(),
                'roles'     => $user->getRoles(),
            ],
        ], 201);
    }
}