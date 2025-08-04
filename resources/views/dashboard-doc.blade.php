<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mídia Simples Doc - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #2563eb 100%);
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }
        .document-card {
            transition: all 0.2s ease;
        }
        .document-card:hover {
            background: #f8fafc;
            border-left: 4px solid #4f46e5;
        }
        .dropdown-enter {
            opacity: 0;
            transform: scale(0.95);
        }
        .absolute{
            z-index: 30000 !important;
        }
        .dropdown-enter-active {
            opacity: 1;
            transform: scale(1);
            transition: all 0.2s ease;
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="hero-gradient shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl font-bold text-white">Mídia Simples</span>
                            <span class="text-lg font-medium text-white/90 ml-1">Doc</span>
                        </div>
                    </div>
                    <nav class="flex items-center space-x-4" x-data="{ userMenu: false }">
                        <div class="relative">
                            <button @click="userMenu = !userMenu" class="flex items-center space-x-3 text-white/90 hover:text-white transition-colors duration-200 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-lg hover:bg-white/20">
                                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">
                                    {{ Auth::user()->name }}
                                </span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="userMenu" @click.away="userMenu = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 py-2 z-10">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center space-x-3">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Perfil</span>
                                </a>
                                <div class="h-px bg-gray-200 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center space-x-3">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>Sair</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Welcome Card -->
            <div class="card-hover bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500/10 to-purple-500/10 px-6 py-8 sm:px-8">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                        <div class="flex items-start space-x-4">
                            <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Bem-vindo de volta!</h3>
                                <p class="text-gray-600 leading-relaxed max-w-2xl">
                                    Gerencie seus documentos de forma simples e segura. Crie, edite e baixe seus formulários em diferentes formatos.
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 sm:mt-0 sm:ml-4 flex-shrink-0">
                            <a href="{{ route('documents.create') }}" class="btn-primary inline-flex items-center px-6 py-3 text-sm font-semibold text-white rounded-xl shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Novo Documento
                            </a>
                        </div>
                    </div>
                </div>
            </div>

<!-- Search Filter -->
<div class="card-hover bg-white shadow-lg rounded-2xl border border-gray-100 p-6 mb-8">
    <form method="GET" action="{{ route('dashboard') }}">
        <div class="flex flex-col md:flex-row items-center gap-4">
            <!-- Campo de pesquisa único e inteligente -->
            <div class="flex-1 w-full">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200" 
                        placeholder="Pesquise por documento, funcionário, notebook, CPF ou data (YYYY-MM-DD)..."
                        value="{{ request('search') }}"
                        aria-label="Campo de pesquisa inteligente"
                    >
                    <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Dica: Pesquise por qualquer termo relacionado - nome, modelo, serial, CPF ou data
                </p>
            </div>
            
            <!-- Botões de ação -->
            <div class="flex items-center gap-2 w-full md:w-auto">
                <button 
                    type="submit" 
                    class="btn-primary flex items-center justify-center gap-2 px-6 py-3 font-semibold text-white rounded-xl shadow-lg w-full md:w-auto"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="hidden md:inline">Pesquisar</span>
                </button>
                
                <a 
                    href="{{ route('dashboard') }}" 
                    class="px-4 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:border-gray-400 hover:bg-gray-50 transition-all duration-200 flex items-center justify-center"
                    title="Limpar pesquisa"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </a>
            </div>
        </div>
    </form>
</div>

            <!-- Documents List -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-900">Meus Documentos</h3>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-medium">{{ count($documents) }} documentos</span>
                        </div>
                    </div>
                </div>
                
                <!-- Empty State -->
                 @if($documents->isEmpty())
                <div class="px-6 py-16 text-center" style="display: block;">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhum documento encontrado</h3>
                    <p class="text-gray-500 mb-8 max-w-sm mx-auto">Comece criando um novo documento para organizar suas informações.</p>
                    <a href="{{ route('documents.create') }}" class="btn-primary inline-flex items-center px-6 py-3 font-semibold text-white rounded-xl shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Criar Primeiro Documento
                    </a>
                </div>
                @endif
                <!-- Documents List -->
                  @if($documents->isNotEmpty())
                    @foreach($documents as $document)
                        <div class="document-card px-6 py-5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="p-3 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl">
                                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">Termo de Responsabilidade - {{ $document['employee_name'] }}</h4>
                                        <div class="flex items-center space-x-6 mt-2 text-sm text-gray-500">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                <span>{{ $document['employee_role'] }}</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                                <span>{{ $document['employee_cpf'] }}</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>Criado em {{ \Carbon\Carbon::parse($document['date'])->format('d/m/Y') }}</span>
                                            </div>
                                        </div>
                                        <!-- Adicionando informações do notebook -->
                                        <div class="mt-2 text-sm text-gray-500">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                                </svg>
                                                <span>{{ $document['notebook_brand'] }} {{ $document['notebook_model'] }} ({{ $document['notebook_serial_number'] }})</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <!-- Download Dropdown -->
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" class="inline-flex items-center px-4 py-2 border-2 border-gray-200 text-gray-700 rounded-lg hover:border-indigo-300 hover:text-indigo-600 transition-all duration-200 font-medium">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Download
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 py-2 z-10">
                                            <a href="{{ route('documents.download', ['id' => $document['id'], 'format' => 'docx']) }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                DOCX
                                            </a>
                                            <a href="{{ route('documents.download', ['id' => $document['id'], 'format' => 'pdf']) }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>
                                                PDF
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('documents.edit', $document['id']) }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-all duration-200 font-medium">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Editar
                                    </a>
                                    
                                    <form action="{{ route('documents.destroy', $document['id']) }}" method="POST" class="inline" id="delete-form-{{ $document['id'] }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-all duration-200 font-medium" 
                                                onclick="confirmDelete(event, 'delete-form-{{ $document['id'] }}')">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    <div class="px-6 py-10">
                            
                        </div>
                    @endif
                </div>

        @if ($documents->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div></div>
                <div class="flex items-center space-x-2">
                {!! $documents->withQueryString()->onEachSide(1)->links('vendor.pagination.tailwind') !!}
                </div>
            </div>
        </div>
        @endif
           <div style="width: 100%;height: 30%;"></div>
            </div>
        </main>
    </div>

<script>
    function confirmDelete(event, formId) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Tem certeza que deseja remover este registro?',
            text: 'Esta ação é irreversível!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, quero remover!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
</body>
</html>