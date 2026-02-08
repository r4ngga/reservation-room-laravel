@extends('layouts.sidebar_layout')

@section('title', 'User Management')
@section('page_title', 'Management Users')

@section('style')
<style>
    [x-cloak] { display: none !important; }
    
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }

    .modal-container {
        background: white;
        border-radius: 2rem;
        width: 100%;
        max-width: 32rem;
        max-height: calc(100vh - 3rem);
        overflow-y: auto;
        position: relative;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
    }
    
    /* Scrollbar hide for container */
    .modal-container::-webkit-scrollbar {
        width: 4px;
    }
    .modal-container::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }

    body.modal-prevent-scroll {
        overflow: hidden !important;
    }
</style>
@endsection

@section('content')
<div x-data="{ 
    showAdd: false, 
    showDetail: false, 
    showEdit: false, 
    showDelete: false,
    deleteId: null,
    search: ''
}" class="space-y-6" x-cloak>
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row justify-between gap-4 items-start md:items-center w-full">
        <button @click="showAdd = true" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 group w-fit">
            <i class="fas fa-user-plus mr-2 text-sm transition-transform group-hover:scale-110"></i>
            Add New User
        </button>
        
        <div class="relative group w-fit min-w-[300px]">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-500 transition-colors pointer-events-none">
                <i class="fas fa-search text-sm"></i>
            </span>
            <input type="text" x-model="search" placeholder="Search users..." class="pl-11 pr-4 py-3 w-full bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm placeholder:text-gray-400 text-sm font-medium">
        </div>
    </div>

    <!-- Feedback Alerts -->
    @if(session('notify'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm animate-fade-in-down">
         <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <p class="text-green-700 font-medium">{{ session('notify') }}</p>
            </div>
            <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <div id="ntf-success" class="hidden bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm" role="alert">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <p class="text-green-700 font-medium" id="success-msg-text"></p>
            </div>
            <button type="button" @click="$el.parentElement.parentElement.classList.add('hidden')" class="text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">User ID</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Full Name</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Location</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Phone</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 tracking-tighter">
                    @foreach($users as $usr)
                    <tr x-show="search === '' || '{{ strtolower($usr->name) }} {{ strtolower($usr->email) }}'.includes(search.toLowerCase())" class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <span class="text-[10px] font-black bg-gray-100 text-gray-500 px-2 py-0.5 rounded tracking-normal">#{{ $usr->id_user }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm mr-3">
                                    {{ substr($usr->name, 0, 1) }}
                                </div>
                                <span class="text-gray-800 font-bold">{{ $usr->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-gray-500 text-sm">{{ Str::limit($usr->address, 30) }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-gray-600 font-mono text-xs">{{ $usr->phone_number }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center space-x-2">
                                <button @click="fetchShowUser({{ $usr->id_user }}); showDetail = true" class="p-2 text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="View Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button @click="fetchEditUser({{ $usr->id_user }}); showEdit = true" class="p-2 text-cyan-600 bg-cyan-50 rounded-lg hover:bg-cyan-600 hover:text-white transition-all shadow-sm" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button @click="deleteId = {{ $usr->id_user }}; showDelete = true" class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Delete User">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add User Modal -->
    <div x-show="showAdd" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="modal-overlay" 
         x-cloak
         @keydown.escape.window="showAdd = false"
         x-init="$watch('showAdd', val => {
            if (val) document.body.classList.add('modal-prevent-scroll');
            else if (!showDetail && !showEdit && !showDelete) document.body.classList.remove('modal-prevent-scroll');
         })">
        <div @click="showAdd = false" class="fixed inset-0"></div>
        
        <div x-show="showAdd"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-8"
             class="modal-container max-w-2xl">
            
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <h5 class="text-xl font-bold leading-none">Register New Account</h5>
                        <p class="text-[10px] text-indigo-100 mt-1 uppercase tracking-widest font-medium">System Enrollment</p>
                    </div>
                </div>
                <button @click="showAdd = false" class="text-white opacity-80 hover:opacity-100 transition-opacity">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Full Legal Name</label>
                            <input type="text" name="name" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" placeholder="John Doe" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Email Address</label>
                            <input type="email" name="email" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" placeholder="john@example.com" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Contact Number</label>
                            <input type="number" name="phone_number" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" placeholder="081234..." required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Biological Gender</label>
                            <select name="gender" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm appearance-none cursor-pointer" required>
                                <option value="">Select Gender</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                        <div class="col-span-2 space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Living Address</label>
                            <input type="text" name="address" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" placeholder="St. Avenue 123..." required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Belief System</label>
                            <select name="religion_id" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm appearance-none cursor-pointer">
                                <option value="">Select Religion</option>
                                @foreach ($religions as $rlg)
                                    <option value="{{ $rlg->id }}">{{ $rlg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Access Password</label>
                            <input type="password" name="password" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" placeholder="••••••••" required>
                        </div>
                    </div>
                </div>
                <div class="px-8 py-6 bg-gray-50 flex justify-end gap-3 sticky bottom-0">
                    <button type="button" @click="showAdd = false" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition-all shadow-sm">Cancel</button>
                    <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white font-black rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 uppercase tracking-widest text-xs">Create Member</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Detail Modal -->
    <div x-show="showDetail" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="modal-overlay" 
         x-cloak
         @keydown.escape.window="showDetail = false"
         x-init="$watch('showDetail', val => {
            if (val) document.body.classList.add('modal-prevent-scroll');
            else if (!showAdd && !showEdit && !showDelete) document.body.classList.remove('modal-prevent-scroll');
         })">
        <div @click="showDetail = false" class="fixed inset-0"></div>
        
        <div x-show="showDetail"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="modal-container">
            
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white sticky top-0 z-10 transition-all duration-500">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-id-card text-lg"></i>
                    </div>
                    <div>
                        <h5 class="text-xl font-bold leading-none">User Intelligence</h5>
                        <p class="text-[10px] text-indigo-100 mt-1 uppercase tracking-widest font-medium">Profile analytics</p>
                    </div>
                </div>
                <button @click="showDetail = false" class="text-white opacity-80 hover:opacity-100 transition-opacity">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div class="p-8">
                <div class="flex flex-col items-center mb-8">
                    <div class="w-24 h-24 rounded-full bg-indigo-50 flex items-center justify-center mb-4 border-4 border-white shadow-lg relative overflow-hidden group">
                        <i class="fas fa-user text-4xl text-indigo-600"></i>
                         <img id="u-img-preview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                    </div>
                    <h4 id="u-name" class="text-2xl font-bold text-gray-800"></h4>
                    <p id="u-role-label" class="text-[10px] font-black uppercase tracking-widest text-indigo-500 bg-indigo-50 px-3 py-1 rounded-full mt-2"></p>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="col-span-2 sm:col-span-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">User Reference ID</p>
                        <p id="u-id" class="text-sm font-bold text-gray-800 font-mono"></p>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Electronic Mail</p>
                        <p id="u-email" class="text-sm font-semibold text-gray-800"></p>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Residential Address</p>
                        <p id="u-adrs" class="text-sm text-gray-600"></p>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Primary Contact</p>
                        <p id="u-phone" class="text-sm font-bold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Biological Gender</p>
                        <p id="u-gender" class="text-sm text-gray-800 font-medium"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Faith / Religion</p>
                        <p id="u-religion" class="text-sm text-gray-800 font-medium"></p>
                    </div>
                    <div class="col-span-2 pt-4 border-t border-gray-50 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">System Membership Since</p>
                            <p id="u-created" class="text-xs text-gray-500 italic"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-8 py-6 bg-gray-50 flex justify-end sticky bottom-0 border-t border-gray-100">
                <button @click="showDetail = false" class="px-8 py-3 bg-white border border-gray-200 text-gray-600 font-extrabold rounded-xl hover:bg-gray-100 transition-all shadow-sm uppercase tracking-widest text-[10px]">Acknowledge</button>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEdit" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="modal-overlay" 
         x-cloak
         @keydown.escape.window="showEdit = false"
         x-init="$watch('showEdit', val => {
            if (val) document.body.classList.add('modal-prevent-scroll');
            else if (!showAdd && !showDetail && !showDelete) document.body.classList.remove('modal-prevent-scroll');
         })">
        <div @click="showEdit = false" class="fixed inset-0"></div>
        
        <div x-show="showEdit"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-8"
             class="modal-container max-w-2xl">
            
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div>
                        <h5 class="text-xl font-bold leading-none">Modify Account Intelligence</h5>
                        <p class="text-[10px] text-indigo-100 mt-1 uppercase tracking-widest font-medium">Update record archive</p>
                    </div>
                </div>
                <button @click="showEdit = false" class="text-white opacity-80 hover:opacity-100 transition-opacity">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <form id="form-edit-user" @submit.prevent="submitEdit">
                @csrf
                <input type="hidden" id="edit-id-user">
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Full Legal Name</label>
                            <input type="text" name="name" id="edit-name" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Email Address</label>
                            <input type="email" name="email" id="edit-email" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Contact Number</label>
                            <input type="number" name="phone_number" id="edit-phone" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Biological Gender</label>
                            <select name="gender" id="edit-gender" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm appearance-none cursor-pointer" required>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                        <div class="col-span-2 space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Living Address</label>
                            <input type="text" name="address" id="edit-address" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Belief System</label>
                            <select name="religion_id" id="edit-religion" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm appearance-none cursor-pointer">
                                @foreach ($religions as $rlg)
                                    <option value="{{ $rlg->id }}">{{ $rlg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Reset Password (Optional)</label>
                            <input type="password" name="password" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" placeholder="Leave blank to keep current">
                        </div>
                    </div>
                </div>
                <div class="px-8 py-6 bg-gray-50 flex justify-end gap-3 sticky bottom-0">
                    <button type="button" @click="showEdit = false" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition-all shadow-sm">Discard</button>
                    <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white font-black rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 uppercase tracking-widest text-xs">Commit Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="showDelete" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="modal-overlay" 
         x-cloak
         @keydown.escape.window="showDelete = false"
         x-init="$watch('showDelete', val => {
            if (val) document.body.classList.add('modal-prevent-scroll');
            else if (!showAdd && !showDetail && !showEdit) document.body.classList.remove('modal-prevent-scroll');
         })">
        <div @click="showDelete = false" class="fixed inset-0"></div>
        
        <div x-show="showDelete"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="modal-container max-w-md">
            <div class="p-10 text-center">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-6 shadow-sm">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-800 mb-2">Purge Account?</h3>
                <p class="text-gray-500 mb-8 px-6 text-sm leading-relaxed">You are about to permanently remove this user from the system. This action is <span class="text-red-600 font-bold underline decoration-2">irreversible</span>.</p>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" @click="showDelete = false" class="w-full py-4 bg-gray-50 text-gray-500 font-bold rounded-2xl hover:bg-gray-100 transition-all uppercase tracking-widest text-xs">Stay Back</button>
                    <button @click="submitDelete" type="button" class="w-full py-4 bg-red-600 text-white font-bold rounded-2xl hover:bg-red-700 transition-all shadow-xl shadow-red-100 uppercase tracking-widest text-xs">Execute Purge</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">

    function fetchShowUser(id){
        $.ajax({
            type: 'GET',
            url: '/users/' + id,
            success:function(data){
                document.getElementById('u-id').innerHTML = '#' + data.id;
                document.getElementById('u-name').innerHTML = data.name;
                document.getElementById('u-email').innerHTML = data.email;
                document.getElementById('u-adrs').innerHTML = data.address;
                document.getElementById('u-phone').innerHTML = data.phone_number;
                document.getElementById('u-gender').innerHTML = data.gender == 1 ? 'Male' : 'Female';
                document.getElementById('u-role-label').innerHTML = data.role == 1 ? 'Admin' : 'Member';
                document.getElementById('u-created').innerHTML = data.created_at;
                document.getElementById('u-religion').innerHTML = data.religions;
                
                if(data.photo_profile) {
                    document.getElementById('u-img-preview').src = data.photo_profile;
                    document.getElementById('u-img-preview').classList.remove('hidden');
                } else {
                    document.getElementById('u-img-preview').classList.add('hidden');
                }
            }
        });
    }

    function fetchEditUser(id){
        $.ajax({
            type: 'GET',
            url: '/fetchedit-user/' + id,
            success:function(data){
                document.getElementById('edit-id-user').value = data.id_user;
                document.getElementById('edit-name').value = data.name;
                document.getElementById('edit-email').value = data.email;
                document.getElementById('edit-address').value = data.address;
                document.getElementById('edit-phone').value = data.phone_number;
                
                let selectedGender = document.getElementById('edit-gender');
                for(let i=0; i < selectedGender.length; i++) {
                    if(data.gender == selectedGender.options[i].value) selectedGender.options[i].selected = true;
                }

                let selectedReligion = document.getElementById('edit-religion');
                for(let i=0; i < selectedReligion.length; i++) {
                    if(data.religions_id == selectedReligion.options[i].value) selectedReligion.options[i].selected = true;
                }
            }
        });
    }

    function submitEdit() {
        let user_id = $('#edit-id-user').val();
        let formData = new FormData($('#form-edit-user')[0]);
        
        $.ajax({
            type: 'POST',
            url: '/users/update/' + user_id,
            headers: { 'X-CSRF-Token': '{{ csrf_token() }}' },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                $("#success-msg-text").text(response.data);
                $("#ntf-success").removeClass("hidden").addClass("flex");
                // The room index used location.reload(), we can do same or close modal
                setTimeout(() => { location.reload(); }, 1000);
            },
            error: function(err) {
                console.error("Update failed", err);
                alert("Conflict detection: Failed to sync changes with archive.");
            }
        });
    }

    function submitDelete() {
        // We get deleteId from Alpine state via helper if needed, 
        // but since this script is outside Alpine scope, we can use a little trick 
        // or just access the variable from Alpine if it was global. 
        // Better to get it from the Alpine data object.
        let alpineData = document.querySelector('[x-data]').__x.$data;
        let idusr = alpineData.deleteId;
        let token = '{{ csrf_token() }}';

        $.ajax({
            type: 'POST',
            url: `/users/delete/` + idusr,
            data: {
                _token: token,
                id_users: idusr
            },
            success:function(data){
                alpineData.showDelete = false;
                $("#success-msg-text").text("User has been successfully purged from the archive.");
                $("#ntf-success").removeClass("hidden").addClass("flex");
                setTimeout(() => { location.reload(); }, 1500);
            },
            error: function(err) {
                 // In case of 500 error like the dd() in controller
                 console.error("Delete failed", err);
                 alert("Failed to purge user. System integrity check required.");
            }
        });
    }
</script>
@endsection
