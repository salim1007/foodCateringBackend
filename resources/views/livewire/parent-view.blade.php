<div>
    <nav class="bg-orange-400 p-4 flex items-center justify-between">
        <div>
            <h1 class="text-white text-xl font-semibold">YDDE RESTAURANT</h1>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-white font-bold">Welcome, Admin</span>
            <i class="fas fa-user-circle text-white text-2xl"></i>
        </div>
    </nav>

    <!-- Navegación lateral -->
    <div class="flex flex-row ">
        <aside class="bg-gray-700 text-white w-64 min-h-screen p-4">
            <nav>
                <ul class="space-y-2">
                    <li class="opcion-con-desplegable">
                        <button wire:click='gotoDashboard' class="flex items-center  w-full justify-between p-2 hover:bg-gray-500 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>Dashboard</span>
                            </div>
                        </button>

                    </li>
                    <li class="opcion-con-desplegable">
                        <button wire:click='gotoSales' class="flex items-center justify-between  w-full p-2 hover:bg-gray-500 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-money-bill-wave mr-2"></i>
                                <span>Sales</span>
                            </div>

                        </button>

                    </li>
                    <li class="opcion-con-desplegable">
                        <button wire:click='gotoNotification' class="flex items-center justify-between  w-full p-2 hover:bg-gray-500 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-chart-bar mr-2"></i>
                                <span>Notification</span>
                            </div>

                        </button>

                    </li>
                    <li class="opcion-con-desplegable">
                        <button wire:click='gotoCouriers' class="flex items-center justify-between  w-full p-2 hover:bg-gray-500 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                <span>Couriers</span>
                            </div>

                        </button>

                    </li>
                    <li class="opcion-con-desplegable">
                        <button wire:click='gotoOrders' class="flex items-center justify-between  w-full p-2 hover:bg-gray-500 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-truck mr-2"></i>

                                <span>Orders</span>
                            </div>

                        </button>

                    </li>
                    <li class="opcion-con-desplegable">
                        <button wire:click='gotoBookings' class="flex items-center justify-between  w-full p-2 hover:bg-gray-500 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt mr-2"></i>
                                <span>Bookings</span>
                            </div>

                        </button>

                    </li>
                </ul>
            </nav>
        </aside>
        <div class="flex w-full ">
            @if ($showDashboard)
            <livewire:admin-pages.dashboard>

            @elseif ($showSales)
            <livewire:admin-pages.sales>

            @elseif ($showNotification)
            <livewire:admin-pages.notification>

            @elseif ($showCouriers)
            <livewire:admin-pages.couriers>

            @elseif ($showOrders)
            <livewire:admin-pages.orders>

            @elseif ($showBookings)
            <livewire:admin-pages.bookings>
           
            @endif
        </div>
    </div>


    <main class="container mx-auto p-4">

        {{-- footer here --}}
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
       
          const opcionesConDesplegable = document.querySelectorAll(".opcion-con-desplegable");
    
          
          opcionesConDesplegable.forEach(function (opcion) {
            opcion.addEventListener("click", function () {
              // Obtener el desplegable asociado a la opción
              const desplegable = opcion.querySelector(".desplegable");
    
              // Alternar la clase "hidden" para mostrar u ocultar el desplegable
              desplegable.classList.toggle("hidden");
            });
          });
        });
    </script>
</div>