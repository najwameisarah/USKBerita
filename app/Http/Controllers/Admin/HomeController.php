<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'role:Admin']);
    }
    
    public function index()
    {
        $articles = Article::all();
        return view('admin.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg']
        ]);

        // Cek apakah ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('images'), $fileName);
            $image_path = 'images/' . $fileName;
        } else {
            $image_path = null; // Jika tidak ada gambar
        }

        // Buat artikel baru dengan atau tanpa gambar
        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'image' => $image_path
        ]);

        return redirect()->route('admin.index')->with('status', 'Article created successfully.');
    }



    public function show($id)
    {
        $article = Article::find($id);
        return view('admin.show', compact('article'));
    }
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return redirect()->route('admin.index')->with('status', 'Article deleted successfully!');
    }
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all(); // Ambil semua kategori
        return view('admin.edit', compact('article', 'categories'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article = Article::findOrFail($id);
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->save();

        return redirect()->route('admin.index')->with('status', 'Article updated successfully!');
    }
}