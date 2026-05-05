@extends('admin.layouts.app')

@section('content')

<style>
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .card-animasi-1 { animation: slideUpFade 0.8s ease-out 0.1s both; }
    .card-animasi-2 { animation: slideUpFade 0.8s ease-out 0.3s both; }
</style>

<div class="w-full min-w-0 animate-[fadeIn_0.5s_ease-in-out]">
    
    <div class="card-animasi-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12 max-w-4xl mx-auto">
        
        <h2 class="text-2xl font-bold text-gray-800 mb-10">Backup Data</h2>
        
        <div class="flex flex-col items-center justify-center text-center space-y-8 py-8">
            
            <p class="text-gray-700 font-bold text-base md:text-lg max-w-2xl">
                Menu ini berguna untuk mem back-up data keseluruhan dari aplikasi Point Of Sales yang berformat .sql
            </p>

            <form action="#" method="POST">
                @csrf
                <button type="submit" class="bg-[#38BDF8] hover:bg-[#0284C7] text-white px-12 md:px-16 py-3.5 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-lg">
                    <i class="fa-solid fa-cloud-arrow-down"></i> Generate
                </button>
            </form>
            
        </div>
        
    </div>

</div>
@endsection