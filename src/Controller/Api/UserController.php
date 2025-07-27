<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/v1/api/users')]
final class UserController extends AbstractController
{
    #[Route('', name: 'user_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $user = new User();
        $user->setLogin($data['login'] ?? null);
        $user->setPass($data['pass'] ?? null);
        $user->setPhone($data['phone'] ?? null);
        
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }
        
        // Перевірка на унікальність login+pass
        $exists = $em->getRepository(User::class)->findOneBy([
            'login' => $user->getLogin(),
            'pass' => $user->getPass(),
        ]);
        
        if ($exists) {
            return $this->json(['error' => 'User with same login and pass already exists.'], Response::HTTP_CONFLICT);
        }
        
        $em->persist($user);
        $em->flush();
        
        return $this->json(['status' => 'User created'], Response::HTTP_CREATED);
    }
    
    #[Route('', name: 'user_list', methods: ['GET'])]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $users = $em->getRepository(User::class)->findAll();
        $data = [];
        
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'login' => $user->getLogin(),
                'pass' => $user->getPass(),
                'phone' => $user->getPhone(),
            ];
        }
        
        return $this->json($data);
    }
    
    #[Route('/{id}', name: 'user_update', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $user = $em->getRepository(User::class)->find($id);
        if (!$user) {
            return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        
        $data = json_decode($request->getContent(), true);
        $user->setLogin($data['login'] ?? $user->getLogin());
        $user->setPass($data['pass'] ?? $user->getPass());
        $user->setPhone($data['phone'] ?? $user->getPhone());
        
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }
        
        $em->flush();
        
        return $this->json(['status' => 'User updated']);
    }
    
    #[Route('/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $em): JsonResponse
    {
        $user = $em->getRepository(User::class)->find($id);
        if (!$user) {
            return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        
        $em->remove($user);
        $em->flush();
        
        return $this->json(['status' => 'User deleted']);
    }
}
