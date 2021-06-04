<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Interfaces\IBookInterface;
use App\Traits\ResponseAPI;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BookResource;

class BookRepository implements IBookInterface
{
    use ResponseAPI;

    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of all books.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllBooks()
    {
        return $this->success("All Books: ", BookResource::collection(Book::with('ratings')->get()));
    }

    /**
     * Create a book
     * 
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function createBook(Request $request)
    {
        $data = $request->only('title', 'author');

        $validator = Validator::make($data, [
            'title' => 'required|string',
            'author' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        $book = new Book;

        $book->user_id = $request->user()->id;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->save();

        return $this->success("Book created successfully", new BookResource($book));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function getBookById($id)
    {
        $book = Book::find($id);

        if (!$book) return $this->error("No book with ID: $id exist", 404);

        return $this->success("Book detail:", new BookResource($book));
    }

    /**
     * Update the specified book in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function updateBook(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) return $this->error("Book does not exist", 404);

        if ($request->user()->id !== $book->user_id) return $this->error("You don't have access to edit this book: $book->title!", 403);

        $book->update($request->only(['title', 'author']));

        $data = $request->only('title', 'author');

        $validator = Validator::make($data, [
            'title' => 'required|string',
            'author' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        return $this->success("Book updated successfully", new BookResource($book));
    }

    /**
     * Remove the specified book from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function deleteBook(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) return $this->error("Book does not exist", 404);

        if ($request->user()->id != $book->user_id)  return $this->error("You don't have access to delete this book: $book->title!", 403);

        $book->delete();

        return $this->success("Book deleted", null, 204);
    }
}
