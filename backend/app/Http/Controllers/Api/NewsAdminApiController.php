<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\NewsImageStorage;
use App\Support\NewsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * CRUD berita untuk panel admin Next.js.
 *
 * Dipisah dari NewsApiController (yang khusus membaca untuk situs publik) supaya
 * batasnya jelas: file ini hanya berisi aksi tulis, dan semuanya menuntut token
 * login yang sah.
 *
 *   POST   /api/berita        -> tambah
 *   PUT    /api/berita/{id}   -> ubah
 *   DELETE /api/berita/{id}   -> hapus
 */
class NewsAdminApiController extends Controller
{
    public function __construct(
        protected NewsRepository $news,
        protected NewsImageStorage $images,
    ) {}

    public function store(Request $request): JsonResponse
    {
        if (! $this->authorized($request)) {
            return response()->json(['message' => 'Tidak memiliki akses.'], 401);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'author' => ['nullable', 'string', 'max:100'],
            'date' => ['nullable', 'date'],
            'image' => $request->hasFile('image') ? ['nullable', 'image', 'max:5120'] : ['nullable', 'string', 'max:500'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'featured' => ['nullable', 'boolean'],
            'published' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->store($request->file('image'));
        }

        $post = $this->news->create($data);

        return response()->json([
            'message' => 'Berita berhasil ditambahkan.',
            'data' => $post,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        if (! $this->authorized($request)) {
            return response()->json(['message' => 'Tidak memiliki akses.'], 401);
        }

        $existing = $this->news->findById($id);
        if ($existing === null) {
            return response()->json(['message' => 'Berita tidak ditemukan.'], 404);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'author' => ['nullable', 'string', 'max:100'],
            'date' => ['nullable', 'date'],
            'image' => $request->hasFile('image') ? ['nullable', 'image', 'max:5120'] : ['nullable', 'string', 'max:500'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'featured' => ['nullable', 'boolean'],
            'published' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->store($request->file('image'));
        }

        $updated = $this->news->update($id, $data);
        if ($request->hasFile('image')) {
            $this->images->delete($existing['image'] ?? null);
        }

        return response()->json([
            'message' => 'Berita berhasil diperbarui.',
            'data' => $updated,
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        if (! $this->authorized($request)) {
            return response()->json(['message' => 'Tidak memiliki akses.'], 401);
        }

        $post = $this->news->findById($id);
        if ($post === null || ! $this->news->delete($id)) {
            return response()->json(['message' => 'Berita tidak ditemukan.'], 404);
        }
        $this->images->delete($post['image'] ?? null);

        return response()->json(['message' => 'Berita berhasil dihapus.']);
    }

    /**
     * Hanya token login yang sah boleh menulis.
     */
    protected function authorized(Request $request): bool
    {
        return AuthApiController::adminFromToken($request->header('Authorization')) !== null;
    }
}
