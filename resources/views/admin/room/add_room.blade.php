@extends('layouts.sidebar_layout')

@section('title', 'Insert New Room')
@section('page_title', 'Create New Room')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Room Configuration</h3>
            <p class="text-sm text-gray-500 mt-1">Fill in the details below to add a new room to the inventory.</p>
        </div>
        <a href="{{ route('room') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
            <i class="fas fa-arrow-left mr-2 text-xs"></i>
            Back to List
        </a>
    </div>

    @if(session('notify'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm animate-fade-in-down">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                <p class="text-green-700 font-medium">{{ session('notify') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Room Number -->
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1" for="number_room">Room Identity (Number/Code)</label>
                    <input type="text" name="number_room" id="number_room" placeholder="e.g. 101, B-05" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                </div>

                <!-- Room Class -->
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1" for="class">Service Class</label>
                    <div class="relative">
                        <select name="class" id="class" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm appearance-none cursor-pointer">
                            <option value="" disabled selected>Select class level...</option>
                            <option value="1">VIP (Elite Suite)</option>
                            <option value="2">Premium (Business Plus)</option>
                            <option value="3">Regular (Standard)</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <!-- Capacity -->
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1" for="capacity">Guest Capacity</label>
                    <div class="relative">
                        <input type="number" name="capacity" id="capacity" placeholder="e.g. 2" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                        <span class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold uppercase">Persons</span>
                    </div>
                </div>

                <!-- Price -->
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1" for="price">Price per Night (IDR)</label>
                    <div class="relative">
                        <input type="number" name="price" id="price" placeholder="e.g. 500000" class="w-full px-12 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm font-mono text-lg text-indigo-600">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                    </div>
                </div>
            </div>

            <!-- Facility -->
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1" for="facility">Key Facilities & Amenities</label>
                <textarea name="facility" id="facility" rows="3" placeholder="List item facilities (e.g. WiFi, AC, King Bed, Minibar...)" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm"></textarea>
            </div>

            <!-- Image Upload -->
            <div class="space-y-4">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1 block">Room Presentation Photo</label>
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="w-full md:w-64 h-48 bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden relative group">
                        <img id="img-room" src="" class="w-full h-full object-cover hidden" alt="Room preview">
                        <div id="upload-placeholder" class="text-center p-6 transition-all group-hover:scale-110">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 mb-2"></i>
                            <p class="text-xs text-gray-400 font-medium">Click select to preview photo</p>
                        </div>
                    </div>
                    
                    <div class="flex-grow space-y-4 w-full">
                        <label for="image_room" class="flex items-center justify-center px-6 py-3 bg-indigo-50 text-indigo-700 font-bold rounded-2xl border-2 border-indigo-100 hover:bg-indigo-100 transition-all cursor-pointer shadow-sm">
                            <i class="fas fa-image mr-3"></i>
                            Choose Room Photo
                        </label>
                        <input type="file" name="image_room" id="image_room" class="hidden" onchange="prevImage(event);">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-3 rounded-xl">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-tighter mb-1">Max Weight</p>
                                <p class="text-xs font-bold text-gray-600">2.0 Megabytes</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-xl">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-tighter mb-1">Formats</p>
                                <p class="text-xs font-bold text-gray-600">JPG, PNG, WEBP</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="inline-flex items-center px-10 py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 uppercase tracking-widest text-sm">
                    Register Room
                    <i class="fas fa-check-circle ml-3"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const prevImage = (event) => {
      const imageFiles = event.target.files;
      if (imageFiles.length > 0) {
          const imageSrc = URL.createObjectURL(imageFiles[0]);
          const preview = document.querySelector("#img-room");
          const placeholder = document.querySelector("#upload-placeholder");
          
          preview.src = imageSrc;
          preview.classList.remove('hidden');
          placeholder.classList.add('hidden');
      }
    };
</script>
@endsection
