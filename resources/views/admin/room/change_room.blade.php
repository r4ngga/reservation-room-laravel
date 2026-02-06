@extends('layouts.sidebar_layout')

@section('title', 'Change Data Room')
@section('page_title', 'Update Room Archive')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Room Modification</h3>
            <p class="text-sm text-gray-500 mt-1">Editing details for Room <span class="text-indigo-600 font-bold">#{{ $room->number_room }}</span></p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('room') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                <i class="fas fa-arrow-left mr-2 text-xs"></i>
                Back
            </a>
        </div>
    </div>

    @if(session('notify'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm animate-fade-in-down">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
            <p class="text-green-700 font-medium">{{ session('notify') }}</p>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <form action="/rooms/{{ $room->number_room }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
            @method('patch')
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Facility -->
                <div class="col-span-2 space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1" for="facility">Facilities Description</label>
                    <textarea name="facility" id="facility" rows="3" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">{{ $room->facility }}</textarea>
                </div>

                <!-- Class -->
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1" for="class">Room Tier</label>
                    <div class="relative">
                        <select name="class" id="class" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm appearance-none cursor-pointer">
                            <option value="1" {{ $room->class == 1 ? 'selected' : '' }}>VIP</option>
                            <option value="2" {{ $room->class == 2 ? 'selected' : '' }}>Premium</option>
                            <option value="3" {{ $room->class == 3 ? 'selected' : '' }}>Regular</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <!-- Capacity -->
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1" for="capacity">Guest Limit</label>
                    <input type="number" name="capacity" id="capacity" value="{{ $room->capacity }}" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                </div>

                <!-- Price -->
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1" for="price">Pricing (IDR)</label>
                    <input type="number" name="price" id="price" value="{{ $room->price }}" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm font-mono text-lg text-indigo-600">
                </div>
                
                <!-- Status -->
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Availability Status</label>
                    <div class="flex items-center gap-2">
                        @php $status_labels = ['Free', 'Full', 'Booking']; @endphp
                        @php $status_colors = ['bg-green-100 text-green-700', 'bg-red-100 text-red-700', 'bg-amber-100 text-amber-700']; @endphp
                        <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-widest {{ $status_colors[$room->status] ?? 'bg-gray-100' }}">
                            {{ $status_labels[$room->status] ?? 'Unknown' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Current Image & Upload -->
            <div class="pt-6 border-t border-gray-100 space-y-4">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1 block">Room Asset Visualization</label>
                <div class="flex flex-col md:flex-row items-center gap-10">
                    <div class="relative w-full md:w-80 h-56 bg-gray-50 rounded-[2.5rem] border-4 border-white shadow-xl overflow-hidden group">
                        <img src="/images/{{ $room->image_room }}" id="img-preview" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Current image">
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <i class="fas fa-search-plus text-white text-2xl"></i>
                        </div>
                    </div>

                    <div class="flex-grow space-y-4">
                        <div class="bg-indigo-50 p-6 rounded-3xl border border-indigo-100">
                            <h4 class="text-sm font-bold text-indigo-900 mb-2">Change Image?</h4>
                            <p class="text-[11px] text-indigo-600 mb-4 opacity-80 leading-relaxed">Uploading a new file will permanently replace the existing room visual asset.</p>
                            
                            <label for="image_room" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-indigo-700 transition-all cursor-pointer shadow-lg shadow-indigo-200">
                                <i class="fas fa-camera mr-2"></i>
                                New Upload
                            </label>
                            <input type="file" name="image_room" id="image_room" class="hidden" onchange="previewImage(event);">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-10 flex items-center justify-between">
                <button type="submit" class="px-12 py-4 bg-gray-900 text-white font-black rounded-2xl hover:bg-black transition-all shadow-xl uppercase tracking-widest text-sm">
                    Commit Changes
                </button>
                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-widest italic">Last Sync: {{ $room->updated_at->diffForHumans() }}</p>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const imageFiles = event.target.files;
        if (imageFiles.length > 0) {
            const imageSrc = URL.createObjectURL(imageFiles[0]);
            document.querySelector("#img-preview").src = imageSrc;
        }
    }
</script>
@endsection
