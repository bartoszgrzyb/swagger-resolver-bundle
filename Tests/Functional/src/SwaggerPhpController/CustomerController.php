<?php

declare(strict_types=1);

/*
 * This file is part of the SwaggerResolverBundle package.
 *
 * (c) Viktor Linkin <adrenalinkin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Linkin\Bundle\SwaggerResolverBundle\Tests\Functional\SwaggerPhpController;

use Linkin\Bundle\SwaggerResolverBundle\Factory\SwaggerResolverFactory;
use Linkin\Bundle\SwaggerResolverBundle\Tests\Functional\Models\CustomerFull;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Viktor Linkin <adrenalinkin@gmail.com>
 *
 * @SWG\Tag(name="customer")
 */
class CustomerController
{
    /**
     * @Route(name="customers_get", path="/api/customers", methods={"GET"})
     * @SWG\Get(
     *      path="/api/customers",
     *      description="Returns all customers",
     *      @SWG\Parameter(
     *          name="x-auth-token",
     *          in="header",
     *          description="Alternative token for the authorization",
     *          required=true,
     *          type="string",
     *          pattern="^\w{36}$",
     *      ),
     *      @SWG\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page number",
     *          required=false,
     *          type="integer",
     *          default=0,
     *          minimum=0,
     *      ),
     *      @SWG\Parameter(
     *          name="perPage",
     *          in="query",
     *          description="Items count for the single page",
     *          required=false,
     *          type="integer",
     *          enum={100, 500, 1000},
     *          default=100,
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="A list of customers",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/CustomerFull")
     *          ),
     *      ),
     * )
     */
    public function getAll(Request $request, SwaggerResolverFactory $factory): Response
    {
        $swaggerResolver = $factory->createForDefinition(CustomerFull::class);
        $data = $swaggerResolver->resolve(json_decode($request->getContent(), true));

        return new JsonResponse([$data]);
    }

    /**
     * @Route(name="customers_post", path="/api/customers", methods={"POST"})
     * @SWG\Post(
     *      path="/api/customers",
     *      method="POST",
     *      description="Create new customer",
     *      @SWG\Parameter(
     *          name="x-auth-token",
     *          in="header",
     *          description="Alternative token for the authorization",
     *          required=true,
     *          type="string",
     *          pattern="^\w{36}$",
     *      ),
     *      @SWG\Parameter(
     *          name="roles",
     *          in="query",
     *          description="Deprecated - Old way to set user roles",
     *          required=false,
     *          type="array",
     *          collectionFormat="csv",
     *          uniqueItems=true,
     *          minItems=1,
     *          maxItems=3,
     *          @SWG\Items(type="string", enum={"guest", "user", "admin"}),
     *      ),
     *      @SWG\Parameter(
     *          name="customer",
     *          in="body",
     *          description="Customer to add to the system",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/CustomerNew"),
     *      ),
     *      @SWG\Response(
     *          response=201,
     *          description="New customer ID",
     *          @SWG\Schema(ref="#/definitions/ResponseCreated"),
     *      )
     * )
     */
    public function create(): void
    {
    }

    /**
     * @Route(name="customers_get_one", path="/api/customers/{userId}", methods={"GET"}, requirements={"userId": "\d+"})
     * @SWG\Get(
     *      path="/api/customers/{userId}",
     *      description="Return customer by ID",
     *      @SWG\Parameter(
     *          name="x-auth-token",
     *          in="header",
     *          description="Alternative token for the authorization",
     *          required=true,
     *          type="string",
     *          pattern="^\w{36}$",
     *      ),
     *      @SWG\Parameter(
     *          name="userId",
     *          in="path",
     *          description="Customer ID for retrieve data",
     *          required=true,
     *          type="integer",
     *          format="int64",
     *          minimum=0,
     *          exclusiveMinimum=true,
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Customer data",
     *          @SWG\Schema(ref="#/definitions/CustomerFull"),
     *      )
     * )
     */
    public function getOne(): void
    {
    }

    /**
     * @Route(name="customers_update", path="/api/customers/{userId}", methods={"PUT"}, requirements={"userId": "\d+"})
     * @SWG\Put(
     *      path="/api/customers/{userId}",
     *      description="Update customer",
     *      @SWG\Parameter(
     *          name="x-auth-token",
     *          in="header",
     *          description="Alternative token for the authorization",
     *          required=true,
     *          type="string",
     *          pattern="^\w{36}$",
     *      ),
     *      @SWG\Parameter(
     *          name="userId",
     *          in="path",
     *          description="Customer ID to update",
     *          required=true,
     *          type="integer",
     *          format="int64",
     *          minimum=0,
     *          exclusiveMinimum=true,
     *      ),
     *      @SWG\Parameter(
     *          name="roles",
     *          in="query",
     *          description="Deprecated - Old way to set user roles",
     *          required=false,
     *          type="array",
     *          collectionFormat="csv",
     *          uniqueItems=true,
     *          minItems=1,
     *          maxItems=3,
     *          @SWG\Items(type="string", enum={"guest", "user", "admin"}),
     *      ),
     *      @SWG\Parameter(
     *          name="customer",
     *          in="body",
     *          description="Customer update",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/CustomerNew"),
     *      ),
     *      @SWG\Response(response=204, description="Empty response when updated successfully")
     * )
     */
    public function update(): void
    {
    }

    /**
     * @Route(name="customers_patch", path="/api/customers/{userId}", methods={"PATCH"}, requirements={"userId": "\d+"})
     * @SWG\Patch(
     *      path="/api/customers/{userId}",
     *      description="Partial customer update in formData style",
     *      deprecated=true,
     *      consumes={"application/x-www-form-urlencoded"},
     *      @SWG\Parameter(
     *          name="x-auth-token",
     *          in="header",
     *          description="Alternative token for the authorization",
     *          required=true,
     *          type="string",
     *          pattern="^\w{36}$",
     *      ),
     *      @SWG\Parameter(
     *          name="userId",
     *          in="path",
     *          description="Customer ID to update",
     *          required=true,
     *          type="integer",
     *          format="int64",
     *          minimum=0,
     *          exclusiveMinimum=true,
     *      ),
     *      @SWG\Parameter(
     *          name="roles",
     *          in="query",
     *          description="Deprecated - Old way to set user roles",
     *          required=false,
     *          type="array",
     *          collectionFormat="csv",
     *          uniqueItems=true,
     *          minItems=1,
     *          maxItems=3,
     *          @SWG\Items(type="string", enum={"guest", "user", "admin"}),
     *      ),
     *      @SWG\Parameter(
     *          name="name",
     *          in="formData",
     *          description="Name of the Customer",
     *          required=true,
     *          type="string",
     *          minLength=2,
     *          maxLength=50,
     *      ),
     *      @SWG\Parameter(
     *          name="discount",
     *          in="formData",
     *          description="Size of the Customer's discount in percent",
     *          required=false,
     *          type="integer",
     *          format="int32",
     *          default=0,
     *          multipleOf=10,
     *          minimum=0,
     *          exclusiveMinimum=false,
     *          maximum=100,
     *          exclusiveMaximum=true,
     *      ),
     *      @SWG\Response(response=204, description="Empty response when updated successfully")
     * )
     */
    public function updatePartial(): void
    {
    }

    /**
     * @Route(
     *      name="customers_delete",
     *      path="/api/customers/{userId}",
     *      methods={"DELETE"},
     *      requirements={"userId": "\d+"}
     * )
     *
     * @SWG\Delete(
     *      path="/api/customers/{userId}",
     *      description="Delete customer from the system",
     *      @SWG\Parameter(
     *          name="x-auth-token",
     *          in="header",
     *          description="Alternative token for the authorization",
     *          required=true,
     *          type="string",
     *          pattern="^\w{36}$",
     *      ),
     *      @SWG\Parameter(
     *          name="userId",
     *          in="path",
     *          description="Customer ID to delete",
     *          required=true,
     *          type="integer",
     *          format="int64",
     *          minimum=0,
     *          exclusiveMinimum=true,
     *      ),
     *      @SWG\Response(response=204, description="Empty response when removed successfully"),
     * )
     */
    public function delete(): void
    {
    }
}
