@extends('layouts.sidebar_layout')

@section('title', 'Account Settings')
@section('page_title', 'Profile Configuration')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Navigation (Internal) -->
        <div class="lg:w-1/3 space-y-4">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
                <div class="flex flex-col items-center text-center mb-8">
                    <div class="w-24 h-24 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-4xl font-black mb-4 shadow-inner">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <h3 class="text-xl font-black text-gray-800 tracking-tighter">{{ auth()->user()->name }}</h3>
                    <p class="text-xs text-gray-400 font-medium">{{ auth()->user()->email }}</p>
                </div>

                <nav class="space-y-2">
                    <a href="{{('/setting')}}" class="flex items-center space-x-3 px-6 py-4 bg-indigo-50 text-indigo-700 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-sm">
                        <i class="fas fa-user-circle text-lg"></i>
                        <span>Profile Info</span>
                    </a>
                    <a href="{{('/changepassword')}}" class="flex items-center space-x-3 px-6 py-4 text-gray-400 hover:bg-gray-50 hover:text-gray-600 rounded-2xl font-bold text-xs uppercase tracking-widest transition-all group">
                        <i class="fas fa-shield-alt text-lg group-hover:text-amber-500"></i>
                        <span>Security</span>
                    </a>
                </nav>
            </div>

            <div class="bg-indigo-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl">
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-300 mb-2">Member Since</p>
                    <p class="text-xl font-bold tracking-tight">{{ auth()->user()->created_at ? auth()->user()->created_at->format('F Y') : 'N/A' }}</p>
                </div>
                <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-indigo-800 rounded-full blur-2xl"></div>
            </div>
        </div>

        <!-- Main Form Area -->
        <div class="lg:w-2/3">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-10 py-8 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                    <div>
                        <h3 class="text-2xl font-black text-gray-800 tracking-tighter">Public Profile</h3>
                        <p class="text-xs text-gray-400 font-medium">Manage your personal identification and contact details.</p>
                    </div>
                    <div class="w-12 h-12 bg-white text-indigo-600 rounded-2xl flex items-center justify-center text-xl shadow-sm border border-gray-100">
                        <i class="fas fa-id-card"></i>
                    </div>
                </div>

                <form action="/setting" method="POST" class="p-10 space-y-8">
                    @csrf
                    <input type="hidden" name="id_user" value="{{auth()->user()->id_user}}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest pl-2">Full Name</label>
                            <input type="text" name="name" value="{{auth()->user()->name}}" required class="w-full px-5 py-4 bg-white border border-gray-200 rounded-[1.25rem] text-sm font-bold text-gray-800 outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest pl-2">Email Address</label>
                            <input type="email" name="email" value="{{auth()->user()->email}}" required class="w-full px-5 py-4 bg-white border border-gray-200 rounded-[1.25rem] text-sm font-bold text-gray-800 outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm">
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest pl-2">Home Address</label>
                            <input type="text" name="address" value="{{auth()->user()->address}}" class="w-full px-5 py-4 bg-white border border-gray-200 rounded-[1.25rem] text-sm font-bold text-gray-800 outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest pl-2">Phone Number</label>
                            <input type="text" name="phone_number" value="{{auth()->user()->phone_number}}" class="w-full px-5 py-4 bg-white border border-gray-200 rounded-[1.25rem] text-sm font-bold text-gray-800 outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest pl-2">Religion Affinity</label>
                            <div class="relative">
                                <select name="religion_id" class="w-full px-5 py-4 bg-white border border-gray-200 rounded-[1.25rem] text-sm font-bold text-gray-800 outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm appearance-none cursor-pointer">
                                    <option value="">Select Religion</option>
                                    @foreach ($religions as $religion)
                                    <option value="{{ $religion->id ?? '' }}" @if ($getUser->religions_id == $religion->id) selected @endif >{{ $religion->name ?? '' }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                            </div>
                        </div>

                        <div class="space-y-4 md:col-span-2">
                            <label class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest pl-2">Gender Identification</label>
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center group cursor-pointer">
                                    <input type="radio" name="gender" value="man" {{ auth()->user()->gender == 'man' ? 'checked' : '' }} class="hidden peer">
                                    <div class="w-5 h-5 border-2 border-gray-200 rounded-full flex items-center justify-center peer-checked:border-indigo-600 transition-all group-hover:bg-indigo-50">
                                        <div class="w-2.5 h-2.5 bg-indigo-600 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    </div>
                                    <span class="ml-3 text-sm font-bold text-gray-600 peer-checked:text-indigo-600 transition-colors uppercase tracking-widest">Man</span>
                                </label>
                                
                                <label class="flex items-center group cursor-pointer">
                                    <input type="radio" name="gender" value="woman" {{ auth()->user()->gender == 'woman' ? 'checked' : '' }} class="hidden peer">
                                    <div class="w-5 h-5 border-2 border-gray-200 rounded-full flex items-center justify-center peer-checked:border-indigo-600 transition-all group-hover:bg-indigo-50">
                                        <div class="w-2.5 h-2.5 bg-indigo-600 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    </div>
                                    <span class="ml-3 text-sm font-bold text-gray-600 peer-checked:text-indigo-600 transition-colors uppercase tracking-widest">Woman</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-50 flex items-center justify-end space-x-4">
                        <button type="submit" class="px-10 py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 uppercase tracking-[0.2em] text-[10px]">
                            Synchronize Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
