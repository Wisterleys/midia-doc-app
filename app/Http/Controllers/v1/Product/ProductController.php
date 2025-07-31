<?php

namespace App\Http\Controllers\v1\Product;

use App\Http\Controllers\Controller;
use App\Repositories\Contract\ProductRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->middleware('auth');
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $documents = $search 
            ? $this->documentRepository->search($search)
            : $this->documentRepository->all();
            
        return view('documents.index', compact('documents', 'search'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'hardware_data' => 'required|array',
            'accessories_data' => 'nullable|array',
        ]);

        $this->documentRepository->create($validated);

        return redirect()->route('documents.index')->with('success', 'Producto criado com sucesso!');
    }

    public function show($id)
    {
        $document = $this->documentRepository->find($id);
        return view('documents.show', compact('document'));
    }

    public function edit($id)
    {
        $document = $this->documentRepository->find($id);
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'hardware_data' => 'required|array',
            'accessories_data' => 'nullable|array',
        ]);

        $this->documentRepository->update($id, $validated);

        return redirect()->route('documents.index')->with('success', 'Producto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $this->documentRepository->delete($id);
        return redirect()->route('documents.index')->with('success', 'Producto removido com sucesso!');
    }

    public function download($id, $format = 'docx')
    {
        $document = $this->documentRepository->find($id);
        
        // Implementar a lógica de geração do documento
        $filePath = $this->generateProductFile($document, $format);
        
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    protected function generateProductFile($document, $format)
    {
        // Implementar usando PHPWord para DOCX e DomPDF para PDF
        // Esta é uma implementação simplificada - você precisará adaptar
        
        $templatePath = resource_path('templates/Anexo1.docx');
        $tempPath = storage_path('app/temp/' . uniqid() . '.' . $format);
        
        // 1. Copiar o template
        copy($templatePath, $tempPath);
        
        // 2. Processar o documento (substituir placeholders)
        // Usando PHPWord (instale com composer require phpoffice/phpword)
        
        // 3. Se for PDF, converter usando DomPDF
        
        return $tempPath;
    }
}