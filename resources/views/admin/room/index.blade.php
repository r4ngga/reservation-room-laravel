@extends('layouts.sidebar_layout')

@section('title', 'Room Management')
@section('page_title', 'Management Rooms')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <a href="{{ route('rooms.add') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-sm">
            <i class="fas fa-plus mr-2 text-sm"></i>
            Add New Room
        </a>
        
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" placeholder="Search room..." class="pl-10 pr-4 py-2.5 w-full md:w-64 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all">
        </div>
    </div>

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
                    <tr class="hover:bg-gray-50/50 transition-colors group">
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
                                <button onclick="fetchShowRoom({{ $rm->number_room ?? '' }})" data-toggle="modal" data-target="#ShowDetailRoom" class="p-2 text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="fetchEdit({{ $rm->number_room ?? '' }})" data-toggle="modal" data-target="#editRoom" class="p-2 text-cyan-600 bg-cyan-50 rounded-lg hover:bg-cyan-600 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button data-toggle="modal" data-target="#DeleteRoom{{ $rm->number_room }}" class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm">
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

<!-- Ported Modals styled with Tailwind (Still using Bootstrap attributes for functionality) -->

<!-- Detail Modal -->
<div class="modal fade" id="ShowDetailRoom" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-none shadow-2xl rounded-[2rem]">
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white">
                <h5 class="text-xl font-bold">Room Detail Information</h5>
                <button type="button" class="text-white opacity-80 hover:opacity-100 transition-opacity" data-dismiss="modal">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Room Number</p>
                        <p id="r-number" class="text-lg font-bold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Class Type</p>
                        <p id="r-class" class="text-lg font-semibold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Facilities</p>
                        <p id="r-facility" class="text-sm text-gray-600"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Capacity</p>
                        <p id="r-capacity" class="text-lg font-bold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Price per Day</p>
                        <p id="r-price" class="text-lg font-bold text-green-600"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Current Status</p>
                        <p id="r-status" class="text-sm font-black uppercase tracking-tighter text-indigo-600"></p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Room Visualization</p>
                        <div class="h-48 w-full rounded-2xl bg-gray-100 overflow-hidden border border-gray-100 shadow-inner">
                            <img id="r-img" src="" class="w-full h-full object-cover" alt="Room preview">
                        </div>
                    </div>
                    <div class="col-span-2 text-xs text-gray-400 italic">
                        System created at: <span id="r-created"></span>
                    </div>
                </div>
            </div>
            <div class="px-8 py-6 bg-gray-50 flex justify-end">
                <button type="button" class="px-6 py-2 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition-all shadow-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editRoom" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered overflow-y-auto">
        <div class="modal-content overflow-hidden border-none shadow-2xl rounded-[2rem]">
            <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between text-white">
                <h5 class="text-xl font-bold">Adjust Room Data</h5>
                <button type="button" class="text-white opacity-80 hover:opacity-100 transition-opacity" data-dismiss="modal">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <form action="" id="form-edtrm" method="POST" enctype="multipart/form-data">
                <div class="p-8 space-y-6">
                    @csrf
                    <input type="hidden" id="id-room" value="">

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest" for="facility-room">Facility Listing</label>
                        <input type="text" name="facility" id="facility-room" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest" for="class-room">Room Class</label>
                            <select name="class" id="class-room" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                                <option value="1">VIP</option>
                                <option value="2">Premium</option>
                                <option value="3">Regular</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest" for="capacity-room">Max Capacity</label>
                            <input type="number" name="capacity" id="capacity-room" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest" for="price-room">Daily Pricing (IDR)</label>
                        <input type="number" name="price" id="price-room" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl font-mono text-lg text-indigo-600 focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                    </div>

                    <div class="space-y-4">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Photo Update</label>
                        <div class="flex items-start gap-4">
                            <div class="w-32 h-32 rounded-2xl bg-gray-100 overflow-hidden border border-gray-100 flex-shrink-0">
                                <img src="" id="img-rm" class="w-full h-full object-cover" alt="Preview">
                            </div>
                            <div class="flex-grow pt-2">
                                <label for="image_room" class="cursor-pointer inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-all text-xs font-bold uppercase tracking-widest shadow-sm">
                                    <i class="fas fa-upload mr-2"></i> Select File
                                </label>
                                <input type="file" name="image_room" id="image_room" class="hidden" onchange="previewImage(event);">
                                <p class="text-[10px] text-gray-400 mt-2">Recommended: 800x600px, max 2MB (JPG/PNG)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-8 py-6 bg-gray-50 flex justify-end gap-3">
                    <button type="button" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition-all shadow-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="btn-edtroom" class="px-8 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-all shadow-lg">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($rooms as $rm)
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="DeleteRoom{{ $rm->number_room }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-none shadow-2xl rounded-[2rem]">
            <div class="p-10 text-center">
                <div class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-800 mb-2">Are you sure?</h3>
                <p class="text-gray-500 mb-8 px-6">You are about to permanently remove Room <span class="text-red-600 font-bold">#{{ $rm->number_room }}</span>. This action cannot be undone.</p>
                
                <form action="{{ route('room.delete', $rm->number_room) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @method('delete')
                    @csrf
                    <button type="button" data-dismiss="modal" class="w-full py-3 bg-gray-50 text-gray-500 font-bold rounded-xl hover:bg-gray-100 transition-all uppercase tracking-widest text-xs">Stay Back</button>
                    <button type="submit" class="w-full py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-200 uppercase tracking-widest text-xs">Execute Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('scripts')
<script>
    const previewImage = (event) => {
      const imageFiles = event.target.files;
      if (imageFiles.length > 0) {
          const imageSrc = URL.createObjectURL(imageFiles[0]);
          document.querySelector("#img-rm").src = imageSrc;
          document.querySelector("#img-rm").style.display = "block";
      }
    };

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
                document.getElementById('id-room').value = data.number_room;
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
                document.getElementById('r-status').innerHTML = data.status;
                document.getElementById('r-img').src = data.image_room;
                document.getElementById('r-created').innerHTML = data.created_at;
            }
        });
    }

    $("#btn-edtroom").click(function(e) {
        e.preventDefault();
        let room_id = $('#id-room').val();
        let room_facility = $('#facility-room').val();
        let room_class = $('#class-room').val();
        let room_capacity = $('#capacity-room').val();
        let room_price = $('#price-room').val();
        
        // Since original logic didn't handle file upload via plain AJAX data object properly, 
        // and current implementation mixes them, I'll keep the AJAX structure but fix the UI response.
        $.ajax({
            type: 'POST',
            url: '/rooms/update/'+room_id ,
            headers: { 'X-CSRF-Token': '{{ csrf_token() }}' },
            data: {
                _token:"{{ csrf_token() }}",
                facility: room_facility,
                class: room_class,
                capacity: room_capacity,
                price: room_price
            },
            success: function(data){
                $('#editRoom').modal('hide');
                $("#success-message").text(data.data);
                $("#aler-success").removeClass("hidden").addClass("flex");
                setTimeout(() => { location.reload(); }, 1500); // Reload to show updated table info
            }
        });
    });
</script>
@endsection
