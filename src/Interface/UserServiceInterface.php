<?php

namespace App\Interface;

use App\Entity\User;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface UserServiceInterface
{
    /**
     * @return User[]
     */
    public function index();

    /**
     * @param Request $request
     * @param FormInterface $form
     * @param User $user
     * @return array|string[]
     */
    public function create(Request $request, FormInterface $form, User $user): array;

    /**
     * @param int $id
     * @return User
     */
    public function show(int $id): User;

    /**
     * @param Request $request
     * @param FormInterface $form
     * @param int $userId
     * @return array|string[]
     */
    public function update(Request $request, FormInterface $form, int $userId): array;

    /**
     * @param int $userId
     * @return string[]
     */
    public function delete(int $userId): array;
}
