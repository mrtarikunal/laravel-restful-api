<?php
/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Laravel API Documentation",
 *     description="This is a sample API documentation",
 *     termsOfService="http://laravelapi.test/api.terms",
 *     @OA\Contact(email="deneme@gmail.com"),
 *     @OA\License(name="Apache 2.0", url="http://www.apache.org/licenses/LICENSE-2.0.html")
 * )
 */

/**
 * @OA\Server(
 *     description="Laravel API test Server",
 *     url="http://laravelapi.test/api"
 * )
 */

/**
 * @OA\Server(
 *     description="Laravel API Stage Server",
 *     url="http://laravelapi.stage/api"
 * )
 */

/**
 * @OA\ExternalDocumentation(
 *     description="Find out more about Laravel API",
 *     url="https://www.tarikunal.com"
 * )
 */

/**
 * @OA\Schema(
 *     title="Product",
 *     description="Product model",
 *     type="object",
 *     schema="Product",
 *     properties={
 *     @OA\Property(property="id", type="integer", format="int64", description="id column"),
 *     @OA\Property(property="name", type="string")
 *     },
 *     required={"id", "name"}
 * )
 */

/**
 * @OA\Schema(
 *     title="Product Update",
 *     description="Product update model",
 *     type="object",
 *     schema="ProductUpdate",
 *     properties={
 *     @OA\Property(property="price", type="number"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="slug", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     },
 *     required={"name", "slug", "description", "price"}
 * )
 */

/**
 * @OA\Tag(
 *     name="product",
 *     description="product tag description",
 *     @OA\ExternalDocumentation(
 *     description="find out more",
 *     url="https://www.tarikunal.com"
 *           )
 *       )
 */

/**
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     name="api_token",
 *     securityScheme="api_token",
 *     in="query"
 *      )
 */

/**
 * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="bearer_token",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 *      )
 */

/**
 * @OA\Get(
 *     path="/products",
 *     tags={"product"},
 *     summary="List all products",
 *     operationId="index",
 *     @OA\Parameter(
 *     name="Limit",
 *     in="query",
 *     description="How mant item to return at one time",
 *     required=false,
 *     @OA\Schema(type="integer", format="int32")
 *            ),
 *     @OA\Response(
 *     response=200,
 *     description="A paged array of products",
 *     @OA\JsonContent(
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/Product")
 *      )
 *           ),
 *     @OA\Response(
 *     response=401,
 *     description="Unathoritized",
 *     @OA\JsonContent()
 *           ),
 *     @OA\Response(
 *     response="default",
 *     description="Unexpected Error",
 *     @OA\JsonContent()
 *           ),
 *     security={
 *     {"api_token": {}}
 *     }
 *        )
 */

/**
 * @OA\Get(
 *     path="/products/{productId}",
 *     tags={"product"},
 *     summary="Info for a psecific product",
 *     operationId="show",
 *     @OA\Parameter(
 *     name="productId",
 *     in="path",
 *     description="The id column of the prdoduct to retrieve",
 *     required=true,
 *     @OA\Schema(type="integer", format="int32")
 *            ),
 *     @OA\Response(
 *     response=200,
 *     description="Products detail response",
 *     @OA\Schema(ref="#/components/schemas/Product")
 *           ),
 *     @OA\Response(
 *     response=401,
 *     description="Unathoritized",
 *     @OA\JsonContent()
 *           ),
 *     @OA\Response(
 *     response="default",
 *     description="Unexpected Error",
 *     @OA\JsonContent()
 *           ),
 *     security={
 *     {"api_token": {}}
 *     }
 *        )
 */

/**
 * @OA\Post(
 *     path="/products",
 *     tags={"product"},
 *     summary="Create a product",
 *     operationId="store",
 *     @OA\RequestBody(
 *     description="store a product",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Product")
 *            ),
 *     @OA\Response(
 *     response=201,
 *     description="Products created response",
 *     @OA\Schema(ref="#/components/schemas/Product")
 *           ),
 *     @OA\Response(
 *     response=401,
 *     description="Unathoritized",
 *     @OA\JsonContent()
 *           ),
 *     @OA\Response(
 *     response="default",
 *     description="Unexpected Error",
 *     @OA\JsonContent()
 *           ),
 *     security={
 *     {"api_token": {}}
 *     }
 *        )
 */

/**
 * @OA\Put(
 *     path="/products/{productId}",
 *     tags={"product"},
 *     summary="Create a product",
 *     operationId="update",
 *     @OA\Parameter(
 *     name="productId",
 *     in="path",
 *     description="The id column of the prdoduct to update",
 *     required=true,
 *     @OA\Schema(type="integer", format="int32")
 *            ),
 *     @OA\RequestBody(
 *     description="update a product",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/ProductUpdate")
 *            ),
 *     @OA\Response(
 *     response=200,
 *     description="Products updated response",
 *     @OA\Schema(ref="#/components/schemas/Product")
 *           ),
 *     @OA\Response(
 *     response=401,
 *     description="Unathoritized",
 *     @OA\JsonContent()
 *           ),
 *     @OA\Response(
 *     response="default",
 *     description="Unexpected Error",
 *     @OA\JsonContent()
 *           ),
 *     security={
 *     {"api_token": {}}
 *     }
 *        )
 */

/**
 * @OA\Delete(
 *     path="/products/{productId}",
 *     tags={"product"},
 *     summary="Deletes a product",
 *     operationId="destroy",
 *     @OA\Parameter(
 *     name="productId",
 *     in="path",
 *     description="The id column of the prdoduct to delete",
 *     required=true,
 *     @OA\Schema(type="integer", format="int32")
 *            ),
 *     @OA\Response(
 *     response=200,
 *     description="Products delete response",
 *     @OA\Schema(ref="#/components/schemas/Product")
 *           ),
 *     @OA\Response(
 *     response=401,
 *     description="Unathoritized",
 *     @OA\JsonContent()
 *           ),
 *     @OA\Response(
 *     response="default",
 *     description="Unexpected Error",
 *     @OA\JsonContent()
 *           ),
 *     security={
 *     {"api_token": {}}
 *     }
 *        )
 */
