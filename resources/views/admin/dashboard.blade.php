@extends('layouts.sidebar_layout')

@section('title', 'Admin Dashboard')
@section('page_title', 'Admin Reservation Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- New Booking -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-gray-500 uppercase tracking-wider">New Booking</span>
                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-plus"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $reservations }}</h3>
                    <p class="text-xs text-green-500 font-semibold mt-1"><i class="fas fa-arrow-up mr-1"></i> 20%</p>
                </div>
                <a href="{{ route('reservation') }}" class="text-indigo-600 text-sm font-medium hover:underline">Details <i class="fas fa-chevron-right text-xs ml-1"></i></a>
            </div>
        </div>

        <!-- Rooms -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Rooms</span>
                <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $rooms }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Available Rooms</p>
                </div>
                <a href="{{ route('room') }}" class="text-orange-600 text-sm font-medium hover:underline">Details <i class="fas fa-chevron-right text-xs ml-1"></i></a>
            </div>
        </div>

        <!-- Paid Bookings -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-gray-500 uppercase tracking-wider">Paid Bookings</span>
                <div class="w-10 h-10 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $paidReservations }}</h3>
                    <p class="text-xs text-teal-600 font-semibold mt-1">Confirmed</p>
                </div>
                <a href="{{ route('reservation') }}" class="text-teal-600 text-sm font-medium hover:underline">Details <i class="fas fa-chevron-right text-xs ml-1"></i></a>
            </div>
        </div>

        <!-- Unpaid Bookings -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-gray-500 uppercase tracking-wider">Unpaid Bookings</span>
                <div class="w-10 h-10 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $unpaidReservations }}</h3>
                    <p class="text-xs text-rose-600 font-semibold mt-1">Pending Payment</p>
                </div>
                <a href="{{ route('reservation') }}" class="text-rose-600 text-sm font-medium hover:underline">Details <i class="fas fa-chevron-right text-xs ml-1"></i></a>
            </div>
        </div>
    </div>

    <!-- Visitor Statistics Chart -->
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-xl font-bold text-gray-800">Visitor Statistics</h3>
            <select class="bg-gray-50 border-none text-sm rounded-lg px-3 py-1.5 focus:ring-0">
                <option>Monthly</option>
                <option>Weekly</option>
            </select>
        </div>
        <div class="h-80 w-full relative">
            <canvas id="visitorChart"></canvas>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 pb-4 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-800">Recent Bookings</h3>
            <a href="{{ route('reservation') }}" class="text-indigo-600 text-sm font-semibold hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-8 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Booking Name</th>
                        <th class="px-8 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-8 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Venue / Room</th>
                        <th class="px-8 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-8 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentReservations as $rsv)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-4">
                            <div class="font-bold text-gray-800">{{ $rsv->name }}</div>
                            <div class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $rsv->code_reservation }}</div>
                        </td>
                        <td class="px-8 py-4">
                            @if($rsv->status_payment != '0' && $rsv->status_payment != 'unpaid')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wider">Booked</span>
                            @else
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-[10px] font-bold uppercase tracking-wider">Pending</span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-sm text-gray-600 font-medium">Room {{ $rsv->number_room }} ({{ $rsv->class }})</td>
                        <td class="px-8 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($rsv->time_booking)->format('d M Y') }}</td>
                        <td class="px-8 py-4 text-sm text-gray-500 font-mono">{{ $rsv->time_spend ?? '09.00-12.00' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-gray-400 italic">No bookings found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- All Users Count (Extra Card) -->
    <div class="bg-indigo-600 p-8 rounded-3xl shadow-lg flex items-center justify-between text-white">
        <div>
            <p class="text-indigo-100 text-sm font-medium uppercase tracking-wider">Total Active Users</p>
            <h2 class="text-5xl font-black mt-1">{{ $userCount }}</h2>
            <p class="text-indigo-200 text-xs mt-2 italic">*Excluding administrators</p>
        </div>
        <div class="text-6xl opacity-20">
            <i class="fas fa-users"></i>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('visitorChart').getContext('2d');
    
    // Gradient for the chart
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Visitors',
                data: [30, 45, 35, 60, 40, 50, 80, 55, 65, 45, 70, 90],
                borderColor: '#4f46e5',
                borderWidth: 4,
                fill: true,
                backgroundColor: gradient,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#4f46e5',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#1f2937',
                    bodyColor: '#4b5563',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' visitors';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6', drawBorder: false },
                    ticks: { color: '#9ca3af' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#9ca3af' }
                }
            }
        }
    });
</script>
@endsection
