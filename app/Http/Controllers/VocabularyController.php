<?php

namespace App\Http\Controllers;

use App\Http\Requests\VocabularyRequest;
use App\Models\Vocabulary;
use Illuminate\Http\JsonResponse;

class VocabularyController extends Controller
{
    private function getSecurity( Vocabulary $vocab)
    {
        if($vocab->user_id !== auth()->id()){
            abort(403, 'Forbidden');
        }

        return $vocab;
    }

    public function index(): JsonResponse
    {
        return response()->json(auth()->user()->vocabularies()->latest()->get(), 200);
    }

    public function store(VocabularyRequest $request): JsonResponse
    {
        $vocab = auth()->user()->vocabularies()->create($request->validated());
        return response()->json($vocab, 201);
    }

    public function show(Vocabulary $vocab):JsonResponse
    {
        
        $vocab = $this->getSecurity($vocab);
        return response()->json($vocab, 200);
    }

    public function update(VocabularyRequest $request, Vocabulary $vocab): JsonResponse
    {
        $vocab = $this->getSecurity($vocab);
        $vocab->update($request->validated());
        return response()->json($vocab, 200);
    }

    public function destroy(Vocabulary $vocab)
    {
        $vocab = $this->getSecurity($vocab);

        $vocab->delete();
        return response()->json([
            'message'=>'Delete success'
        ], 200);
    }
}
