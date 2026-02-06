@extends('layouts.sidebar_layout')

@section('title', 'Security Settings')
@section('page_title', 'Account Security')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Navigation (Internal) -->
        <div class="lg:w-1/3 space-y-4">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
                <div class="flex flex-col items-center text-center mb-8">
                    <div class="w-24 h-24 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center text-4xl font-black mb-4 shadow-inner">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="text-xl font-black text-gray-800 tracking-tighter">{{ auth()->user()->name }}</h3>
                    <p class="text-xs text-gray-400 font-medium">Security & Privacy</p>
                </div>

                <nav class="space-y-2">
                    <a href="{{('/setting')}}" class="flex items-center space-x-3 px-6 py-4 text-gray-400 hover:bg-gray-50 hover:text-gray-600 rounded-2xl font-bold text-xs uppercase tracking-widest transition-all group">
                        <i class="fas fa-user-circle text-lg"></i>
                        <span>Profile Info</span>
                    </a>
                    <a href="{{('/changepassword')}}" class="flex items-center space-x-3 px-6 py-4 bg-amber-50 text-amber-700 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-sm">
                        <i class="fas fa-shield-alt text-lg"></i>
                        <span>Security</span>
                    </a>
                </nav>
            </div>

            <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl">
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Account Status</p>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></div>
                        <p class="text-sm font-black tracking-widest uppercase">Secured</p>
                    </div>
                </div>
                <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-gray-800 rounded-full blur-2xl"></div>
            </div>
        </div>

        <!-- Main Form Area -->
        <div class="lg:w-2/3">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-10 py-8 border-b border-gray-50 flex items-center justify-between bg-amber-50/10">
                    <div>
                        <h3 class="text-2xl font-black text-gray-800 tracking-tighter">Authentication</h3>
                        <p class="text-xs text-gray-400 font-medium">Update your password to keep your account safe.</p>
                    </div>
                    <div class="w-12 h-12 bg-white text-amber-600 rounded-2xl flex items-center justify-center text-xl shadow-sm border border-gray-100">
                        <i class="fas fa-key"></i>
                    </div>
                </div>

                <form action="/changepassword" method="POST" class="p-10 space-y-8">
                    @csrf
                    <input type="hidden" name="id_user" value="{{$getUserPassword->id_user ?? ''}}">

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-amber-600 uppercase tracking-widest pl-2">New Password</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-gray-400 group-focus-within:text-amber-500 transition-colors">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" required placeholder="••••••••" class="w-full pl-12 pr-5 py-4 bg-white border border-gray-200 rounded-[1.25rem] text-sm font-bold text-gray-800 outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all shadow-sm">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-amber-600 uppercase tracking-widest pl-2">Confirm New Password</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-gray-400 group-focus-within:text-amber-500 transition-colors">
                                    <i class="fas fa-check-double"></i>
                                </span>
                                <input type="password" name="repeat_password" required placeholder="••••••••" class="w-full pl-12 pr-5 py-4 bg-white border border-gray-200 rounded-[1.25rem] text-sm font-bold text-gray-800 outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all shadow-sm">
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-50 flex items-center justify-between">
                        <a href="{{('/setting')}}" class="text-xs font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-colors flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Discard Changes</span>
                        </a>
                        <button type="submit" class="px-10 py-4 bg-gray-900 text-white font-black rounded-2xl hover:bg-black transition-all shadow-xl shadow-gray-200 uppercase tracking-[0.2em] text-[10px]">
                            Update Security
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Tips -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-6 bg-white rounded-3xl border border-gray-100 flex items-start space-x-4">
                    <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex-shrink-0 flex items-center justify-center">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-gray-800 uppercase tracking-widest mb-1">Strong Passwords</h4>
                        <p class="text-[10px] text-gray-400 leading-relaxed font-medium">Use at least 12 characters including symbols and numbers.</p>
                    </div>
                </div>
                <div class="p-6 bg-white rounded-3xl border border-gray-100 flex items-start space-x-4">
                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex-shrink-0 flex items-center justify-center">
                        <i class="fas fa-shield-virus"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-gray-800 uppercase tracking-widest mb-1">Stay Private</h4>
                        <p class="text-[10px] text-gray-400 leading-relaxed font-medium">Never share your credentials with anyone, including staff.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
