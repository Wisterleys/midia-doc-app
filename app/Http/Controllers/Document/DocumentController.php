<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Document\IDocumentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentController extends Controller
{
    const PAGINATION_LIMIT = 10;
    protected $documentRepository;

    public function __construct(IDocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $params = $request->all();
        $params['user_id'] = Auth::id();

        $documents = $this->documentRepository
            ->all(
                $params
            );

        $documents = $documents->paginate(
            self::PAGINATION_LIMIT
        );

        return view('dashboard-doc', compact('documents', 'search'));
    }

    public function create()
    {
        $document = false;
        return view('documents.create-edit', compact('document'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_document' => 'required|string|regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/',
            'user_role' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'processor' => 'required|string|max:255',
            'memory' => 'required|string|max:50',
            'disk' => 'required|string|max:50',
            'price' => 'required|string|max:50',
            'price_string' => 'required|string|max:255',
            'local' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        
        // Adiciona o ID do usuário logado
        $params = $request->all();
        // Converte para decimal padrão se vier como "1.234,56"
        $params['price'] = floatval(str_replace(['.', ','], ['', '.'], $params['price']));
        $params['user_id'] = Auth::id();
        //dd($params);

        // Cria o produto (documento)
        $result = $this->documentRepository->create($params);

        return redirect()->route('dashboard')->with('success', 'Produto criado com sucesso!');
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

        return redirect()->route('documents.index')->with('success', 'Documento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $this->documentRepository->delete($id);
        return redirect()->route('documents.index')->with('success', 'Documento removido com sucesso!');
    }

    public function download($id, $format = 'docx')
    {
        $document = $this->documentRepository->find($id);
        
        // Implementar a lógica de geração do documento
        $filePath = $this->generateDocumentFile($document, $format);
        
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    protected function generateDocumentFile($document, $format)
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