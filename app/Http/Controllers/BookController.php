<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\IBookInterface;

/**
 * @group Book
 *
 * API endpoints for managing Book
 */
class BookController extends Controller
{
    protected $bookInterface;

    public function __construct(IBookInterface $bookInterface)
    {
        $this->bookInterface = $bookInterface;
    }

    /**
     * @OA\Get(
     *      path="/all-books",
     *      operationId="getBooksList",
     *      tags={"Books"},
     *      summary="Get list of books",
     *      description="Returns list of books",
     *      @OA\Response(
     *          response=200,
     *          description="All Books",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="title", type="string", example="The Lone Wolf"),
     *              @OA\Property(property="author", type="string", example="Jake Fox"),
     *              @OA\Property(property="username", type="string", example="Olaide"),
     *              @OA\Property(property="average_rating", type="integer", example="3.5"),
     *              )
     *       ),
     *     )
     */
    public function showAllBooks()
    {
        return $this->bookInterface->getAllBooks();
    }

    /**
     * @OA\Post(
     * path="/book",
     * summary="Create a book",
     * description="User create a book",
     * operationId="createBook",
     * tags={"Books"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide book details",
     *    @OA\JsonContent(
     *       required={"title","author"},
     *       @OA\Property(property="title", type="string", example="The Jungle Book"),
     *       @OA\Property(property="author", type="string", format="email", example="Mane Lane")
     *    ),
     * ),
     * 
     * @OA\Response(
     *    response=200,
     *    description="Book created successfully!",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="string", format="integer", example="3"),
     *       @OA\Property(property="title", type="string", example="The Jungle Book"),
     *       @OA\Property(property="author", type="string", example="Mane Lane"),
     *       @OA\Property(property="username", type="string", example="Olamide"),
     *       @OA\Property(property="average_rating", type="string", example="null"),  
     *        )
     *     ),
     * 
     * @OA\Response(
     *    response=422,
     *    description="Fields are required",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="fields are required")
     *        )
     *     ),
     * )
     */
    public function create(Request $request)
    {
        return $this->bookInterface->createBook($request);
    }

    /**
     * @OA\Put(
     * path="/book/{id}",
     * summary="Update a book",
     * description="User update a book",
     * operationId="updateBook",
     * tags={"Books"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide book details",
     *    @OA\JsonContent(
     *       required={"title","author"},
     *       @OA\Property(property="title", type="string", example="The Jungle"),
     *       @OA\Property(property="author", type="string", format="email", example="Mane Rice")
     *    ),
     * ),
     * 
     * @OA\Response(
     *    response=200,
     *    description="Book updated successfully!",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="string", format="integer", example="3"),
     *       @OA\Property(property="title", type="string", example="The Jungle"),
     *       @OA\Property(property="author", type="string", example="Mane Rice"),
     *       @OA\Property(property="username", type="string", example="Olamide"),  
     *       @OA\Property(property="average_rating", type="string", example="null"),  
     *        )
     *     ),
     * 
     * @OA\Response(
     *    response=422,
     *    description="Fields are required",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="fields are required")
     *        )
     *     ),
     * 
     * @OA\Response(
     *    response=404,
     *    description="Book not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="book does not exist")
     *        )
     *     ),
     * 
     * @OA\Response(
     *          response=403,
     *          description="Access forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="You don't have access to update this book: The Lone Wolf!"),
     *              )
     *       ),
     * )
     */
    public function update(Request $request, $id)
    {
        return $this->bookInterface->updateBook($request, $id);
    }

    /**
     * @OA\Get(
     *      path="/book/{id}",
     *      operationId="getBookDetail",
     *      tags={"Books"},
     *      summary="Get a book detail",
     *      description="Returns detail of a particular book",
     *      @OA\Response(
     *          response=200,
     *          description="Book detail:",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="title", type="string", example="The Lone Wolf"),
     *              @OA\Property(property="author", type="string", example="Jake Fox"),
     *              @OA\Property(property="username", type="string", example="Olaide"),
     *              @OA\Property(property="average_rating", type="integer", example="3.5"),
     *              )
     *       ),
     * 
     *      @OA\Response(
     *          response=404,
     *          description="Book not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="book does not exist"),
     *              )
     *       ),
     *     )
     */
    public function detail($id)
    {
        return $this->bookInterface->getBookById($id);
    }

    /**
     * @OA\Delete(
     *      path="/book/{id}",
     *      operationId="deleteBook",
     *      tags={"Books"},
     *      summary="Delete a book",
     *      description="Delete a book along with it's ratings",
     *      @OA\Response(
     *          response=204,
     *          description="No content",
     *       ),
     * 
     *      @OA\Response(
     *          response=404,
     *          description="Book not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="book does not exist"),
     *              )
     *       ),
     * 
     *     @OA\Response(
     *          response=403,
     *          description="Access forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="You don't have access to delete this book: The Lone Wolf!"),
     *              )
     *       ),
     *     )
     */
    public function delete(Request $request, $id)
    {
        return $this->bookInterface->deleteBook($request, $id);
    }
}
