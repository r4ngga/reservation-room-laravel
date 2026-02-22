@extends('layouts.sidebar_layout')

@section('title', 'Audit Trails')
@section('page_title', 'Audit Trails & Logs')

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
        max-width: 40rem;
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
    showDetail: false,
    selectedLog: null,
    search: ''
}" class="space-y-6" x-cloak>
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-3xl p-6 text-white shadow-xl" style="background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 50%, #a855f7 100%);">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-200 text-[10px] font-bold uppercase tracking-widest">Total Logs</p>
                    <p class="text-4xl font-black mt-1">{{ $countlogs ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-white/25 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-history text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="rounded-3xl p-6 text-white shadow-xl" style="background: linear-gradient(135deg, #059669 0%, #14b8a6 50%, #06b6d4 100%);">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-[10px] font-bold uppercase tracking-widest">Admin Actions</p>
                    <p class="text-4xl font-black mt-1">{{ $logs->where('role', 1)->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-white/25 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-user-shield text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="rounded-3xl p-6 text-white shadow-xl" style="background: linear-gradient(135deg, #ea580c 0%, #f59e0b 50%, #eab308 100%);">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-[10px] font-bold uppercase tracking-widest">User Actions</p>
                    <p class="text-4xl font-black mt-1">{{ $logs->where('role', 2)->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-white/25 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="relative group w-fit min-w-[300px]">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-500 transition-colors pointer-events-none">
            <i class="fas fa-search text-sm"></i>
        </span>
        <input type="text" x-model="search" placeholder="Search logs by action or description..." class="pl-11 pr-4 py-3 w-full bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm placeholder:text-gray-400 text-sm font-medium">
    </div>

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

    <!-- Logs Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">ID</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Action</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">User</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Description</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Time</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php
                        $action_colors = [
                            'POST' => 'bg-green-100 text-green-700',
                            'PUT' => 'bg-amber-100 text-amber-700',
                            'delete' => 'bg-red-100 text-red-700',
                            'GET' => 'bg-blue-100 text-blue-700'
                        ];
                    @endphp
                    @foreach($logs as $log)
                    <tr x-show="search === '' || '{{ strtolower($log->action) }} {{ strtolower($log->description) }}'.includes(search.toLowerCase())" class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <span class="text-[10px] font-black bg-gray-100 text-gray-500 px-2 py-0.5 rounded">#{{ $log->id }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $action_colors[$log->action] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full {{ $log->role == 1 ? 'bg-indigo-50 text-indigo-600' : 'bg-amber-50 text-amber-600' }} flex items-center justify-center font-bold text-xs mr-2">
                                    <i class="fas {{ $log->role == 1 ? 'fa-shield-alt' : 'fa-user' }}"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-800">{{ $log->role == 1 ? 'Admin' : 'User' }}</p>
                                    <p class="text-[10px] text-gray-500">ID: {{ $log->user_id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-gray-600 text-sm">{{ $log->description }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($log->log_time)->format('M d, Y H:i') }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center">
                                <button @click="fetchShowLog({{ $log->id }}); showDetail = true" class="p-2 text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($logs->isEmpty())
        <div class="text-center py-16">
            <div class="w-20 h-20 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <p class="text-gray-500 font-medium">No audit trails found</p>
            <p class="text-gray-400 text-sm mt-1">System activity will appear here</p>
        </div>
        @endif
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
            else document.body.classList.remove('modal-prevent-scroll');
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

            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-history text-lg"></i>
                    </div>
                    <div>
                        <h5 class="text-xl font-bold leading-none">Audit Trail Details</h5>
                        <p class="text-[10px] text-indigo-100 mt-1 uppercase tracking-widest font-medium">Activity Intelligence</p>
                    </div>
                </div>
                <button @click="showDetail = false" class="text-white opacity-80 hover:opacity-100 transition-opacity">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div class="p-8">
                <div class="space-y-6">
                    <!-- Log ID & Action -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-l-2 border-indigo-200 pl-2">Log Reference</p>
                            <p id="detail-id" class="text-lg font-black text-gray-800">#</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-l-2 border-green-200 pl-2">Action Type</p>
                            <p id="detail-action" class="text-lg font-bold text-gray-700"></p>
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="flex-grow">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Performed By</p>
                            <p id="detail-user" class="font-bold text-gray-800"></p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Role</p>
                            <p id="detail-role" class="text-sm font-semibold text-gray-700"></p>
                        </div>
                    </div>

                    <!-- Description & Time -->
                    <div class="grid grid-cols-1 gap-4">
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-l-2 border-amber-200 pl-2">Description</p>
                            <p id="detail-description" class="text-sm text-gray-700"></p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-l-2 border-cyan-200 pl-2">Timestamp</p>
                            <p id="detail-time" class="text-sm font-mono text-gray-600"></p>
                        </div>
                    </div>

                    <!-- Data Changes -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Before Changes</p>
                            <div id="detail-data-old" class="bg-red-50 p-4 rounded-xl border border-red-100 min-h-[100px] max-h-[200px] overflow-y-auto">
                                <p class="text-red-400 text-sm italic">No data</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">After Changes</p>
                            <div id="detail-data-new" class="bg-green-50 p-4 rounded-xl border border-green-100 min-h-[100px] max-h-[200px] overflow-y-auto">
                                <p class="text-green-400 text-sm italic">No data</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-8 py-6 bg-gray-50 flex justify-end sticky bottom-0 border-t border-gray-100">
                <button @click="showDetail = false" class="px-8 py-3 bg-white border border-gray-200 text-gray-600 font-extrabold rounded-xl hover:bg-gray-100 transition-all shadow-sm uppercase tracking-widest text-[10px]">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function fetchShowLog(id) {
        $.ajax({
            type: 'GET',
            url: '/fetchlogs/' + id,
            success: function(data) {
                let parsedata = JSON.parse(data);

                document.getElementById('detail-id').innerHTML = '#' + parsedata.id;
                document.getElementById('detail-action').innerHTML = parsedata.action;
                document.getElementById('detail-user').innerHTML = parsedata.name + ' (ID: ' + parsedata.user_id + ')';
                document.getElementById('detail-role').innerHTML = parsedata.role;
                document.getElementById('detail-description').innerHTML = parsedata.description;
                document.getElementById('detail-time').innerHTML = parsedata.log_time;

                // Data Old
                let dataOldContainer = document.getElementById('detail-data-old');
                if (parsedata.data_old !== null) {
                    let obj = parsedata.data_old;
                    let html = '<ul class="space-y-1">';
                    for (const key of Object.keys(obj)) {
                        let value = (obj[key] !== null && obj[key] !== '') ? obj[key] : '-';
                        html += '<li class="text-xs"><span class="font-semibold text-red-700">' + key + ':</span> <span class="text-red-600">' + value + '</span></li>';
                    }
                    html += '</ul>';
                    dataOldContainer.innerHTML = html;
                } else {
                    dataOldContainer.innerHTML = '<p class="text-red-400 text-sm italic">No previous data</p>';
                }

                // Data New
                let dataNewContainer = document.getElementById('detail-data-new');
                if (parsedata.data_new !== null) {
                    let obj = parsedata.data_new;
                    let html = '<ul class="space-y-1">';
                    for (const key of Object.keys(obj)) {
                        let value = (obj[key] !== null && obj[key] !== '') ? obj[key] : '-';
                        html += '<li class="text-xs"><span class="font-semibold text-green-700">' + key + ':</span> <span class="text-green-600">' + value + '</span></li>';
                    }
                    html += '</ul>';
                    dataNewContainer.innerHTML = html;
                } else {
                    dataNewContainer.innerHTML = '<p class="text-green-400 text-sm italic">No new data</p>';
                }
            },
            error: function(err) {
                console.error('Failed to fetch log details:', err);
                alert('Failed to load log details. Please try again.');
            }
        });
    }
</script>
@endsection
