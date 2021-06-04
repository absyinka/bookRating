<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface IBookInterface
{
    public function getAllBooks();

    public function getBookById($id);

    public function createBook(Request $request);

    public function updateBook(Request $request, $id);

    public function deleteBook(Request $request, $id);
}
