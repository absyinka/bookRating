<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Traits\ResponseAPI;
use App\Models\Book;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RatingResource;
use App\Interfaces\IRatingInterface;

class RatingRepository implements IRatingInterface
{
    use ResponseAPI;

    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Add a rating
     * 
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function createRating(Request $request, Book $book)
    {
        $data = $request->only('rating');

        $validator = Validator::make($data, [
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        $rating = new Rating;

        $rating->user_id = $request->user()->id;
        $rating->rating = $request->rating;

        $book->ratings()->save($rating);

        return $this->success("Rating added successfully", new RatingResource($rating));
    }

    /**
     * Update the specified rating in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function updateRating(Request $request, $book_id, $id)
    {
        $rating = Rating::find($id);

        $book = Book::find($book_id);

        $data = $request->only('rating');

        $validator = Validator::make($data, [
            'rating' => 'required|numeric|min:0|max:5'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        if (!$rating || !$book) return $this->error("Rating or book does not exist", 404);

        if ($request->user()->id !== $rating->user_id) return $this->error("You don't have access to edit this rating!", 403);

        $rating->save();

        return $this->success("Rating updated successfully", new RatingResource($rating));
    }

    /**
     * Remove the specified rating from storage.
     *
     * @param  \App\Models\Rating  $book
     * @return \Illuminate\Http\Response
     */
    public function deleteRating($book_id, $id)
    {
        $rating = Rating::find($id);

        $book = Book::find($book_id);

        if (!$rating || !$book) return $this->error("Rating or book does not exist", 404);

        if (!$rating && !$book) return $this->error("Rating and book does not exist", 404);

        if (auth()->user()->id != $book->user_id)  return $this->error("You don't have access to delete this rating!", 403);

        $rating->delete();

        return $this->success("Rating deleted", null, 204);
    }
}
