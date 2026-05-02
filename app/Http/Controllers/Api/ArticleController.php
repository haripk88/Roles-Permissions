<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:article view')->only(['index', 'show']);
        $this->middleware('permission:article create')->only(['create', 'store']);
        $this->middleware('permission:article edit')->only(['edit', 'update']);
        $this->middleware('permission:article delete')->only(['destroy']);
    }


    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(10);
        return view('article.list', ['articles' => $articles]);
    }


    public function create()
    {
        return view('article.create');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|min:5',
            'content' => 'nullable|string',
            'author' => 'required|string|max:255',
        ]);

        Article::create($validatedData);

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }


    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('article.show', ['article' => $article]);
    }


    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('article.edit', ['article' => $article]);
    }


    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|min:5',
            'content' => 'nullable|string',
            'author' => 'required|string|max:255',
        ]);

        $article->update($validatedData);

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }


    public function destroy(Request $request)
    {
        $id = $request->id;

        $article = Article::find($id);

        if ($article == null) {
            session()->flash('error', 'Article not found.');
            return response()->json(['error' => 'Article not found.', 'status' => false], 404);
        }
        $article->delete();
        session()->flash('success', 'Article deleted successfully.');

        return response()->json(['success' => 'Article deleted successfully.', 'status' => true], 200);
    }
}
