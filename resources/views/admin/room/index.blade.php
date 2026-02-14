@extends('layouts.sidebar_layout')

@section('title', 'Room Management')
@section('page_title', 'Management Rooms')

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
    deleteNumber: '',
    search: ''
}" class="space-y-6" x-cloak>
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 items-start w-full">
        <button @click="showAdd = true" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 group w-fit">
            <i class="fas fa-plus mr-2 text-xs transition-transform group-hover:rotate-90"></i>
            Add New Room
        </button>
        
        <div class="relative group w-fit min-w-[300px]">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-500 transition-colors pointer-events-none">
                <i class="fas fa-search text-sm"></i>
            </span>
            <input type="text" x-model="search" placeholder="Search room..." class="pl-11 pr-4 py-3 w-full bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm placeholder:text-gray-400 text-sm font-medium">
        </div>
    </div>

    @if(session('notify'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm animate-fade-in-down" role="alert">
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

    <!-- Feedback Alerts -->
    <div id="aler-success" class="hidden bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm animate-fade-in-down" role="alert">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <p class="text-green-700 font-medium" id="success-message"></p>
            </div>
            <button type="button" onclick="this.parentElement.parentElement.classList.add('hidden')" class="text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Rooms Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Room Number</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Class</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Capacity</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 uppercase tracking-tighter">
                    @php $status_colors = ['bg-green-100 text-green-700', 'bg-red-100 text-red-700', 'bg-amber-100 text-amber-700']; @endphp
                    @php $status_labels = ['Free', 'Full', 'Booking']; @endphp
                    @php $class_labels = ['', 'VIP', 'Premium', 'Regular']; @endphp
                    @php $class_colors = ['', 'text-indigo-600 font-bold', 'text-amber-600 font-bold', 'text-gray-600 font-bold']; @endphp
                    
                    @foreach($rooms as $rm)
                    <tr x-show="search === '' || '{{ strtolower($rm->number_room) }} {{ strtolower($class_labels[$rm->class] ?? '') }}'.includes(search.toLowerCase())" class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <span class="text-gray-800 font-bold">#{{ $rm->number_room ?? '' }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="{{ $class_colors[$rm->class] ?? '' }}">{{ $class_labels[$rm->class] ?? '' }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-users mr-2 text-xs"></i>
                                {{ $rm->capacity ?? '' }} Person
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase {{ $status_colors[$rm->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $status_labels[$rm->status] ?? 'Unknown' }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center space-x-2">
                                <button @click="fetchShowRoom({{ $rm->number_room ?? '' }}); showDetail = true" class="p-2 text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="View Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button @click="fetchEdit({{ $rm->id ?? '' }}); showEdit = true" class="p-2 text-cyan-600 bg-cyan-50 rounded-lg hover:bg-cyan-600 hover:text-white transition-all shadow-sm" title="Edit Room">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button @click="deleteNumber = '{{ $rm->number_room }}'; showDelete = true" class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Delete Room">
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

    <!-- Pagination -->
    <div class="mt-6">
        {{ $rooms->links() }}
    </div>

    <!-- Modals Section -->

    <!-- Add Room Modal -->
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
             class="modal-container">
            
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <h5 class="text-xl font-bold leading-none">Register New Room</h5>
                        <p class="text-[10px] text-indigo-100 mt-1 uppercase tracking-widest font-medium">Add to collection</p>
                    </div>
                </div>
                <button @click="showAdd = false" class="text-white opacity-80 hover:opacity-100 transition-opacity">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Room Number</label>
                            <input type="text" name="number_room" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" placeholder="e.g. 101">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Room Class</label>
                            <select name="class" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm cursor-pointer">
                                <option value="1">VIP</option>
                                <option value="2">Premium</option>
                                <option value="3" selected>Regular</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Max Capacity</label>
                            <input type="number" name="capacity" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" placeholder="e.g. 2">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Price / Day (IDR)</label>
                            <input type="number" name="price" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl font-mono text-indigo-600 focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" placeholder="e.g. 500000">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Facility Details</label>
                        <textarea name="facility" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" placeholder="WiFi, AC, TV..."></textarea>
                    </div>
                    <div class="space-y-4">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1 block">Room Presentation</label>
                        <div class="flex items-center gap-4">
                            <div class="w-24 h-24 rounded-2xl bg-gray-100 overflow-hidden border border-dashed border-gray-200 flex items-center justify-center relative group">
                                <img id="add-preview" src="" class="w-full h-full object-cover hidden">
                                <div id="add-placeholder" class="text-gray-300">
                                    <i class="fas fa-camera text-2xl"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <label for="image_add" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-xl hover:bg-indigo-100 transition-all cursor-pointer">
                                    <i class="fas fa-upload mr-2"></i> Select Image
                                </label>
                                <input type="file" name="image_room" id="image_add" class="hidden" onchange="previewAddImg(event)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-8 py-6 bg-gray-50 flex justify-end gap-3 sticky bottom-0">
                    <button type="button" @click="showAdd = false" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition-all shadow-sm">Cancel</button>
                    <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-all shadow-lg">Save Room</button>
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
                        <i class="fas fa-door-open text-lg"></i>
                    </div>
                    <div>
                        <h5 class="text-xl font-bold leading-none">Room Intelligence</h5>
                        <p class="text-[10px] text-indigo-100 mt-1 uppercase tracking-widest font-medium">Asset profiling</p>
                    </div>
                </div>
                <button @click="showDetail = false" class="text-white opacity-80 hover:opacity-100 transition-opacity">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <div class="col-span-2 relative h-56 w-full rounded-2xl bg-gray-100 overflow-hidden border border-gray-100 shadow-inner group">
                        <img id="r-img" src="" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Room preview">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        <span id="r-status-badge" class="absolute top-4 right-4 px-4 py-1.5 bg-white/95 backdrop-blur-sm rounded-xl text-[10px] font-black uppercase tracking-widest text-indigo-600 shadow-lg border border-indigo-50"></span>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-l-2 border-indigo-200 pl-2">Room Index</p>
                        <p id="r-number" class="text-2xl font-black text-gray-800"></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-l-2 border-amber-200 pl-2">Service Class</p>
                        <p id="r-class" class="text-lg font-bold text-gray-700"></p>
                    </div>
                    <div class="pt-2 border-t border-gray-50 flex items-start gap-3">
                        <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-500 flex-shrink-0">
                            <i class="fas fa-concierge-bell text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Features</p>
                            <p id="r-facility" class="text-sm text-gray-600 font-medium"></p>
                        </div>
                    </div>
                    <div class="pt-2 border-t border-gray-50 flex items-start gap-3">
                        <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center text-amber-500 flex-shrink-0">
                            <i class="fas fa-users text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Capacity</p>
                            <p id="r-capacity" class="text-lg font-bold text-gray-800"></p>
                        </div>
                    </div>
                    <div class="col-span-2 bg-slate-50 p-6 rounded-[1.5rem] border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Daily Rate Card</p>
                            <p id="r-price" class="text-2xl font-black text-indigo-600 font-mono"></p>
                        </div>
                        <div class="text-right">
                             <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Last Update</p>
                             <p id="r-created" class="text-xs font-bold text-slate-600"></p>
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
             class="modal-container">
            
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div>
                        <h5 class="text-xl font-bold leading-none">Modify Room Logic</h5>
                        <p class="text-[10px] text-indigo-100 mt-1 uppercase tracking-widest font-medium">Update archive data</p>
                    </div>
                </div>
                <button @click="showEdit = false" class="text-white opacity-80 hover:opacity-100 transition-opacity">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <form id="form-edtrm" @submit.prevent="submitEdit">
                <div class="p-8 space-y-6">
                    @csrf
                    <input type="hidden" id="id-room">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Facility Listing</label>
                        <input type="text" name="facility" id="facility-room" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Room Class</label>
                            <select name="class" id="class-room" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                                <option value="1">VIP</option>
                                <option value="2">Premium</option>
                                <option value="3">Regular</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Guest Limit</label>
                            <input type="number" name="capacity" id="capacity-room" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Daily Pricing (IDR)</label>
                        <input type="number" name="price" id="price-room" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl font-mono text-lg text-indigo-600 focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                    </div>
                    <div class="space-y-4">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1 block">Visual Asset Update</label>
                        <div class="flex items-start gap-4">
                            <div class="w-24 h-24 rounded-2xl bg-gray-100 overflow-hidden border border-gray-100 flex-shrink-0 shadow-sm">
                                <img src="" id="img-rm" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-grow pt-2">
                                <label for="image_room" class="cursor-pointer inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-all text-xs font-bold uppercase tracking-widest shadow-sm">
                                    <i class="fas fa-camera mr-2"></i> Swap Asset
                                </label>
                                <input type="file" name="image_room" id="image_room" class="hidden" onchange="previewImage(event);">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-8 py-6 bg-gray-50 flex justify-end gap-3 sticky bottom-0">
                    <button type="button" @click="showEdit = false" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition-all shadow-sm">Discard</button>
                    <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-all shadow-lg">Commit Logic</button>
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
                <h3 class="text-2xl font-black text-gray-800 mb-2">Purge Room Data?</h3>
                <p class="text-gray-500 mb-8 px-6 text-sm leading-relaxed">You are about to permanently remove Room <span class="bg-red-50 text-red-600 px-1.5 py-0.5 rounded-lg font-bold" x-text="'#' + deleteNumber"></span>. This action is irreversible.</p>
                
                <form :action="'/rooms/' + deleteNumber" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @method('delete')
                    @csrf
                    <button type="button" @click="showDelete = false" class="w-full py-4 bg-gray-50 text-gray-500 font-bold rounded-2xl hover:bg-gray-100 transition-all uppercase tracking-widest text-xs">Stay Safe</button>
                    <button type="submit" class="w-full py-4 bg-red-600 text-white font-bold rounded-2xl hover:bg-red-700 transition-all shadow-xl shadow-red-100 uppercase tracking-widest text-xs">Execute Purge</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Asset Previews
    const previewImage = (event) => {
      const imageFiles = event.target.files;
      if (imageFiles.length > 0) {
          const imageSrc = URL.createObjectURL(imageFiles[0]);
          document.querySelector("#img-rm").src = imageSrc;
      }
    };

    const previewAddImg = (event) => {
      const imageFiles = event.target.files;
      if (imageFiles.length > 0) {
          const imageSrc = URL.createObjectURL(imageFiles[0]);
          document.querySelector("#add-preview").src = imageSrc;
          document.querySelector("#add-preview").classList.remove('hidden');
          document.querySelector("#add-placeholder").classList.add('hidden');
      }
    };

    // Data Fetching
    function fetchEdit(id)
    {
        $.ajax({
            type: 'GET',
            url: '/fetchedit/'+id,
            success:function(data){
                let selectedClass = document.getElementById('class-room');
                for(let i=0; i < selectedClass.length; i++)
                {
                    if(data.class == selectedClass.options[i].value){
                        selectedClass.options[i].selected = true;
                    }
                }
                document.getElementById('id-room').value = id;
                document.getElementById('capacity-room').value = data.capacity;
                document.getElementById('facility-room').value = data.facility;
                document.getElementById('price-room').value = data.price;
                document.getElementById('image_room').value = '';
                document.getElementById('img-rm').src = data.image_room;
            }
        });
    }

    function fetchShowRoom(id)
    {
        $.ajax({
            type: 'GET',
            url: '/rooms/'+id,
            success:function(data){
                document.getElementById('r-number').innerHTML = '#' + data.number_room;
                document.getElementById('r-facility').innerHTML = data.facility;
                document.getElementById('r-class').innerHTML = data.class;
                document.getElementById('r-capacity').innerHTML = data.capacity + ' Persons';
                document.getElementById('r-price').innerHTML = 'IDR ' + new Intl.NumberFormat('id-ID').format(data.price);
                document.getElementById('r-status-badge').innerHTML = data.status;
                document.getElementById('r-img').src = data.image_room;
                document.getElementById('r-created').innerHTML = data.created_at;
            }
        });
    }

    // Logic Submission
    function submitEdit() {
        let room_id = $('#id-room').val();
        let formData = new FormData($('#form-edtrm')[0]);
        formData.append('_method', 'PUT');

        $.ajax({
            type: 'POST',
            url: '/rooms/update/'+room_id,
            headers: { 'X-CSRF-Token': '{{ csrf_token() }}' },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                // Using Alpine selector or just reload
                $("#success-message").text(response.data);
                $("#aler-success").removeClass("hidden").addClass("flex");
                setTimeout(() => { location.reload(); }, 1000);
            },
            error: function(err) {
                console.error("Update failed", err);
                let msg = err.responseJSON ? (err.responseJSON.message || err.responseJSON.data) : "Logic error: Failed to sync changes.";
                alert("Operation failed: " + msg);
            }
        });
    }
</script>
@endsection
