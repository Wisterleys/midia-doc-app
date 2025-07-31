<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mídia Simples Doc - Gerenciamento de Documentos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #2563eb 100%);
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-4px);
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
        .btn-secondary {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="antialiased text-gray-800 bg-gray-50">
    <!-- Header -->
    <header class="glass-effect shadow-lg sticky top-0 z-50 border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Mídia Simples</span>
                        <span class="text-lg font-medium text-gray-700 ml-1">Doc</span>
                    </div>
                </div>
                <nav class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-2 rounded-md hover:bg-gray-100">
                        {{ __('Sign In') }}
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm font-semibold text-white px-6 py-2.5 rounded-lg shadow-lg">
                        {{ __('Create Account') }}
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <main>
        <section class="hero-gradient relative overflow-hidden">
            <!-- Background decorative elements -->
            <div class="absolute inset-0 bg-black/5"></div>
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute top-10 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>
            </div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center text-white">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                        {{ __('Manage your documents with') }}
                        <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">{{ __('Simplicity') }}</span>
                    </h1>
                    <p class="text-lg md:text-xl max-w-3xl mx-auto text-white/90 mb-10 leading-relaxed">
                        {{ __('Create, edit and download your forms with security, organization and accessibility on any device.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4 max-w-md mx-auto">
                        <a href="{{ route('register') }}" class="btn-primary px-8 py-4 font-semibold rounded-xl shadow-2xl text-center">
                            {{ __('Start now') }}
                        </a>
                        <a href="#features" class="btn-secondary px-8 py-4 font-medium rounded-xl text-center text-white">
                            {{ __('Learn more') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section id="features" class="bg-white py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20">
                    <div class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 text-sm font-semibold rounded-full mb-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                         {{ __('Learn more') }}
                    </div>
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-6">
                        Tudo que você precisa para gerenciar seus documentos
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                        Torne seu dia a dia mais prático com ferramentas eficientes e seguras.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature Card 1 -->
                    <div class="feature-card bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                        <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 mb-6 mx-auto">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 text-center mb-4">Documentos Seguros</h3>
                        <p class="text-gray-600 text-center leading-relaxed">Seus documentos são armazenados com criptografia e acesso exclusivo.</p>
                    </div>

                    <!-- Feature Card 2 -->
                    <div class="feature-card bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                        <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 mb-6 mx-auto">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 text-center mb-4">Múltiplos Formatos</h3>
                        <p class="text-gray-600 text-center leading-relaxed">Exportação fácil em DOCX e PDF, conforme sua necessidade.</p>
                    </div>

                    <!-- Feature Card 3 -->
                    <div class="feature-card bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                        <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-green-500 to-teal-600 mb-6 mx-auto">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 text-center mb-4">Busca Inteligente</h3>
                        <p class="text-gray-600 text-center leading-relaxed">Pesquise documentos por nome, CPF ou palavra-chave de forma ágil.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/5 to-purple-500/5"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
                <div class="max-w-3xl mx-auto">
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-6">
                      {{ __('Simplify your document management now') }}
                    </h2>
                    <p class="text-lg text-gray-600 mb-10 leading-relaxed">
                        {{ __('Get started for free and bring more organization to your routine.')  }}
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4 max-w-md mx-auto">
                        <a href="{{ route('register') }}" class="btn-primary px-8 py-4 font-semibold rounded-xl shadow-2xl text-center text-white">
                            {{ __('Create a free account') }}
                        </a>
                        <a href="#features" class="bg-white border-2 border-gray-200 text-gray-700 hover:border-indigo-300 hover:text-indigo-600 px-8 py-4 font-medium rounded-xl text-center transition-all duration-200">
                            {{ __('View resources') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Mídia Simples Doc</span>
                </div>
                <div class="flex space-x-8 text-sm text-gray-500">
                    <a href="#" class="hover:text-indigo-600 transition-colors duration-200">Termos de Uso</a>
                    <a href="#" class="hover:text-indigo-600 transition-colors duration-200">Política de Privacidade</a>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-400 text-center">
                    &copy; 2025 Mídia Simples Doc. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>