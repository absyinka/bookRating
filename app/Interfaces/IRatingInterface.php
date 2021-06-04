<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Models\Book;

interface IRatingInterface
{
    public function createRating(Request $request, Book $book);

    public function updateRating(Request $request, $book_id, $id);

    public function deleteRating($book_id, $id);
}
