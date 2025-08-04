<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Document\IDocumentRepository;
use App\Repositories\Contracts\Notebook\INotebookRepository;
use App\Repositories\Contracts\Accessory\IAccessoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;

class DocumentController extends Controller
{
    const PAGINATION_LIMIT = 10;
    protected $documentRepository;
    protected $notebookRepository;
    protected $accessoryRepository;

    public function __construct(
        IDocumentRepository $documentRepository,
        INotebookRepository $notebookRepository,
        IAccessoryRepository $accessoryRepository
    )
    {
        $this->documentRepository = $documentRepository;
        $this->notebookRepository = $notebookRepository;
        $this->accessoryRepository = $accessoryRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $params = $request->all();
        $params['user_id'] = Auth::id();

        $documents = $this->documentRepository
            ->allUserDocuments(
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

        $notebooks = $this->notebookRepository
            ->allNotebooks()
            ->get()
            ->toArray();
        $accessories = $this->accessoryRepository
            ->allAccessories()
            ->get()
            ->toArray();

        $user = Auth::user()->load('employee'); 
        $employee = $user->employee;

        return view(
            'documents.create-edit', 
            compact(
                'document',
                'notebooks', 
                'accessories',
                'employee'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'local' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $params = $request->all();
        
        $user = Auth::user()->load('employee'); 
        $params['employee_id'] = $user->employee->id;

        $result = $this->documentRepository->create($params);

        return redirect()->route('dashboard')->with('success', 'Produto criado com sucesso!');
    }

    public function edit($id)
    {
        $document = $this->documentRepository
            ->findDocumentById(
                $id, 
                [
                    'employee',
                    'notebook.accessories'
                ]
            );

        if (is_null($document)) {
            return redirect()->route('dashboard')
                ->with('error', 'Documento não encontrado');
        }

        $employee = $document->employee;

        $notebooks = $this->notebookRepository
            ->allNotebooks()
            ->get()
            ->toArray();
        $accessories = $this->accessoryRepository
            ->allAccessories()
            ->get()
            ->toArray();

        return view(
            'documents.create-edit', 
            compact(
                'document',
                'notebooks', 
                'accessories',
                'employee'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'notebook_id' => 'required|integer|exists:notebooks,id',
            'local' => 'required|string|max:255',
            'date' => 'required|date|date_format:Y-m-d',
            'accessories_ids' => 'nullable|array',
            'accessories_ids.*' => 'integer|exists:accessories,id'
        ]);

        if (!isset($validated['accessories_ids'])) {
            $validated['accessories_ids'] = [];
        }

        $this->documentRepository
            ->update(
                $id, 
                $validated
            );

        return redirect()->route('dashboard')->with('success', 'Documento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $this->documentRepository->delete($id);
        return redirect()->route('dashboard')->with('success', 'Documento removido com sucesso!');
    }


    public function downloadFilledDocument($id, $format)
    {
        try {
            $document = $this->documentRepository->findDocumentById($id);
            
            if ($document->employee_id !== Auth::user()->employee->id) {
                abort(403, 'Você não tem permissão para baixar este documento.');
            }
            
            $document->load('notebook.accessories');

            $template_path = resource_path('templates/anexo1.docx');
            
            if (!file_exists($template_path)) {
                throw new \Exception('Template não encontrado: ' . $template_path);
            }

            $temp_path = tempnam(sys_get_temp_dir(), 'doc_') . '.docx';

            $template = new TemplateProcessor($template_path);

            $template->setValues([
                'user_name' => $document->employee->name ?: 'Nome não informado',
                'user_role' => $document->employee->role ?: 'Função não informada', 
                'user_document' => $document->employee->cpf ?: 'CPF não informado',
                'product_brand' => $document->notebook->brand ?: 'Marca não informada',
                'product_model' => $document->notebook->model ?: 'Modelo não informado',
                'product_serial_number' => $document->notebook->serial_number ?: 'Série não informada',
                'product_processor' => $document->notebook->processor ?? 'Processador não informado',
                'product_memory' => $document->notebook->memory ?? 'Memória não informada',
                'product_disk' => $document->notebook->disk ?? 'Disco não informado',
                'product_price' => number_format($document->notebook->price ?? 0, 2, ',', '.'),
                'product_price_string' => $document->notebook->price_string ?? 'Valor não informado',
                'local' => $document->local ?: 'Local não informado',
                'date' => $document->date ? \Carbon\Carbon::parse($document->date)->format('d/m/Y') : date('d/m/Y'),
                'accessories_table' => $this->generateAccessoriesTableText($document)
            ]);

            $template->saveAs($temp_path);

            if (!file_exists($temp_path) || filesize($temp_path) === 0) {
                throw new \Exception('Falha ao gerar o documento.');
            }

            if ($format === 'pdf') {
                return $this->generatePdf($temp_path, $document);
            } else {
                $filename = "Termo_Responsabilidade_{$document->id}.docx";
                
                return response()->download(
                    $temp_path,
                    $filename,
                    [
                        'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    ]
                )->deleteFileAfterSend(true);
            }

        } catch (\Exception $e) {
            \Log::error('Erro no download do documento: ' . $e->getMessage(), [
                'document_id' => $id,
                'format' => $format,
                'user_id' => Auth::id()
            ]);
            
            if (isset($temp_path) && file_exists($temp_path)) {
                unlink($temp_path);
            }

            return back()->with('error', 'Erro ao gerar documento: ' . $e->getMessage());
        }
    }

    private function generateAccessoriesTableText($document)
    {
        try {
            if (
                !$document->notebook || 
                !$document->notebook->accessories || 
                $document->notebook->accessories->isEmpty()
            ) {
                return "";
            }

            $text = "\n\nACESSÓRIOS E PERIFÉRICOS ENTREGUES:\n\n";
            
            foreach ($document->notebook->accessories as $index => $accessory) {
                $text .= sprintf(
                    "%d. %s\n   Descrição: %s\n   Marca: %s\n\n",
                    $index + 1,
                    $accessory->name ?: 'Nome não informado',
                    $accessory->description ?: 'Descrição não informada',
                    $accessory->brand ?: 'Marca não informada'
                );
            }
            
            return $text;
            
        } catch (\Exception $e) {
            \Log::warning('Erro ao gerar tabela de acessórios: ' . $e->getMessage());
            return "";
        }
    }

    private function generatePdf($docx_path, $document)
    {
        try {
            $php_word = \PhpOffice\PhpWord\IOFactory::load($docx_path);
            
            $html_writer = \PhpOffice\PhpWord\IOFactory::createWriter($php_word, 'HTML');
            
            ob_start();
            $html_writer->save('php://output');
            $html_content = ob_get_clean();
            
            $html_content = $this->cleanHtmlForPdf($html_content);
            
            $options = new \Dompdf\Options();
            $options->set('defaultFont', 'Arial');
            $options->set('isRemoteEnabled', false);
            $options->set('isHtml5ParserEnabled', true);
            
            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($html_content);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            if (file_exists($docx_path)) {
                unlink($docx_path);
            }
            
            $filename = "Termo_Responsabilidade_{$document->id}.pdf";
            
            return response()->streamDownload(
                function () use ($dompdf) {
                    echo $dompdf->output();
                },
                $filename,
                [
                    'Content-Type' => 'application/pdf',
                ]
            );
            
        } catch (\Exception $e) {
            \Log::error('Erro na geração do PDF: ' . $e->getMessage());
            
            if (isset($docx_path) && file_exists($docx_path)) {
                unlink($docx_path);
            }
            
            throw new \Exception('Erro ao converter documento para PDF: ' . $e->getMessage());
        }
    }

    private function cleanHtmlForPdf($html)
    {
        $html = preg_replace('/<o:p\s*\/?>/', '', $html);
        $html = preg_replace('/<\/o:p>/', '', $html);
        $html = str_replace('&nbsp;', ' ', $html);
        
        $css = '
        <style>
            body { 
                font-family: Arial, sans-serif; 
                font-size: 12px; 
                line-height: 1.4;
                margin: 20px;
            }
            table { 
                border-collapse: collapse; 
                width: 100%; 
                margin: 10px 0;
            }
            table, th, td { 
                border: 1px solid #000; 
            }
            th, td { 
                padding: 8px; 
                text-align: left; 
            }
            th { 
                background-color: #f2f2f2; 
                font-weight: bold;
            }
            .signature-table {
                margin-top: 30px;
            }
            .signature-table td {
                height: 60px;
                vertical-align: bottom;
                border-bottom: 1px solid #000;
                border-left: none;
                border-right: none;
                border-top: none;
            }
        </style>';
        
        if (strpos($html, '<head>') !== false) {
            $html = str_replace('<head>', '<head>' . $css, $html);
        }

        $html = (strpos($html, '<head>') !== false) ? $html : $css . $html;

        return $html;
    }

}