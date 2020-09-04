<?php


namespace Tests\Controllers;


use Tests\Form\UserFormRequest;
use YiluTech\ApiDocGenerator\Annotations as SWG;

/**
 * Class UserController
 * @package Tests\Controllers
 * @SWG\Tag("user", description="user object")
 * @SWG\Tags({"user"})
 * @SWG\Obj(name="user", {
 *     "id"         = @SWG\Integer,
 *     "name"       = @SWG\Str,
 *     "sex"        = @SWG\Integer(enum={0, 1, 2}),
 *     "tags"       = @SWG\Arr(@SWG\Str(enum={"member", "student", "teacher", "other"})),
 *     "created_at" = @SWG\Str(format="date-time"),
 *     "updated_at" = @SWG\Str(format="date-time"),
 * })
 */
class UserController
{
    /**
     * @param UserFormRequest $request
     * @SWG\Parameter(name="id", in="query", schema=@SWG\Schema(oneOf={@SWG\Integer, @SWG\Str}))
     * @SWG\PaginationResponse(@SWG\Reference("#/components/schemas/user"), description="get user")
     * @SWG\PaginationResponse({
     *     "data" = @SWG\Schema(oneOf={
     *          @SWG\Reference("#/components/schemas/user"),
     *          @SWG\Str(default="""#/components/schemas/user")
     *     })
     * }, description="get user", status=422)
     */
    public function find(UserFormRequest $request)
    {

    }

    /**
     * @SWG\Parameter(name="id", schema=@SWG\Schema(oneOf={@SWG\Integer, @SWG\Str}))
     * @SWG\SearchRequest
     * @SWG\PaginationResponse(@SWG\Reference("#/components/schemas/user"), description="user list")
     */
    public function list() {

    }

    /**
     * @param UserFormRequest $request
     * @SWG\JsonResponse(@SWG\Reference("#/components/schemas/user"), description="create user")
     * @SWG\JsonResponse(@SWG\Reference("#/components/schemas/bizException"), description="create error", status=400)
     */
    public function create(UserFormRequest $request)
    {

    }

    /**
     * @param UserFormRequest $request
     * @SWG\JsonResponse(@SWG\Reference("#/components/schemas/user"), description="update user")
     */
    public function update(UserFormRequest $request)
    {

    }

    /**
     * @param UserFormRequest $request
     * @SWG\JsonResponse({
     *     "data" = @SWG\Str(enum={"success", "fail"})
     * }, description="delete user")
     */
    public function delete(UserFormRequest $request)
    {

    }
}
