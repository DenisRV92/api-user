<?php


namespace App\Services;

use App\Entity\User;
use App\Interface\UserServiceInterface;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class UserService implements UserServiceInterface
{

    /**
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(private UserRepository $userRepository, private SerializerInterface $serializer,)
    {

    }

    /**
     * @return User[]
     */
    public function index()
    {
        $users = $this->userRepository->findAll();
        return $users;
    }


    /**
     * @param Request $request
     * @param FormInterface $form
     * @param User $user
     * @return array[]|string[]
     */
    public function create(Request $request, FormInterface $form, User $user): array
    {

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }

            return ['errors' => $errors];
        }

        $this->userRepository->save($user);

        return ['success' => 'Пользователь успешно создан'];

    }


    /**
     * @param int $id
     * @return User
     * @throws \Exception
     */
    public function show(int $id): User
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new \Exception('Пользователь не найден');
        }
        return $user;
    }


    /**
     * @param Request $request
     * @param FormInterface $form
     * @param int $userId
     * @return array[]|string[]
     * @throws \Exception
     */
    public function update(Request $request, FormInterface $form, int $userId): array
    {

        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new \Exception('Пользователь не найден');
        }
        $data = $this->serializer->deserialize(
            $request->getContent(),
            User::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $user]
        );

        $arrayData = $this->serializer->normalize($data);

        $form->setData($user);
        $form->submit($arrayData);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }

            return ['errors' => $errors];
        }

        $this->userRepository->save($user);

        return ['success' => 'Пользователь успешно обнавлен'];
    }


    /**
     * @param int $userId
     * @return string[]
     * @throws \Exception
     */
    public function delete(int $userId): array
    {

        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new \Exception('Пользователь не найден');
        }
        $this->userRepository->delete($user);

        return ['success' => 'Пользователь удален'];
    }

}
