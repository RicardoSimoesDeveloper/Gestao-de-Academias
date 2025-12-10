<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitGestão Pro | Gestão de Academias Multi-Tenant</title>
    @vite(['resources/css/app.css', 'resources/js/landing.js'])
    <style>
        /* Hero suave e moderno */
        .hero-bg {
            background: linear-gradient(135deg, #f0f4f8 0%, #ffffff 100%);
        }
        /* Cards com hover moderno */
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Fit<span class="text-blue-600">Gestão</span> Pro
            </div>
            <div>
                <a href="{{ route('central.login') }}" 
                   class="border border-blue-600 text-blue-600 px-4 py-2 rounded-lg text-sm sm:text-base font-semibold hover:bg-blue-50 transition duration-300">
                    Acesso Central
                </a>
            </div>
        </nav>
    </header>

    <!-- Hero -->
    <section class="hero-bg py-24 sm:py-32 text-center relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4">
            <p class="text-sm font-semibold uppercase text-blue-600 mb-2 tracking-wide">
                Plataforma SaaS Multi-Tenant para Redes de Fitness
            </p>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                O Futuro da Gestão de Academias Está Aqui
            </h1>
            <p class="text-lg sm:text-xl text-gray-700 mb-10 max-w-3xl mx-auto">
                Centralize operações, garanta segurança de dados por unidade e impulsione o crescimento do seu negócio fitness com uma plataforma inteligente e escalável.
            </p>
            <a href="#contato" 
               class="bg-blue-600 text-white font-bold py-4 px-10 rounded-xl text-lg sm:text-xl hover:bg-blue-700 transition duration-300 shadow-lg inline-block">
                Solicitar Demonstração
            </a>
        </div>
    </section>

    <!-- Recursos -->
    <section id="recursos" class="py-20 sm:py-28 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl sm:text-4xl font-bold text-center text-gray-900 mb-16">Por Que Escolher o FitGestão Pro?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                
                <!-- Card 1 -->
                <div class="feature-card bg-white p-8 rounded-xl shadow-md border-t-4 border-blue-500 transition duration-300">
                   <div class="text-blue-500 mb-4 flex justify-center">
                       
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Dados 100% Isolados</h3>
                    <p class="text-gray-600 text-sm">Cada unidade opera em seu próprio banco de dados, garantindo segurança, privacidade e conformidade legal.</p>
                </div>

                <!-- Card 2 -->
                <div class="feature-card bg-white p-8 rounded-xl shadow-md border-t-4 border-yellow-500 transition duration-300">
                    <div class="text-yellow-500 mb-5">
                      
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Catálogo de Planos Centralizado</h3>
                    <p class="text-gray-600 text-sm">Gerencie planos de adesão de forma eficiente e mantenha controle completo das assinaturas dos seus alunos.</p>
                </div>

                <!-- Card 3 -->
                <div class="feature-card bg-white p-8 rounded-xl shadow-md border-t-4 border-green-500 transition duration-300">
                    <div class="text-green-500 mb-5">
                       
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Relatórios Consolidados</h3>
                    <p class="text-gray-600 text-sm">Visualize a performance de todas as unidades em um dashboard unificado e tome decisões baseadas em dados reais.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Contato / CTA -->
    <section id="contato" class="py-24 bg-blue-600 text-white">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-center mb-4">Pronto para Escalar Sua Rede?</h2>
            <p class="text-lg sm:text-xl text-center mb-12 opacity-90">Preencha o formulário e agende uma conversa com nosso especialista.</p>
            
            <form action="#" method="POST" class="bg-white p-8 rounded-2xl shadow-2xl text-left border-l-4 border-yellow-400">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label for="nome" class="block text-sm font-semibold text-gray-700 mb-1">Nome Completo</label>
                        <input type="text" id="nome" name="nome" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-800 transition duration-150">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Profissional</label>
                        <input type="email" id="email" name="email" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-800 transition duration-150">
                    </div>

                    <div>
                        <label for="telefone" class="block text-sm font-semibold text-gray-700 mb-1">Telefone / WhatsApp</label>
                        <input type="tel" id="telefone" name="telefone" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-800 transition duration-150">
                    </div>

                    <div>
                        <label for="empresa" class="block text-sm font-semibold text-gray-700 mb-1">Nome da Academia/Rede</label>
                        <input type="text" id="empresa" name="empresa" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-800 transition duration-150">
                    </div>

                </div>
                
                <div class="mt-10 text-center">
                    <button type="submit" 
                            class="bg-yellow-400 text-gray-900 font-extrabold py-4 px-12 rounded-xl text-lg hover:bg-yellow-500 transition duration-300 shadow-lg w-full md:w-auto">
                        Agendar Demonstração
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-10">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm">
            <p>&copy; 2025 FitGestão Pro. Todos os direitos reservados.</p>
            <p class="mt-2 text-gray-500">Desenvolvido com Laravel, Vue.js e arquitetura Multi-Tenant.</p>
        </div>
    </footer>

</body>
</html>
