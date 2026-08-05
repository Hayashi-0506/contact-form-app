<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\Paginator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $keyword = $request->input('keyword');
        $gender = $request->input('gender');
        $category_id = $request->input('category_id');
        $date = $request->input('date');
        $page = $request->input('page') ?? 1;
        $per_page = $request->input('per_page') ?? 20;

        $query = Contact::query()->with(['category', 'tags']);

        $query->when($keyword, function ($query, $keyword) {
            return $query->where('first_name', 'like', "%{$keyword}%")
                ->orWhere('last_name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%");
        })->when($gender, function ($query, $gender) {
            return $query->where('gender', $gender);
        })->when($category_id, function ($query, $category_id) {
            return $query->where('category_id', $category_id);
        })->when($date, function ($query, $date) {
            return $query->whereDate('updated_at', $date);
        });

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        return ContactResource::collection($query->paginate($per_page));
    }
}
