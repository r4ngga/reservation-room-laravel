@extends('layouts.sidebar_layout')

@section('title', 'Religion Management')
@section('page_title', 'Master Religions Data')

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
    deleteName: '',
    search: ''
}" class="space-y-6" x-cloak>
    
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 items-start w-full">
        <button @click="showAdd = true" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 group w-fit">
            <i class="fas fa-plus mr-2 text-xs transition-transform group-hover:rotate-90"></i>
            Add New Religion
        </button>
        
        <div class="relative group w-fit min-w-[300px]">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-500 transition-colors pointer-events-none">
                <i class="fas fa-search text-sm"></i>
            </span>
            <input type="text" x-model="search" placeholder="Search religion..." class="pl-11 pr-4 py-3 w-full bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm placeholder:text-gray-400 text-sm font-medium">
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

    <!-- Religions Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">No</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Name</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Description</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="religion-table-body" class="divide-y divide-gray-50 tracking-tighter">
                    @foreach($religions as $key => $rg)
                    <tr x-show="search === '' || '{{ strtolower($rg->name) }}'.includes(search.toLowerCase())" class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <span class="text-[10px] font-black bg-gray-100 text-gray-500 px-2 py-0.5 rounded tracking-normal">#{{ $key + 1 }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-gray-800 font-bold">{{ $rg->name }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-gray-500 text-sm">{{ $rg->description ?? '-' }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center space-x-2">
                                <button @click="fetchShow({{ $rg->id }}); showDetail = true" class="p-2 text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="View Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button @click="fetchEdit({{ $rg->id }}); showEdit = true" class="p-2 text-cyan-600 bg-cyan-50 rounded-lg hover:bg-cyan-600 hover:text-white transition-all shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button @click="deleteId = {{ $rg->id }}; deleteName = '{{ $rg->name }}'; showDelete = true" class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Delete">
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

    <!-- Add Modal -->
    <div x-show="showAdd" class="modal-overlay" x-cloak @keydown.escape.window="showAdd = false"
         x-init="$watch('showAdd', val => {
            if (val) document.body.classList.add('modal-prevent-scroll');
            else if (!showDetail && !showEdit && !showDelete) document.body.classList.remove('modal-prevent-scroll');
         })">
        <div @click="showAdd = false" class="fixed inset-0"></div>
        <div class="modal-container">
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center"><i class="fas fa-plus"></i></div>
                    <div>
                        <h5 class="text-xl font-bold leading-none">New Religion</h5>
                        <p class="text-[10px] text-indigo-100 mt-1 uppercase tracking-widest font-medium">Add to master data</p>
                    </div>
                </div>
                <button @click="showAdd = false" class="text-white opacity-80 hover:opacity-100 transition-opacity"><i class="fas fa-times text-lg"></i></button>
            </div>
            <form action="{{ route('religions.store') }}" method="POST">
                @csrf
                <div class="p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Religion Name</label>
                        <input type="text" name="name" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" placeholder="e.g. Islam" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Description (Optional)</label>
                        <textarea name="description" rows="3" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" placeholder="Additional details..."></textarea>
                    </div>
                </div>
                <div class="px-8 py-6 bg-gray-50 flex justify-end gap-3 sticky bottom-0">
                    <button type="button" @click="showAdd = false" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition-all shadow-sm">Cancel</button>
                    <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white font-black rounded-xl hover:bg-indigo-700 transition-all shadow-lg uppercase tracking-widest text-xs">Save Religion</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Detail Modal -->
    <div x-show="showDetail" class="modal-overlay" x-cloak @keydown.escape.window="showDetail = false"
         x-init="$watch('showDetail', val => {
            if (val) document.body.classList.add('modal-prevent-scroll');
            else if (!showAdd && !showEdit && !showDelete) document.body.classList.remove('modal-prevent-scroll');
         })">
        <div @click="showDetail = false" class="fixed inset-0"></div>
        <div class="modal-container">
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center"><i class="fas fa-info-circle text-lg"></i></div>
                    <div>
                        <h5 class="text-xl font-bold leading-none">Religion Detail</h5>
                        <p class="text-[10px] text-indigo-100 mt-1 uppercase tracking-widest font-medium">Asset profiling</p>
                    </div>
                </div>
                <button @click="showDetail = false" class="text-white opacity-80 hover:opacity-100 transition-opacity"><i class="fas fa-times text-lg"></i></button>
            </div>
            <div class="p-8">
                <div class="space-y-6">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-l-2 border-indigo-200 pl-2">Name</p>
                        <p id="d-name" class="text-2xl font-black text-gray-800"></p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-l-2 border-amber-200 pl-2">Description</p>
                        <p id="d-description" class="text-lg text-gray-600"></p>
                    </div>
                    <div class="pt-4 border-t border-gray-50">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Created At</p>
                        <p id="d-created" class="text-xs text-gray-500 italic"></p>
                    </div>
                </div>
            </div>
            <div class="px-8 py-6 bg-gray-50 flex justify-end">
                <button @click="showDetail = false" class="px-8 py-3 bg-white border border-gray-200 text-gray-600 font-extrabold rounded-xl hover:bg-gray-100 transition-all shadow-sm uppercase tracking-widest text-[10px]">Close</button>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEdit" class="modal-overlay" x-cloak @keydown.escape.window="showEdit = false"
         x-init="$watch('showEdit', val => {
            if (val) document.body.classList.add('modal-prevent-scroll');
            else if (!showAdd && !showDetail && !showDelete) document.body.classList.remove('modal-prevent-scroll');
         })">
        <div @click="showEdit = false" class="fixed inset-0"></div>
        <div class="modal-container">
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center"><i class="fas fa-edit"></i></div>
                    <div>
                        <h5 class="text-xl font-bold leading-none">Modify Religion</h5>
                        <p class="text-[10px] text-indigo-100 mt-1 uppercase tracking-widest font-medium">Update master data</p>
                    </div>
                </div>
                <button @click="showEdit = false" class="text-white opacity-80 hover:opacity-100 transition-opacity"><i class="fas fa-times text-lg"></i></button>
            </div>
            <form id="form-edit-religion" @submit.prevent="submitEdit">
                @csrf
                <input type="hidden" id="edit-id">
                <div class="p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Religion Name</label>
                        <input type="text" name="name" id="edit-name" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Description (Optional)</label>
                        <textarea name="description" id="edit-description" rows="3" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm"></textarea>
                    </div>
                </div>
                <div class="px-8 py-6 bg-gray-50 flex justify-end gap-3 sticky bottom-0">
                    <button type="button" @click="showEdit = false" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition-all shadow-sm">Discard</button>
                    <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white font-black rounded-xl hover:bg-indigo-700 transition-all shadow-lg uppercase tracking-widest text-xs">Commit Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="showDelete" class="modal-overlay" x-cloak @keydown.escape.window="showDelete = false"
         x-init="$watch('showDelete', val => {
            if (val) document.body.classList.add('modal-prevent-scroll');
            else if (!showAdd && !showDetail && !showEdit) document.body.classList.remove('modal-prevent-scroll');
         })">
        <div @click="showDelete = false" class="fixed inset-0"></div>
        <div class="modal-container max-w-md">
            <div class="p-10 text-center">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-6 shadow-sm"><i class="fas fa-trash-alt"></i></div>
                <h3 class="text-2xl font-black text-gray-800 mb-2">Delete Religion?</h3>
                <p class="text-gray-500 mb-8 px-6 text-sm leading-relaxed">Remove <span class="text-red-600 font-bold" x-text="deleteName"></span>? This action is reversible via soft-delete logic.</p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" @click="showDelete = false" class="w-full py-4 bg-gray-50 text-gray-500 font-bold rounded-2xl hover:bg-gray-100 transition-all uppercase tracking-widest text-xs">Cancel</button>
                    <button @click="submitDelete" type="button" class="w-full py-4 bg-red-600 text-white font-bold rounded-2xl hover:bg-red-700 transition-all shadow-xl uppercase tracking-widest text-xs">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function fetchShow(id){
        $.ajax({
            type: 'GET',
            url: '/religions/' + id,
            success:function(data){
                document.getElementById('d-name').innerHTML = data.name;
                document.getElementById('d-description').innerHTML = data.description ?? '-';
                document.getElementById('d-created').innerHTML = data.created_at;
            }
        });
    }

    function fetchEdit(id){
        $.ajax({
            type: 'GET',
            url: '/religions-edit/' + id,
            success:function(data){
                document.getElementById('edit-id').value = data.id;
                document.getElementById('edit-name').value = data.name;
                document.getElementById('edit-description').value = data.description ?? '';
            }
        });
    }

    function submitEdit() {
        let id = $('#edit-id').val();
        let formData = new FormData($('#form-edit-religion')[0]);
        $.ajax({
            type: 'POST',
            url: '/religions/update/' + id,
            headers: { 'X-CSRF-Token': '{{ csrf_token() }}' },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                $("#success-msg-text").text(response.message);
                $("#ntf-success").removeClass("hidden").addClass("flex");
                setTimeout(() => { location.reload(); }, 1000);
            }
        });
    }

    function submitDelete() {
        let alpineData = document.querySelector('[x-data]').__x ? document.querySelector('[x-data]').__x.$data : Alpine.$data(document.querySelector('[x-data]'));
        let id = alpineData.deleteId;
        $.ajax({
            type: 'DELETE',
            url: `/religions/` + id,
            headers: { 'X-CSRF-Token': '{{ csrf_token() }}' },
            success:function(response){
                alpineData.showDelete = false;
                $("#success-msg-text").text(response.message);
                $("#ntf-success").removeClass("hidden").addClass("flex");
                setTimeout(() => { location.reload(); }, 1000);
            }
        });
    }
</script>
@endsection
