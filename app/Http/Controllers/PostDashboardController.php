<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->where('author_id', Auth::user()->id);

        if (request('keyword')) {
            $posts->where('tittle', 'like', '%' . request('keyword') . '%');
        }

        return view('dashboard.index', ['posts' => $posts->paginate(10)->withQueryString()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        // $request->validate([
        //     'tittle' => 'required|unique:posts',
        //     'category_id' => 'required',
        //     'body' => 'required'
        // ]);

        Validator::make($request->all(), [
            'tittle' => 'required|unique:posts',
            'category_id' => 'required',
            'body' => 'required|min:20'
        ], [
            // semua rule required error messagenya sama
            'required' => 'Kolom :attribute harus diisi!',

            // tiap rule require punya error message sendiri
            // 'tittle.required' => 'judul harus diisi'
            // 'category_id.required' => 'wajib pilih kategori'
            'body.min' => 'tulisan minimal 20 karakter'
        ], [
            'tittle' => 'judul',
            'category_id' => 'kategori',
            'body' => 'tulisan blog'
        ])->validate();

        Post::create([
            'tittle' => $request->tittle,
            'author_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->tittle),
            'body' => $request->body
        ]);

        return redirect('/dashboard')->with(['success' => 'Post berhasil ditambah!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('dashboard.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('dashboard.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Validator::make($request->all(), [
            'tittle' => 'required|unique:posts,tittle' . $post->id,
            'category_id' => 'required',
            'body' => 'required'
        ], [
            'required' => 'Kolom :attribute harus diisi!'
        ], [
            'tittle' => 'judul',
            'category_id' => 'kategori',
            'body' => 'tulisan blog'
        ])->validate();

        $post->update([
            'tittle' => $request->tittle,
            'author_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->tittle),
            'body' => $request->body
        ]);

        return redirect('/dashboard')->with(['success' => 'Post berhasil diedit!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/dashboard')->with(['success' => 'Post berhasil dihapus!']);
    }
}
