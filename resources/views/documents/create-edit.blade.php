<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document ? 'Editar' : 'Criar' }} Documento - Mída Simples Doc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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

<form action="{{ $document ? route('documents.update', $document->id) : route('documents.store') }}" method="POST" class="space-y-8">
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
                            <input type="text" name="user_name" id="user_name" value="{{ $document->user_name ?? old('user_name') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Nome completo" required>
                        </div>
                        <div>
                            <label for="user_email" class="block text-sm font-semibold text-gray-700 mb-2">E-mail </label>
                            <input type="email" name="user_email" id="user_email" value="{{ $document->user_email ?? old('user_email') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="exemplo@dominio.com">
                        </div>
                        <div>
                            <label for="user_document" class="block text-sm font-semibold text-gray-700 mb-2">CPF *</label>
                            <input type="text" name="user_document" id="user_document" value="{{ $document->user_document ?? old('user_document') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="000.000.000-00" required>
                        </div>
                        <div>
                            <label for="user_role" class="block text-sm font-semibold text-gray-700 mb-2">Função *</label>
                            <input type="text" name="user_role" id="user_role" value="{{ $document->user_role ?? old('user_role') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Ex: Analista, Gerente..." required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações do Equipamento -->
            <div class="form-section bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500/10 to-teal-500/10 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Informações do Equipamento</h3>
                            <p class="text-sm text-gray-600">Dados técnicos do notebook</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="brand" class="block text-sm font-semibold text-gray-700 mb-2">Marca *</label>
                            <input type="text" name="brand" id="brand" value="{{ $document->brand ?? old('brand') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>
                        <div>
                            <label for="model" class="block text-sm font-semibold text-gray-700 mb-2">Modelo *</label>
                            <input type="text" name="model" id="model" value="{{ $document->model ?? old('model') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>
                        <div>
                            <label for="serial_number" class="block text-sm font-semibold text-gray-700 mb-2">Número de Série *</label>
                            <input type="text" name="serial_number" id="serial_number" value="{{ $document->serial_number ?? old('serial_number') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>
                        <div>
                            <label for="processor" class="block text-sm font-semibold text-gray-700 mb-2">Processador *</label>
                            <input type="text" name="processor" id="processor" value="{{ $document->processor ?? old('processor') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>
                        <div>
                            <label for="memory" class="block text-sm font-semibold text-gray-700 mb-2">Memória RAM (GB) *</label>
                            <input type="text" name="memory" id="memory" value="{{ $document->memory ?? old('memory') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>
                        <div>
                            <label for="disk" class="block text-sm font-semibold text-gray-700 mb-2">Disco Rígido (GB) *</label>
                            <input type="text" name="disk" id="disk" value="{{ $document->disk ?? old('disk') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Valor (R$) *</label>
                            <input type="text" name="price" id="price" value="{{ $document->price ?? old('price') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>
                        <div>
                            <label for="price_string" class="block text-sm font-semibold text-gray-700 mb-2">Valor por Extenso *</label>
                            <input type="text" name="price_string" id="price_string" value="{{ $document->price_string ?? old('price_string') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>
                        <div>
                            <label for="local" class="block text-sm font-semibold text-gray-700 mb-2">Local de Assinatura *</label>
                            <input type="text" name="local" id="local" value="{{ $document->local ?? old('local') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>
                        <div>
                            <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Data da Assinatura *</label>
                            <input type="date" name="date" id="date" value="{{ $document->date ?? old('date') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                        <div class="preview-card rounded-xl p-6 mb-6">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-sm text-gray-500 mb-2">Prévia em tempo real</p>
                                <p class="text-xs text-gray-400">Complete os campos para visualizar</p>
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
                        <button type="submit" class="btn-primary w-full px-6 py-4 font-semibold text-white rounded-xl shadow-lg flex items-center justify-center space-x-2">
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
        // CPF Mask
        document.getElementById('user_document').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });

        // Salary Mask
        document.getElementById('price').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d)(\d{2})$/, '$1,$2');
            value = value.replace(/(?=(\d{3})+(\D))\B/g, '.');
            e.target.value = 'R$ ' + value;
        });

        // Real-time preview update
        function updatePreview() {
            const name = document.getElementById('user_name').value;
            const cpf = document.getElementById('user_document').value;
            const functionField = document.getElementById('user_role').value;
            
            const previewCard = document.querySelector('.preview-card');
            
            if (name || cpf || functionField) {
                previewCard.innerHTML = `
                    <div class="text-left">
                        <h4 class="font-semibold text-gray-900 mb-3">Documento em Criação</h4>
                        <div class="space-y-2 text-sm">
                            ${name ? `<p><span class="font-medium text-gray-700">Nome:</span> ${name}</p>` : ''}
                            ${cpf ? `<p><span class="font-medium text-gray-700">CPF:</span> ${cpf}</p>` : ''}
                            ${functionField ? `<p><span class="font-medium text-gray-700">Função:</span> ${functionField}</p>` : ''}
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex items-center space-x-2 text-xs text-gray-500">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Pronto para gerar</span>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                previewCard.innerHTML = `
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-sm text-gray-500 mb-2">Prévia em tempo real</p>
                        <p class="text-xs text-gray-400">Complete os campos para visualizar</p>
                    </div>
                `;
            }
        }

        // Add event listeners for real-time preview
        ['user_name', 'user_document', 'user_role'].forEach(fieldId => {
            document.getElementById(fieldId).addEventListener('input', updatePreview);
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = ['user_name', 'user_document', 'user_role'];
            let isValid = true;
            
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
            
            if (!isValid) {
                e.preventDefault();
                
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'fixed top-24 right-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-lg z-50';
                errorDiv.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">Preencha todos os campos obrigatórios</span>
                    </div>
                `;
                
                document.body.appendChild(errorDiv);
                
                setTimeout(() => {
                    errorDiv.remove();
                }, 5000);
                
                // Scroll to first error
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });

        // Initialize preview on page load if editing
        document.addEventListener('DOMContentLoaded', function() {
            updatePreview();
        });
    </script>
</body>
</html>