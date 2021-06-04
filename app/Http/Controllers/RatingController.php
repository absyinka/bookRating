<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\IRatingInterface;
use App\Models\Book;

/**
 * @group State
 *
 * API endpoints for managing state
 */
class RatingController extends Controller
{
    protected $ratingInterface;

    public function __construct(IRatingInterface $ratingInterface)
    {
        $this->ratingInterface = $ratingInterface;
    }

    /**
     * @OA\Post(
     * path="/rating/{book}",
     * summary="Add a rating",
     * description="Add rating to a book",
     * operationId="addRating",
     * tags={"Rating"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Add a rating",
     *    @OA\JsonContent(
     *       required={"rating"},
     *       @OA\Property(property="rating", type="integer", example="4"),
     *    ),
     * ),
     * 
     * @OA\Response(
     *    response=200,
     *    description="Rating added successfully!",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="integer", example="1"),
     *       @OA\Property(property="user_id", type="integer", example="1"),
     *       @OA\Property(property="book_id", type="integer", example="4"),
     *       @OA\Property(property="rating", type="integer", example="3"),
     *       @OA\Property(property="book_title", type="string", example="The Lone Wolf"),
     *       @OA\Property(property="book_author", type="string", example="Lionel Jones"),  
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
    public function create(Request $request, Book $book)
    {
        return $this->ratingInterface->createRating($request, $book);
    }

    /**
     * @OA\Put(
     * path="/rating/{book_id}/{id}",
     * summary="Update rating",
     * description="Update rating on a book",
     * operationId="updateRating",
     * tags={"Rating"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Update book rating",
     *    @OA\JsonContent(
     *       required={"rating"},
     *       @OA\Property(property="rating", type="integer", example="5"),
     *    ),
     * ),
     * 
     * @OA\Response(
     *    response=200,
     *    description="Rating updated successfully!",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="integer", example="1"),
     *       @OA\Property(property="user_id", type="integer", example="1"),
     *       @OA\Property(property="book_id", type="integer", example="4"),
     *       @OA\Property(property="rating", type="integer", example="4.5"),
     *       @OA\Property(property="book_title", type="string", example="The Lone Wolf"),
     *       @OA\Property(property="book_author", type="string", example="Lionel Jones"),  
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
     *    description="Rating or book not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="rating or book does not exist")
     *        )
     *     ),
     * 
     * @OA\Response(
     *          response=403,
     *          description="Access forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="You don't have access to edit this rating!"),
     *              )
     *       ),
     * )
     */
    public function update(Request $request, $book_id, $id)
    {
        return $this->ratingInterface->updateRating($request, $book_id, $id);
    }


    /**
     * @OA\Delete(
     * path="/rating/{book_id}/{id}",
     * summary="Delete rating",
     * description="Delete rating on a book",
     * operationId="deleteRating",
     * tags={"Rating"},
     * description="Delete book rating",
     * 
     * @OA\Response(
     *     response=204,
     *     description="No content",
     *  ),
     * 
     * @OA\Response(
     *    response=404,
     *    description="Rating or book not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="rating or book does not exist")
     *        )
     *     ),
     * 
     * @OA\Response(
     *          response=403,
     *          description="Access forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="You don't have access to delete this rating!"),
     *              )
     *       ),
     * )
     */
    public function delete($book_id, $id)
    {
        return $this->ratingInterface->deleteRating($book_id, $id);
    }
}
