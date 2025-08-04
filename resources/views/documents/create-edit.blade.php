<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document ? 'Editar' : 'Criar' }} Documento - Mída Simples Doc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        window.backendData = {
            notebooks: @json($notebooks),
            accessories: @json($accessories),
            employee: @json($employee),
            @if($document)
                selectedNotebook: @json($document->notebook),
                selectedAccessories: @json($document->notebook->accessories ?? [])
            @else
                selectedNotebook: null,
                selectedAccessories: []
            @endif
        };
    </script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #2563eb 100%);
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
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
        .form-section {
            transition: all 0.3s ease;
        }
        .form-section:hover {
            transform: translateY(-2px);
        }
        .input-focus {
            transition: all 0.2s ease;
        }
        .input-focus:focus {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.1);
        }
        .preview-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px dashed #cbd5e1;
            transition: all 0.3s ease;
        }
        .preview-card:hover {
            border-color: #4f46e5;
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
        }
        .dropdown-menu {
            max-height: 200px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }
        .dropdown-menu::-webkit-scrollbar {
            width: 6px;
        }
        .dropdown-menu::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }
        .dropdown-menu::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .selected-item {
            animation: fadeInUp 0.3s ease-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .search-highlight {
            background-color: #fef3c7;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="hero-gradient shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <a href="/dashboard" class="p-2 bg-white/20 backdrop-blur-sm rounded-lg hover:bg-white/30 transition-all duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xl font-bold text-white">Mída Simples</span>
                                <span class="text-lg font-medium text-white/90 ml-1">Doc</span>
                            </div>
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
                                    {{ auth()->user()->name }}
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
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">
                            {{ $document ? 'Editar Documento' : 'Criar Novo Documento' }}
                        </h1>
                        <p class="text-gray-600">
                            {{ $document ? 'Atualize as informações do seu documento' : 'Preencha os campos abaixo para criar um novo documento' }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>Documento seguro</span>
                    </div>
                </div>
            </div>

<form action="{{ $document ? route('documents.update', $document->id) : route('documents.store') }}" method="POST" class="space-y-8" x-data="documentForm()">
    @csrf
    @if($document)
        @method('PATCH')
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Informações do Usuário -->
            <div class="form-section bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500/10 to-purple-500/10 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Dados do Usuário</h3>
                            <p class="text-sm text-gray-600">Identificação do colaborador</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="user_name" class="block text-sm font-semibold text-gray-700 mb-2">Nome *</label>
                            <input type="text" name="user_name" id="user_name" x-model="form.user_name" @input="updatePreview()"
                                   value="{{ $employee->name ?? old('user_name') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Nome completo" required disabled>
                        </div>
                        <div>
                            <label for="user_email" class="block text-sm font-semibold text-gray-700 mb-2">E-mail</label>
                            <input type="email" name="user_email" id="user_email" x-model="form.user_email"
                                   value="{{ Auth::user()->email ?? old('user_email') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="exemplo@dominio.com" disabled>
                        </div>
                        <div>
                            <label for="user_document" class="block text-sm font-semibold text-gray-700 mb-2">CPF *</label>
                            <input type="text" name="user_document" id="user_document" x-model="form.user_document" @input="updatePreview()"
                                   value="{{ $employee->cpf ?? old('user_document') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="000.000.000-00" required disabled>
                        </div>
                        <div>
                            <label for="user_role" class="block text-sm font-semibold text-gray-700 mb-2">Função *</label>
                            <input type="text" name="user_role" id="user_role" x-model="form.user_role" @input="updatePreview()"
                                   value="{{ $employee->role ?? old('user_role') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Ex: Analista, Gerente..." required disabled>
                        </div>
                        <div class="md:col-span-2">
                            <label for="local" class="block text-sm font-semibold text-gray-700 mb-2">Local de Assinatura *</label>
                            <input type="text" name="local" id="local" x-model="form.local"
                                   value="{{ $document->local ?? old('local') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Ex: São Paulo - SP" required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Data da Assinatura *</label>
                            <input type="date" name="date" id="date" x-model="form.date"
                                   value="{{ isset($document->date) ? $document->date->format('Y-m-d') : old('date') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seleção de Notebook -->
            <div class="form-section bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden" style="height: 30%;">
                <div class="bg-gradient-to-r from-green-500/10 to-teal-500/10 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Seleção de Notebook</h3>
                            <p class="text-sm text-gray-600">Escolha o notebook para este documento</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="relative" x-data="{ notebookOpen: false, notebookSearch: '' }">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Notebook Disponível *
                            <span class="text-xs font-normal text-gray-500 ml-1">(Pesquise por marca, modelo ou serial)</span>
                        </label>
                        
                        <!-- Notebook Dropdown Trigger -->
                        <button type="button" @click="notebookOpen = !notebookOpen" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-left flex items-center justify-between hover:border-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                :class="{ 'ring-2 ring-indigo-500 border-transparent': notebookOpen }">
                            <span x-text="selectedNotebook ? `${selectedNotebook.brand} ${selectedNotebook.model} - ${selectedNotebook.serial_number}` : 'Selecione um notebook'" 
                                  class="truncate" :class="{ 'text-gray-500': !selectedNotebook, 'text-gray-900': selectedNotebook }"></span>
                            <div class="flex items-center space-x-2">
                                <template x-if="selectedNotebook">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Selecionado
                                    </span>
                                </template>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': notebookOpen }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>

                        <!-- Notebook Dropdown Menu -->
                        <div x-show="notebookOpen" @click.away="notebookOpen = false" x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                             class="absolute z-10 mt-2 w-full bg-white border border-gray-200 rounded-xl shadow-lg">
                            
                            <!-- Search Input -->
                            <div class="p-3 border-b border-gray-100">
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <input type="text" x-model="notebookSearch" placeholder="Pesquisar notebook..." 
                                           class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
                                </div>
                            </div>

                            <!-- Notebook List -->
                            <div class="dropdown-menu">
                                <template x-for="notebook in filteredNotebooks(notebookSearch)" :key="notebook.id">
                                    <button type="button" @click="selectNotebook(notebook); notebookOpen = false" 
                                            class="w-full px-4 py-3 text-left hover:bg-gray-50 focus:bg-gray-50 border-b border-gray-100 last:border-b-0 transition-colors duration-150">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate" x-text="notebook.brand + ' ' + notebook.model"></p>
                                                        <div class="flex items-center space-x-4 mt-1">
                                                            <p class="text-xs text-gray-500" x-text="'Serial: ' + notebook.serial_number"></p>
                                                            <p class="text-xs text-gray-500" x-text="notebook.processor"></p>
                                                        </div>
                                                        <div class="flex items-center space-x-4 mt-1">
                                                            <span class="text-xs text-gray-500" x-text="notebook.memory + 'GB RAM'"></span>
                                                            <span class="text-xs text-gray-500" x-text="notebook.disk + 'GB Storage'"></span>
                                                            <span class="text-xs font-medium text-green-600" x-text="'R$ ' + notebook.price"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <template x-if="selectedNotebook && selectedNotebook.id === notebook.id">
                                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </template>
                                        </div>
                                    </button>
                                </template>

                                <!-- No Results -->
                                <template x-if="filteredNotebooks(notebookSearch).length === 0">
                                    <div class="px-4 py-8 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-sm">Nenhum notebook encontrado</p>
                                        <p class="text-xs text-gray-400 mt-1">Tente pesquisar por outro termo</p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Hidden Input -->
                        <input type="hidden" name="notebook_id" :value="selectedNotebook ? selectedNotebook.id : ''" required>
                    </div>

                    <!-- Selected Notebook Preview -->
                    <template x-if="selectedNotebook">
                        <div class="mt-4 p-4 bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 rounded-xl">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-blue-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Notebook Selecionado</h4>
                                    <div class="grid grid-cols-2 gap-3 text-xs">
                                        <div><span class="font-medium text-gray-700">Marca:</span> <span x-text="selectedNotebook.brand"></span></div>
                                        <div><span class="font-medium text-gray-700">Modelo:</span> <span x-text="selectedNotebook.model"></span></div>
                                        <div><span class="font-medium text-gray-700">Serial:</span> <span x-text="selectedNotebook.serial_number"></span></div>
                                        <div><span class="font-medium text-gray-700">Processador:</span> <span x-text="selectedNotebook.processor"></span></div>
                                        <div><span class="font-medium text-gray-700">RAM:</span> <span x-text="selectedNotebook.memory + 'GB'"></span></div>
                                        <div><span class="font-medium text-gray-700">Armazenamento:</span> <span x-text="selectedNotebook.disk + 'GB'"></span></div>
                                        <div><span class="font-medium text-gray-700">Valor:</span> <span class="font-semibold text-green-600" x-text="'R$ ' + selectedNotebook.price"></span></div>
                                        <div><span class="font-medium text-gray-700">Por Extenso:</span> <span x-text="selectedNotebook.price_string"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Seleção de Acessórios -->
            <div class="form-section bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-pink-500/10 to-purple-500/10 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-pink-500 to-purple-600 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Acessórios do Equipamento</h3>
                                <p class="text-sm text-gray-600">Adicione os acessórios que acompanham o notebook</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800" x-text="selectedAccessories.length + ' selecionado(s)'"></span>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <!-- Add Accessory Section -->
                    <div class="relative mb-6" x-data="{ accessoryOpen: false, accessorySearch: '' }">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Adicionar Acessório
                            <span class="text-xs font-normal text-gray-500 ml-1">(Pesquise e selecione para adicionar)</span>
                        </label>
                        
                        <!-- Accessory Dropdown Trigger -->
                        <button type="button" @click="accessoryOpen = !accessoryOpen" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-left flex items-center justify-between hover:border-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                :class="{ 'ring-2 ring-indigo-500 border-transparent': accessoryOpen }"
                                :disabled="availableAccessories.length === 0">
                            <span x-text="availableAccessories.length > 0 ? 'Selecione um acessório para adicionar' : 'Todos os acessórios foram adicionados'" 
                                  class="truncate" :class="{ 'text-gray-400': availableAccessories.length === 0, 'text-gray-500': availableAccessories.length > 0 }"></span>
                            <div class="flex items-center space-x-2">
                                <template x-if="availableAccessories.length > 0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800" x-text="availableAccessories.length + ' disponível(is)'"></span>
                                </template>
                                <template x-if="availableAccessories.length === 0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        Completo
                                    </span>
                                </template>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': accessoryOpen }" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>

                        <!-- Accessory Dropdown Menu -->
                        <template x-if="availableAccessories.length > 0">
                            <div x-show="accessoryOpen" @click.away="accessoryOpen = false" x-transition:enter="transition ease-out duration-200" 
                                 x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute z-10 mt-2 w-full bg-white border border-gray-200 rounded-xl shadow-lg">
                                
                                <!-- Search Input -->
                                <div class="p-3 border-b border-gray-100">
                                    <div class="relative">
                                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        <input type="text" x-model="accessorySearch" placeholder="Pesquisar acessório..." 
                                               class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
                                    </div>
                                </div>

                                <!-- Accessory List -->
                                <div class="dropdown-menu">
                                    <template x-for="accessory in filteredAccessories(accessorySearch)" :key="accessory.id">
                                        <button type="button" @click="addAccessory(accessory); accessoryOpen = false; accessorySearch = ''" 
                                                class="w-full px-4 py-3 text-left hover:bg-gray-50 focus:bg-gray-50 border-b border-gray-100 last:border-b-0 transition-colors duration-150">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-purple-600 rounded-lg flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate" x-text="accessory.name"></p>
                                                    <div class="flex items-center space-x-4 mt-1">
                                                        <template x-if="accessory.description">
                                                            <p class="text-xs text-gray-500 truncate" x-text="accessory.description"></p>
                                                        </template>
                                                        <template x-if="accessory.brand">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800" x-text="accessory.brand"></span>
                                                        </template>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </button>
                                    </template>

                                    <!-- No Results -->
                                    <template x-if="filteredAccessories(accessorySearch).length === 0">
                                        <div class="px-4 py-8 text-center text-gray-500">
                                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            <p class="text-sm">Nenhum acessório encontrado</p>
                                            <p class="text-xs text-gray-400 mt-1">Tente pesquisar por outro termo</p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Selected Accessories List -->
                    <div class="space-y-3">
                        <template x-if="selectedAccessories.length === 0">
                            <div class="text-center py-8 border-2 border-dashed border-gray-200 rounded-xl">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <p class="text-sm text-gray-500 mb-1">Nenhum acessório adicionado</p>
                                <p class="text-xs text-gray-400">Selecione acessórios na lista acima para adicionar</p>
                            </div>
                        </template>

                        <template x-for="(accessory, index) in selectedAccessories" :key="accessory.id">
                            <div class="selected-item bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-xl p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2 mb-1">
                                                <h4 class="text-sm font-semibold text-gray-900 truncate" x-text="accessory.name"></h4>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800" x-text="'#' + (index + 1)"></span>
                                            </div>
                                            <div class="flex items-center space-x-4 text-xs text-gray-600">
                                                <template x-if="accessory.description">
                                                    <span x-text="accessory.description"></span>
                                                </template>
                                                <template x-if="accessory.brand">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700" x-text="accessory.brand"></span>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" @click="removeAccessory(accessory.id)" 
                                            class="flex-shrink-0 p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                            title="Remover acessório">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                <!-- Hidden input for form submission -->
                                <input type="hidden" :name="'accessories_ids[]'" :value="accessory.id">
                            </div>
                        </template>
                    </div>

                    <!-- Summary -->
                    <template x-if="selectedAccessories.length > 0">
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Total de acessórios selecionados:</span>
                                <span class="font-semibold text-purple-600" x-text="selectedAccessories.length + ' item(ns)'"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Preview Section -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                <!-- Document Preview -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500/10 to-indigo-500/10 px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Prévia do Documento</h3>
                                <p class="text-sm text-gray-600">Como ficará o documento</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="preview-card rounded-xl p-6 mb-6" id="preview-content">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-sm text-gray-500 mb-2">Prévia em tempo real</p>
                                <p class="text-xs text-gray-400">Complete os campos para visualizar</p>
                            </div>
                        </div>
                        
                        <!-- Progress Indicator -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between text-sm mb-2">
                                <span class="text-gray-600">Progresso do formulário</span>
                                <span class="font-medium text-indigo-600" x-text="Math.round(getFormProgress()) + '%'"></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2 rounded-full transition-all duration-300" 
                                     :style="'width: ' + getFormProgress() + '%'"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>Incompleto</span>
                                <span>Completo</span>
                            </div>
                        </div>

                        <!-- Download Options -->
                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="text-sm font-semibold text-gray-700 mb-4">Formatos Disponíveis</h4>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="flex items-center p-3 bg-blue-50 rounded-lg border border-blue-200">
                                    <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-blue-900">DOCX</p>
                                        <p class="text-xs text-blue-600">Word</p>
                                    </div>
                                </div>
                                <div class="flex items-center p-3 bg-red-50 rounded-lg border border-red-200">
                                    <svg class="w-8 h-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-red-900">PDF</p>
                                        <p class="text-xs text-red-600">Adobe</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="space-y-4">
                        <button type="submit" class="btn-primary w-full px-6 py-4 font-semibold text-white rounded-xl shadow-lg flex items-center justify-center space-x-2"
                                :disabled="getFormProgress() < 100" :class="{ 'opacity-50 cursor-not-allowed': getFormProgress() < 100 }">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ $document ? 'Atualizar Documento' : 'Criar Documento' }}</span>
                        </button>
                        
                        <a href="/dashboard" class="w-full px-6 py-4 border-2 border-gray-300 text-gray-700 rounded-xl hover:border-gray-400 hover:bg-gray-50 transition-all duration-200 flex items-center justify-center space-x-2 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Cancelar</span>
                        </a>
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center space-x-2 text-xs text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span>Seus dados estão protegidos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

        </main>
    </div>
 
    <script>
        function documentForm() {
            return {
                // Form data
                form: {
                    user_name: '',
                    user_document: '', 
                    user_role: '',
                    user_email: '',
                    local: '',
                    date: ''
                },
                
                // Notebooks data (should come from backend)
                notebooks: window.backendData?.notebooks || [],
                
                // Accessories data (should come from backend)
                accessories: window.backendData?.accessories || [],
                
                // Selected items
                selectedNotebook: window.backendData?.selectedNotebook || null,
                selectedAccessories: window.backendData?.selectedAccessories || [],
                
                // Get available accessories (not selected yet)
                get availableAccessories() {
                    return this.accessories.filter(accessory => 
                        !this.selectedAccessories.some(selected => selected.id === accessory.id)
                    );
                },
                
                // Filter notebooks based on search
                filteredNotebooks(search) {
                    if (!search) return this.notebooks;
                    const searchLower = search.toLowerCase();
                    return this.notebooks.filter(notebook => 
                        notebook.brand.toLowerCase().includes(searchLower) ||
                        notebook.model.toLowerCase().includes(searchLower) ||
                        notebook.serial_number.toLowerCase().includes(searchLower) ||
                        notebook.processor.toLowerCase().includes(searchLower)
                    );
                },
                
                // Filter accessories based on search
                filteredAccessories(search) {console.log();
                    if (!search) return this.availableAccessories;
                    const searchLower = search.toLowerCase();
                    return this.availableAccessories.filter(accessory => 
                        accessory.name.toLowerCase().includes(searchLower) ||
                        (accessory.description && accessory.description.toLowerCase().includes(searchLower)) ||
                        (accessory.brand && accessory.brand.toLowerCase().includes(searchLower))
                    );
                },
                
                // Select notebook
                selectNotebook(notebook) {
                    this.selectedNotebook = notebook;
                    this.updatePreview();
                },
                
                // Add accessory
                addAccessory(accessory) {
                    this.selectedAccessories.push(accessory);
                    this.updatePreview();
                },
                
                // Remove accessory
                removeAccessory(accessoryId) {
                    this.selectedAccessories = this.selectedAccessories.filter(accessory => accessory.id !== accessoryId);
                    this.updatePreview();
                },
                
                // Calculate form progress
                getFormProgress() {
                    const requiredFields = ['user_name', 'user_document', 'user_role', 'local', 'date'];
                    const filledFields = requiredFields.filter(field => this.form[field] && this.form[field].trim() !== '').length;
                    const notebookSelected = this.selectedNotebook ? 1 : 0;
                    
                    const totalRequired = requiredFields.length + 1; // +1 for notebook
                    const totalFilled = filledFields + notebookSelected;
                    
                    return (totalFilled / totalRequired) * 100;
                },
                
                // Update preview
                updatePreview() {
                    const previewContent = document.getElementById('preview-content');
                    
                    if (this.form.user_name || this.form.user_document || this.form.user_role || this.selectedNotebook) {
                        let previewHtml = `
                            <div class="text-left">
                                <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Documento em Criação
                                </h4>
                                <div class="space-y-4">
                        `;
                        
                        // User info section
                        if (this.form.user_name || this.form.user_document || this.form.user_role) {
                            previewHtml += `
                                <div class="bg-blue-50 rounded-lg p-3">
                                    <h5 class="text-xs font-semibold text-blue-800 mb-2 uppercase tracking-wide">Usuário</h5>
                                    <div class="space-y-1 text-sm">
                            `;
                            if (this.form.user_name) previewHtml += `<p><span class="font-medium text-gray-700">Nome:</span> ${this.form.user_name}</p>`;
                            if (this.form.user_document) previewHtml += `<p><span class="font-medium text-gray-700">CPF:</span> ${this.form.user_document}</p>`;
                            if (this.form.user_role) previewHtml += `<p><span class="font-medium text-gray-700">Função:</span> ${this.form.user_role}</p>`;
                            previewHtml += `</div></div>`;
                        }
                        
                        // Notebook section
                        if (this.selectedNotebook) {
                            previewHtml += `
                                <div class="bg-green-50 rounded-lg p-3">
                                    <h5 class="text-xs font-semibold text-green-800 mb-2 uppercase tracking-wide">Notebook</h5>
                                    <div class="space-y-1 text-sm">
                                        <p><span class="font-medium text-gray-700">Equipamento:</span> ${this.selectedNotebook.brand} ${this.selectedNotebook.model}</p>
                                        <p><span class="font-medium text-gray-700">Serial:</span> ${this.selectedNotebook.serial_number}</p>
                                        <p><span class="font-medium text-gray-700">Valor:</span> <span class="font-semibold text-green-600">R$ ${this.selectedNotebook.price}</span></p>
                                    </div>
                                </div>
                            `;
                        }
                        
                        // Accessories section
                        if (this.selectedAccessories.length > 0) {
                            previewHtml += `
                                <div class="bg-purple-50 rounded-lg p-3">
                                    <h5 class="text-xs font-semibold text-purple-800 mb-2 uppercase tracking-wide">Acessórios (${this.selectedAccessories.length})</h5>
                                    <div class="space-y-1 text-xs">
                            `;
                            this.selectedAccessories.forEach((accessory, index) => {
                                previewHtml += `<p class="flex items-center"><span class="w-4 h-4 bg-purple-200 rounded-full flex items-center justify-center text-purple-700 font-bold mr-2 text-xs">${index + 1}</span>${accessory.name}</p>`;
                            });
                            previewHtml += `</div></div>`;
                        }
                        
                        previewHtml += `
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex items-center space-x-2 text-xs">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <span class="text-gray-600">Atualizando em tempo real</span>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        previewContent.innerHTML = previewHtml;
                    } else {
                        previewContent.innerHTML = `
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-sm text-gray-500 mb-2">Prévia em tempo real</p>
                                <p class="text-xs text-gray-400">Complete os campos para visualizar</p>
                            </div>
                        `;
                    }
                },
                
                // Initialize form
                init() {
                    // Load existing data if editing
                    this.form.user_name = document.getElementById('user_name').value;
                    this.form.user_document = document.getElementById('user_document').value;
                    this.form.user_role = document.getElementById('user_role').value;
                    this.form.user_email = document.getElementById('user_email').value;
                    this.form.local = document.getElementById('local').value;
                    this.form.date = document.getElementById('date').value;
                    
                    // Update preview on initialization
                    this.updatePreview();
                }
            }
        }

        // CPF Mask
        document.getElementById('user_document').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = ['user_name', 'user_document', 'user_role', 'local', 'date'];
            let isValid = true;
            
            // Check required text fields
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                const value = field.value.trim();
                
                if (!value) {
                    isValid = false;
                    field.classList.add('border-red-500', 'bg-red-50');
                    field.classList.remove('border-gray-300');
                } else {
                    field.classList.remove('border-red-500', 'bg-red-50');
                    field.classList.add('border-gray-300');
                }
            });
            
            // Check if notebook is selected
            const notebookInput = document.querySelector('input[name="notebook_id"]');
            if (!notebookInput.value) {
                isValid = false;
                
                // Highlight notebook selection
                const notebookButton = notebookInput.closest('.relative').querySelector('button');
                notebookButton.classList.add('border-red-500', 'bg-red-50');
            }
            
            if (!isValid) {
                e.preventDefault();
                
                // Show error message
                showErrorMessage('Preencha todos os campos obrigatórios e selecione um notebook');
                
                // Scroll to first error
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });

        // Success message function
        function showSuccessMessage(message) {
            const successDiv = document.createElement('div');
            successDiv.className = 'fixed top-24 right-4 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl shadow-lg z-50 max-w-md';
            successDiv.innerHTML = `
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-medium">Sucesso!</p>
                        <p class="text-sm mt-1">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-green-400 hover:text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(successDiv);
            
            setTimeout(() => {
                if (successDiv.parentElement) {
                    successDiv.remove();
                }
            }, 5000);
        }

        // Error message function
        function showErrorMessage(message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'fixed top-24 right-4 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl shadow-lg z-50 max-w-md';
            errorDiv.innerHTML = `
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-medium">Erro!</p>
                        <p class="text-sm mt-1">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(errorDiv);
            
            setTimeout(() => {
                if (errorDiv.parentElement) {
                    errorDiv.remove();
                }
            }, 7000);
        }

        // Auto-save functionality (optional)
        let autoSaveTimeout;
        function autoSave() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                // Here you could implement auto-save functionality
                console.log('Auto-saving form data...');
            }, 2000);
        }

        // Add auto-save listeners to form inputs
        document.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('input', autoSave);
        });
    </script>
</body>
</html>