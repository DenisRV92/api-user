<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserForm;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class UserController extends AbstractController
{

    /**
     * @param UserService $service
     */
    public function __construct(private UserService $service)
    {

    }
    /**
     * All users
     *
     * @OA\Get(
     *     path="/api",
     *     summary="Все пользователи",
     *     @OA\RequestBody(
     *         description="Все пользователи",
     *     ),
     * )
     * /
    /**
     * @return JsonResponse
     */
    #[Route('/api/users', methods: 'GET')]
    public function index(): JsonResponse
    {
        $users = $this->service->index();
        return $this->json(['users' => $users], Response::HTTP_OK);
    }


    #[Route(methods: 'POST')]
    /**
     * Create a new user
     *
     * @OA\Post(
     *     path="/api/users/create",
     *     summary="Creates a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            @OA\Property(property="name", type="string",example="den"),
     *            @OA\Property(property="email", type="string",example="den@test.com"),
     *            @OA\Property(property="birthday", type="string",example="12-03-1984"),
     *            @OA\Property(property="age", type="integer",example="47"),
     *            @OA\Property(property="sex", type="string",example="м"),
     *            @OA\Property(property="phone", type="string",example="79534562023"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Пользователь успешно создан",
     *     )
     * )
     * /
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('api/users/create',name: 'create', methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        $user = new User();
        $form = $this->createForm(UserForm::class, $user);
        try {

            $result = $this->service->create($request, $form, $user);

            if (isset($result['errors'])) {
                return $this->json($result['errors'], Response::HTTP_BAD_REQUEST);
            }
            return $this->json($result, Response::HTTP_CREATED);

        } catch (\Throwable $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show user
     *
     * @OA\Get(
     *     path="/api/{id}",
     *     summary="Show user",
     * )
     * /
    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('api/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->service->show($id);
            return $this->json(['user' => $user], Response::HTTP_OK);
        } catch (\Throwable $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }


    /**
     * Update user
     *
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Update user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            @OA\Property(property="name", type="string",example="Oleg"),
     *            @OA\Property(property="email", type="string",example="oleg@test.com"),
     *            @OA\Property(property="phone", type="string",example="79535662023"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Данные пользователя успешно изменены",
     *     )
     * )
     * /
    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/api/users/{id}',name: 'update', methods: 'PUT')]
    public function update(Request $request): Response
    {
        $userId = $request->get('id');

        $form = $this->createForm(UserForm::class, null, [
            'method' => $request->getMethod()
        ]);
        try {
            $result = $this->service->update($request, $form, $userId);
            if (isset($result['errors'])) {
                return $this->json($result['errors'], Response::HTTP_BAD_REQUEST);
            }
            return $this->json($result);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Delete user
     *
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Delete user",
     *     @OA\Response(
     *         response=200,
     *         description="Пользователь удален",
     *     )
     * )
     * /
    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('api/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id)
    {
        try {
            $result = $this->service->delete($id);
            return $this->json($result, Response::HTTP_OK);
        } catch (\Throwable $exception) {
            return $this->json(['error' => 'Пользователь не найден'], Response::HTTP_NOT_FOUND);
        }
    }
}
