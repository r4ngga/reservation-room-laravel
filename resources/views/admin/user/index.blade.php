@extends('layouts.sidebar_layout')

@section('title', 'User Management')
@section('page_title', 'Management Users')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <button data-toggle="modal" data-target="#insert-user" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-sm">
            <i class="fas fa-user-plus mr-2 text-sm"></i>
            Add New User
        </button>
        
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" placeholder="Search users..." class="pl-10 pr-4 py-2.5 w-full md:w-64 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all">
        </div>
    </div>

    <!-- Feedback Alerts -->
    @if(session('notify'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm animate-fade-in-down">
         <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700 font-medium">{{ session('notify') }}</p>
        </div>
    </div>
    @endif

    <div id="ntf-success" class="hidden bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm" role="alert">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <p class="text-green-700 font-medium" id="success-msg-text"></p>
            </div>
            <button type="button" onclick="this.parentElement.parentElement.classList.add('hidden')" class="text-green-500 hover:text-green-700">
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
                    <tr class="hover:bg-gray-50/50 transition-colors group">
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
                                <button onclick="fetchShowUser({{ $usr->id_user }})" data-toggle="modal" data-target="#detailUsers" class="p-2 text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button data-toggle="modal" data-id="{{ $usr->id_user }}" data-target="#delUsers" class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm">
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
</div>

<!-- Ported Modals styled with Tailwind CSS -->

<!-- Detail Modal -->
<div class="modal fade" id="detailUsers" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-none shadow-2xl rounded-[2rem]">
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white">
                <h5 class="text-xl font-bold">User Profile Information</h5>
                <button type="button" class="text-white opacity-80 hover:opacity-100 transition-opacity" data-dismiss="modal">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div class="p-8">
                <div class="flex flex-col items-center mb-8">
                    <div class="w-24 h-24 rounded-full bg-indigo-50 flex items-center justify-center mb-4 border-4 border-white shadow-lg">
                        <i class="fas fa-user text-4xl text-indigo-600"></i>
                    </div>
                    <h4 id="u-name" class="text-2xl font-bold text-gray-800"></h4>
                    <p id="u-role" class="text-[10px] font-black uppercase tracking-widest text-indigo-500 bg-indigo-50 px-3 py-1 rounded-full mt-2"></p>
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
                    <div class="col-span-2 pt-4 border-t border-gray-50">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">System Membership Since</p>
                        <p id="u-created" class="text-xs text-gray-500 italic"></p>
                    </div>
                </div>
            </div>
            <div class="px-8 py-6 bg-gray-50 flex justify-end">
                <button type="button" class="px-6 py-2 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition-all shadow-sm" data-dismiss="modal">Dismiss</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="delUsers" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-none shadow-2xl rounded-[2rem]">
            <div class="p-10 text-center">
                <div class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6 transition-transform hover:rotate-12">
                    <i class="fas fa-user-minus"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-800 mb-2">Delete Account?</h3>
                <p class="text-gray-500 mb-8 px-6">You are about to remove this user from the system. This action is <span class="text-red-600 font-bold underline decoration-2">irreversible</span>.</p>
                
                <form action="" id="form-del-usr" method="POST" class="flex flex-col sm:flex-row gap-3">
                    <input type="hidden" name="id_users" id="id-users">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <button type="button" data-dismiss="modal" class="w-full py-3 bg-gray-50 text-gray-500 font-bold rounded-xl hover:bg-gray-100 transition-all uppercase tracking-widest text-xs">Stay Back</button>
                    <button id="btn-delete-usr" type="button" class="w-full py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-100 uppercase tracking-widest text-xs">Execute Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Insert User Modal -->
<div class="modal fade" id="insert-user" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered overflow-y-auto">
        <div class="modal-content overflow-hidden border-none shadow-2xl rounded-[2rem]">
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white">
                <h5 class="text-xl font-bold">Register New Account</h5>
                <button type="button" class="text-white opacity-80 hover:opacity-100 transition-opacity" data-dismiss="modal">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <form action="{{ route('users.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
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
                <div class="pt-4 border-t border-gray-50 flex justify-end gap-3">
                    <button type="button" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition-all shadow-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white font-black rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 uppercase tracking-widest text-xs">Create Member</button>
                </div>
            </form>
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
                document.getElementById('u-id').innerHTML = data.id;
                document.getElementById('u-name').innerHTML = data.name;
                document.getElementById('u-email').innerHTML = data.email;
                document.getElementById('u-adrs').innerHTML = data.address;
                document.getElementById('u-phone').innerHTML = data.phone_number;
                document.getElementById('u-gender').innerHTML = data.gender;
                document.getElementById('u-role').innerHTML = data.role;
                document.getElementById('u-created').innerHTML = data.created_at;
                document.getElementById('u-religion').innerHTML = data.religion;
            }
        });
    }

    // Pass data-id to modal
    $('#delUsers').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        modal.find('#id-users').val(id);
    });

    $("#btn-delete-usr").click( function() {
        let idusr = $('#id-users').val();
        let token = $('#token').val();

        $.ajax({
            type: 'POST',
            url: `/users/delete/` + idusr,
            data: {
                _token: token,
                id_users: idusr
            },
            success:function(data){
                $('#delUsers').modal('hide');
                $("#success-msg-text").text("User has been successfully purged from the archive.");
                $("#ntf-success").removeClass("hidden").addClass("flex animate-pulse");
                setTimeout(() => { location.reload(); }, 1500);
            }
        });
    });
</script>
@endsection
